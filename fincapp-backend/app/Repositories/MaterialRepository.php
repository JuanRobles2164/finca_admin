<?php

namespace App\Repositories;

use App\Models\Material;

class MaterialRepository extends BaseRepository {

    public function getModel(){
        return new Material();
    }
}
