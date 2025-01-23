<?php

namespace App\Repositories;

use App\Models\Evidencia;

class EvidenciaRepository extends BaseRepository {

    public function getModel()
    {
        return new Evidencia();
    }

    public function getEvidenciaByFacturaId($facturaId){
        return $this->getModel()->where('factura_id', $facturaId)->get();
    }
}
