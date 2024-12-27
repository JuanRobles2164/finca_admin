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
        Schema::create('biometricos_material', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("identificador")->index()->nullable();
            $table->smallInteger("edad");
            $table->boolean("es_padron");
            $table->enum("sexo", Constants::BIOMETRICOS_MATERIAL_SEXO);
            $table->enum("adquisicion", Constants::BIOMETRICOS_MATERIAL_ADQUISICION);

            $table->unsignedBigInteger("padre_id")->nullable()->index();
            $table->foreign("padre_id")
            ->references("id")
            ->on("biometricos_material");

            $table->unsignedBigInteger("material_id")->index();
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
        Schema::dropIfExists('biometricos_material');
    }
};
