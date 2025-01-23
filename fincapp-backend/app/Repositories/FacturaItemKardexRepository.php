<?php

namespace App\Repositories;

use App\Models\FacturaItemKardex;

class FacturaItemKardexRepository extends BaseRepository {

    public function getModel()
    {
        return new FacturaItemKardex();
    }

    public function getItemsByFacturaId($facturaId){
        return $this->getModel()->where('factura_id', $facturaId)->get();
    }
}
