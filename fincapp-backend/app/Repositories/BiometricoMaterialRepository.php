<?php

namespace App\Repositories;

use App\Models\BiometricoMaterial;

class BiometricoMaterialRepository extends BaseRepository{

    public function getModel(){
        return new BiometricoMaterial();
    }
}
