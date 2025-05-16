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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key (auto-incrementing BigInt)
            $table->string('name');
            $table->string('category'); // You might want a separate categories table later
            $table->text('description');
            $table->decimal('price', 8, 2); // Precision 8, 2 decimal places
            $table->string('image_path')->nullable(); // To store the path to the uploaded image
            $table->integer('stock_quantity')->default(0);
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};