<?php

namespace App\Repositories;

use App\Models\Factura;

class FacturaRepository extends BaseRepository {
    public function getModel()
    {
        return new Factura();
    }
}
