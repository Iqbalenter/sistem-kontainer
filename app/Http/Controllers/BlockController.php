<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Delivery;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function showBlockA()
    {
        $block = Block::where('name', 'A')->firstOrFail();
        $containers = Delivery::where('block_id', $block->id)
            ->where('status', 'confirmed')
            ->with('user')
            ->get();

        return view('admin.block-a', compact('block', 'containers'));
    }

    public function showBlockB()
    {
        $block = Block::where('name', 'B')->firstOrFail();
        $containers = Delivery::where('block_id', $block->id)
            ->where('status', 'confirmed')
            ->with('user')
            ->get();

        return view('admin.block-b', compact('block', 'containers'));
    }

    public function showBlockC()
    {
        $block = Block::where('name', 'C')->firstOrFail();
        $containers = Delivery::where('block_id', $block->id)
            ->where('status', 'confirmed')
            ->with('user')
            ->get();

        return view('admin.block-c', compact('block', 'containers'));
    }

    public function showBlockD()
    {
        $block = Block::where('name', 'D')->firstOrFail();
        $containers = Delivery::where('block_id', $block->id)
            ->where('status', 'confirmed')
            ->with('user')
            ->get();

        return view('admin.block-d', compact('block', 'containers'));
    }

    public function showBlockE()
    {
        $block = Block::where('name', 'E')->firstOrFail();
        $containers = Delivery::where('block_id', $block->id)
            ->where('status', 'confirmed')
            ->with('user')
            ->get();

        return view('admin.block-e', compact('block', 'containers'));
    }

    public function removeContainer($blockName, Delivery $delivery)
    {
        try {
            // Dapatkan block yang dimaksud
            $block = Block::where('name', $blockName)->firstOrFail();
            
            // Pastikan container ada di block yang dimaksud
            if ($delivery->block_id !== $block->id) {
                throw new \Exception('Container tidak ditemukan di block ini.');
            }

            // Update delivery
            $delivery->update([
                'status' => 'pending',
                'block_id' => null
            ]);

            // Update block
            $block->current_capacity = max(0, $block->current_capacity - 1);
            
            // Reset tipe block jika kosong
            if ($block->current_capacity === 0) {
                $block->current_type = null;
            }
            
            $block->is_full = false;
            $block->save();

            return response()->json([
                'message' => 'Container berhasil dihapus dari block.',
                'block' => $block
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 422);
        }
    }
} 