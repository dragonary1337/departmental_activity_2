<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('equipment_name');
            $table->enum('category', ['paddles', 'balls', 'nets', 'accessories']);
            $table->decimal('unit_price', 10, 2)->unsigned();
            $table->text('description');
            $table->enum('availability_status', ['available', 'unavailable']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
