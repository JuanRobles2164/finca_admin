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
        Schema::create('kardexes', function (Blueprint $table) {
            $table->id();
            $table->double("cantidad");
            $table->double("total_inventario");
            $table->enum("tipo_movimiento", Constants::KARDEXES_TIPO_MOVIMIENTO);

            $table->unsignedBigInteger("material_id");
            $table->foreign("material_id")
            ->references("id")
            ->on("materiales");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kardexes');
    }
};