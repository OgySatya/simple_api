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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('costomer_name', 100);
            $table->string('table_number', 10);
            $table->time('order_time');
            $table->string('status', 100);
            $table->integer('total_price')->unsigned();
            $table->unsignedBigInteger('waiter_id');
            $table->unsignedBigInteger('chef_id')->nullable();
            $table->unsignedBigInteger('cashier_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('waiter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('chef_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cashier_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
