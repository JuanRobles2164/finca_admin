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
        Schema::create('factura_items_kardex', function (Blueprint $table) {
            $table->id();

            $table->double("valor_unitario");
            $table->double("cantidad");

            $table->unsignedBigInteger("kardex_id")->index();
            $table->foreign("kardex_id")
            ->references("id")
            ->on("kardexes");

            $table->unsignedBigInteger("factura_id")->index();
            $table->foreign("factura_id")
            ->references("id")
            ->on("facturas");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factura_items_kardex');
    }
};
