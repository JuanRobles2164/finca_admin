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
        Schema::create('materiales', function (Blueprint $table) {
            $table->id();
            $table->text("nombre")->index();
            $table->longText("descripcion")->nullable();
            $table->enum("unidad", Constants::MATERIALES_UNIDADES);
            $table->enum("tipo_material", Constants::MATERIALES_TIPO_MATERIAL);
            $table->boolean("requiere_procesar")->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiales');
    }
};
