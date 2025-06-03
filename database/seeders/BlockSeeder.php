<?php

namespace Database\Seeders;

use App\Models\Block;
use Illuminate\Database\Seeder;

class BlockSeeder extends Seeder
{
    public function run(): void
    {
        $blocks = [
            ['name' => 'A', 'current_type' => null, 'current_capacity' => 0, 'max_capacity' => 20],
            ['name' => 'B', 'current_type' => null, 'current_capacity' => 0, 'max_capacity' => 20],
            ['name' => 'C', 'current_type' => null, 'current_capacity' => 0, 'max_capacity' => 20],
            ['name' => 'D', 'current_type' => null, 'current_capacity' => 0, 'max_capacity' => 20],
            ['name' => 'E', 'current_type' => null, 'current_capacity' => 0, 'max_capacity' => 20],
        ];

        foreach ($blocks as $block) {
            Block::create($block);
        }
    }
} 