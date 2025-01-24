<?php

namespace App\Repositories;

use App\Models\FacturaItemKardex;

class FacturaItemKardexRepository extends BaseRepository {

    public function getModel()
    {
        return new FacturaItemKardex();
    }

    public function getItemsByFacturaId($facturaId){
        return $this->getModel()
        ->join('kardexes', 'factura_items_kardex.kardex_id', '=', 'kardexes.id')
        ->join('materiales', 'kardexes.material_id', '=', 'materiales.id')
        ->where('factura_id', $facturaId)->get([
            'factura_items_kardex.id',
            'factura_items_kardex.valor_unitario',
            'factura_items_kardex.cantidad',
            'materiales.nombre as nombre'
        ]);
    }
}
