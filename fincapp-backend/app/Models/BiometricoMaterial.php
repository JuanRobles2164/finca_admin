<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiometricoMaterial extends Model
{
    use HasFactory;
    protected $table = "biometricos_material";
    protected $guarded = [];
}
