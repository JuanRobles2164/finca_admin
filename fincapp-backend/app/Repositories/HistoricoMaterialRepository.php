<?php

namespace App\Repositories;

use App\Models\HistoricoMaterial;

class HistoricoMaterialRepository extends BaseRepository {

    public function getModel(){
        return new HistoricoMaterial();
    }
}
