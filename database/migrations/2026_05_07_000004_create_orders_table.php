<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_mobile')->index();
            $table->string('customer_name');
            $table->text('customer_address');
            $table->foreignId('hub_id')->constrained()->restrictOnDelete();
            $table->enum('status', ['received', 'packing', 'ready_at_hub', 'out_for_delivery', 'completed', 'cancelled'])->default('received')->index();
            $table->enum('payment_method', ['cod', 'online'])->default('cod');
            $table->enum('payment_status', ['pending', 'paid'])->default('pending');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->string('product_name');
            $table->decimal('product_price', 10, 2);
            $table->decimal('quantity', 10, 2);
            $table->decimal('subtotal', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
