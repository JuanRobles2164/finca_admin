<?php

namespace App\Repositories;

use App\Models\FacturaItemKardex;

class FacturaItemKardexRepository extends BaseRepository {

    public function getModel()
    {
        return new FacturaItemKardex();
    }
}
