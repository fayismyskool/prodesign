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
        Schema::create('shop_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone', 20);
            $table->string('pincode', 10);
            $table->string('city');
            $table->string('state');
            $table->string('country')->default('India');
            $table->text('address');
            $table->string('address_type')->default('Home');
            $table->string('payment_method')->default('razorpay');
            $table->string('payment_id')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->enum('order_status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->double('subtotal', 10, 2)->default(0);
            $table->double('shipping_cost', 10, 2)->default(0);
            $table->double('discount', 10, 2)->default(0);
            $table->double('total_amount', 10, 2)->default(0);
            $table->string('currency', 10)->default('INR');
            $table->string('tracking_number')->nullable();
            $table->string('courier_partner')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('shop_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_order_id')->constrained('shop_orders')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable()->index();
            $table->string('product_title');
            $table->string('product_image')->nullable();
            $table->double('unit_price', 10, 2)->default(0);
            $table->integer('quantity')->default(1);
            $table->double('total_price', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_order_items');
        Schema::dropIfExists('shop_orders');
    }
};
