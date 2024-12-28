<?php

namespace App\Repositories;

use App\Models\BiometricoMaterialToma;

class BiometricoMaterialTomaRepository extends BaseRepository{
    public function getModel(){
        return new BiometricoMaterialToma();
    }
}
