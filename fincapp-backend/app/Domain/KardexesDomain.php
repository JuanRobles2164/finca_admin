<?php

namespace App\Domain;

use App\Repositories\Factory\RepositoryFactory;
use App\Repositories\KardexRepository;
use Exception;

class KardexesDomain extends BaseDomain {

    function __construct()
    {
        $this->setRepoInstance(RepositoryFactory::make(KardexRepository::class));
    }

    function listarExistenciaMateriales(){
        return $this->repoInstance->listarExistenciaMateriales();
    }

    function editarUltimoMovimientoKardexPorMaterial($materialId, $nuevoTotalInventario){
        $is_success = true;
        try{
            $kardexObj = $this->repoInstance->obtenerUltimoMovimientoKardexPorMaterial($materialId);
            $kardexObj->cantidad = 0;
            $kardexObj->total_inventario = $nuevoTotalInventario;
            $kardexObj->save();
        }catch(Exception $ex){
            $is_success = false;
        }
        return $is_success;
    }
}
