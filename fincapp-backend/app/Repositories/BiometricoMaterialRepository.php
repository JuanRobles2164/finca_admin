<?php

namespace App\Repositories;

use App\Models\BiometricoMaterial;

class BiometricoMaterialRepository extends BaseRepository{

    public function getModel(){
        return new BiometricoMaterial();
    }

    public function verificaExistenciaCultivo($materialId){
        return $this->getModel()
        ->where('material_id', $materialId)
        ->first();
    }
}
