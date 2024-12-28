<?php

namespace App\Repositories;

use App\Models\Tercero;

class TerceroRepository extends BaseRepository {

    public function getModel()
    {
        return new Tercero();
    }
}
