<?php

namespace App\Domain;

use App\Repositories\Factory\RepositoryFactory;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseDomain {
    protected $repoInstance;

    function get(){
        return $this->repoInstance->getAll();
    }

    /**
     * Recibe un arreglo de parametros que varían acorde al tipo de operación a realizar. [['attribute' => 'id', 'operator' => '=', 'value' => 15], [Y asi con todos los atributos a buscar]]
     * @param array $params
     *
     * @return Collection
     *
     */
    function findByParams($params){
        return $this->repoInstance->findByParams($params);
    }


    /**
     * Recibe un id para buscar directamente en la base de datos
     *
     * @param int $id
     *
     * @return object
     *
     */
    function find($id){
        return $this->repoInstance->find($id);
    }


    /**
     * Crea un objeto a partir de un arreglo con los atributos del objeto
     *
     * @param array $object
     *
     * @return object
     *
     */
    function create($object){
        return $this->repoInstance->create($object);
    }

    /**
     * Actualiza un objeto con nuevos valores
     *
     * @param int $objectId
     * @param array $data
     *
     * @return object
     *
     */
    function update($objectId, $data) {
        $object = $this->repoInstance->find($objectId);
        return $this->repoInstance->update($object, $data);
    }

    function setRepoInstance($repoInstance){
        $this->repoInstance = $repoInstance;
    }
}
