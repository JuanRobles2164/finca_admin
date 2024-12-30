<?php

namespace App\Domain;

use App\Repositories\BiometricoMaterialRepository;
use App\Repositories\BiometricoMaterialTomaRepository;
use App\Repositories\Factory\RepositoryFactory;

class BiometricoMaterialDomain extends BaseDomain {

    private $biometricoMaterialTomaRepository;
    function __construct()
    {
        $this->setRepoInstance(RepositoryFactory::make(BiometricoMaterialRepository::class));
        $this->biometricoMaterialTomaRepository = RepositoryFactory::make(BiometricoMaterialTomaRepository::class);
    }

}
