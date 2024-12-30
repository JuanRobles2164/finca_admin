<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BiometricoMaterialToma extends Pivot
{
    protected $table = "biometrico_material_tomas";
    protected $guarded = [];
}
