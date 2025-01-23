<?php

namespace App\Repositories;

use App\Models\Evidencia;

class EvidenciaRepository extends BaseRepository {

    public function getModel()
    {
        return new Evidencia();
    }
}
