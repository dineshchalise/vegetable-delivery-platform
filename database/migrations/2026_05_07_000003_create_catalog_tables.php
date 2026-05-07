<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hubs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo_url')->nullable();
            $table->text('address');
            $table->string('contact_number');
            $table->string('pickup_timings');
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->decimal('price', 10, 2);
            $table->string('unit', 20);
            $table->decimal('stock_quantity', 10, 2)->default(0);
            $table->string('image_url')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('hubs');
    }
};
