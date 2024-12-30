<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class HistoricoMaterial extends Pivot
{
    protected $table = "historicos_material";
    protected $guarded = [];
}
