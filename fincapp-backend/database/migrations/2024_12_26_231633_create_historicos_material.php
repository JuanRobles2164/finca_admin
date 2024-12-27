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
        Schema::create('historicos_material', function (Blueprint $table) {
            $table->id();

            $table->longText("descripcion")->nullable();

            $table->unsignedBigInteger("kardex_id")->index();
            $table->foreign("kardex_id")
            ->references("id")
            ->on("kardexes");

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
        Schema::dropIfExists('historicos_material');
    }
};
