<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // A, B, C, D
            $table->enum('current_type', ['cair', 'non-cair'])->nullable();
            $table->integer('current_capacity')->default(0);
            $table->integer('max_capacity')->default(20);
            $table->boolean('is_full')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
}; 