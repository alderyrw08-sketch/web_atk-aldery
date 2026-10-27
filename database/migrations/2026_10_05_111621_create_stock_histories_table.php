<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('barangs');
            $table->string('transaction_type'); // BARANG_MASUK, BARANG_KELUAR, STOCK_OPNAME, ADJUSTMENT
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->integer('stock_before');
            $table->integer('quantity'); // positif = bertambah, negatif = berkurang
            $table->integer('stock_after');
            $table->foreignId('user_id')->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_histories');
    }
};