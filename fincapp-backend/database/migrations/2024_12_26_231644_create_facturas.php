<?php

use App\Common\Constants;
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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->date("fecha_venta");
            $table->unsignedInteger("numero");
            $table->date("fecha_pago")->nullable();
            $table->enum("estado", Constants::FACTURAS_ESTADOS)->default("Pagada");
            $table->unsignedDecimal("total");

            $table->unsignedBigInteger("tercero_id");
            $table->foreign("tercero_id")
            ->references("id")
            ->on("terceros");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};