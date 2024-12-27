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
        Schema::create('biometrico_material_tomas', function (Blueprint $table) {
            $table->id();
            $table->unsignedDecimal("peso")->nullable();
            $table->enum("estado", Constants::BIOMETRICOS_MATERIAL_TOMAS_ESTADOS)->default("Vivo");

            $table->unsignedBigInteger("biometrico_material_id")->index();
            $table->foreign("biometrico_material_id")
            ->references("id")
            ->on("biometricos_material");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biometrico_material_tomas');
    }
};
