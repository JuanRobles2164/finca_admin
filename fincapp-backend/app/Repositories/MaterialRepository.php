<?php

namespace App\Repositories;

use App\Common\Constants;
use App\Models\Material;

class MaterialRepository extends BaseRepository {

    public function getModel(){
        return new Material();
    }

    public function getMaterialesParaCultivar(){
        return $this->getModel()
            ->where('tipo_material', Constants::MATERIALES_TIPO_MATERIAL_CULTIVO)
            ->where('unidad', Constants::MATERIALES_UNIDADES_TOTALIDAD)
            ->get();
    }
}
