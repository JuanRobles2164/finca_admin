<?php

namespace App\Repositories;

use App\Models\Kardex;

class KardexRepository extends BaseRepository{

    public function getModel(){
        return new Kardex();
    }
}
