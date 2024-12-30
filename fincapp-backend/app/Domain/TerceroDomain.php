<?php

namespace App\Domain;

use App\Repositories\Factory\RepositoryFactory;
use App\Repositories\TerceroRepository;

class TerceroDomain extends BaseDomain {

    function __construct()
    {
        $this->setRepoInstance(RepositoryFactory::make(TerceroRepository::class));
    }
}
