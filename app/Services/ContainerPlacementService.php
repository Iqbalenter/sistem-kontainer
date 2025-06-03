<?php

namespace App\Services;

use App\Models\Block;
use App\Models\Delivery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContainerPlacementService
{
    public function assignBlock(Delivery $delivery)
    {
        Log::info('Assigning block for delivery: ' . $delivery->id);

        return DB::transaction(function () use ($delivery) {
            // Cari block yang sudah memiliki tipe yang sama
            $block = Block::where('current_type', $delivery->liquid_status)
                ->where('is_full', false)
                ->lockForUpdate()
                ->first();

            // Jika tidak ada block dengan tipe yang sama, cari block kosong
            if (!$block) {
                $block = Block::whereNull('current_type')
                    ->where('current_capacity', 0)
                    ->where('is_full', false)
                    ->lockForUpdate()
                    ->first();

                if ($block) {
                    // Set tipe block sesuai dengan container pertama
                    $block->current_type = $delivery->liquid_status;
                }
            }

            if (!$block) {
                Log::error('No available block found for delivery: ' . $delivery->id);
                throw new \Exception('Tidak ada block yang tersedia untuk tipe muatan ini.');
            }

            // Increment kapasitas
            $block->current_capacity++;
            
            // Update status block jika sudah penuh
            if ($block->current_capacity >= $block->max_capacity) {
                $block->is_full = true;
            }
            
            $block->save();

            Log::info('Block assigned: ' . $block->name . ' for delivery: ' . $delivery->id);
            Log::info('Block ' . $block->name . ' capacity increased to: ' . $block->current_capacity);

            return $block;
        });
    }

    public function releaseBlock(Delivery $delivery)
    {
        Log::info('Releasing block for delivery: ' . $delivery->id);

        return DB::transaction(function () use ($delivery) {
            $block = $delivery->block;
            
            if (!$block) {
                Log::info('No block found for delivery: ' . $delivery->id);
                return;
            }

            // Kurangi kapasitas
            $block->current_capacity = max(0, $block->current_capacity - 1);
            
            // Jika block kosong, reset tipenya
            if ($block->current_capacity === 0) {
                $block->current_type = null;
            }
            
            $block->is_full = false;
            $block->save();
            
            Log::info('Block ' . $block->name . ' released for delivery: ' . $delivery->id);
            Log::info('Block ' . $block->name . ' capacity decreased to: ' . $block->current_capacity);

            return $block;
        });
    }
} 