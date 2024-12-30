<?php

namespace App\Domain;

use App\Repositories\Factory\RepositoryFactory;
use App\Repositories\MaterialRepository;

class MaterialDomain extends BaseDomain {

    function __construct()
    {
        $this->setRepoInstance(RepositoryFactory::make(MaterialRepository::class));
    }
}
