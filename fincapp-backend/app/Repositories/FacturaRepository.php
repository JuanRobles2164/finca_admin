<?php

namespace App\Repositories;

use App\Models\Factura;

class FacturaRepository extends BaseRepository {
    public function getModel()
    {
        return new Factura();
    }

    public function getFacturasOrdenInversoId(){
        return $this->getModel()->orderByDesc('id', 'desc')->get();
    }
}
