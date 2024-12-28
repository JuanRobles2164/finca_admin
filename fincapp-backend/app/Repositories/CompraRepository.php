<?php

namespace App\Repositories;

use App\Models\Compra;

class CompraRepository extends BaseRepository {

    public function getModel()
    {
        return new Compra();
    }
}
