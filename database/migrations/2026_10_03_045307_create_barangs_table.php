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
       Schema::create('barangs', function (Blueprint $table) {
    $table->id();
    $table->string('code')->unique();
    $table->string('name');
    $table->unsignedBigInteger('category_id')->nullable();
    $table->unsignedBigInteger('unit_id')->nullable();
    $table->integer('stock')->default(0);
    $table->integer('minimum_stock')->default(0);
    $table->string('location')->nullable();
    $table->text('description')->nullable();
    $table->boolean('status')->default(true);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
