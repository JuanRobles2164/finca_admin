<?php

namespace App\Repositories;

use App\Models\CompraItemKardex;

class CompraItemKardexRepository extends BaseRepository {

    public function getModel()
    {
        return new CompraItemKardex();
    }
}
