<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

abstract class BaseRepository {
    //Abstract Operations
    abstract public function getModel();

    /**
     * Dependiendo de los valores que tenga este array, se buscará bajo ciertos criterios u otros
     * @param array $params arreglo de parámetros
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function findByParams($params): Collection {

        $query = $this->getModel()::query();

        foreach ($params as $param) {
            // Validar que el sub-array tenga los valores esperados
            if (!isset($param['attribute'], $param['operator'], $param['value'])) {
                throw new \InvalidArgumentException("Faltan claves requeridas en el parámetro (attribute, operator, value).");
            }

            $attribute = $param['attribute'];
            $operator = strtoupper($param['operator']);
            $value = $param['value'];

            // Añadir condiciones a la consulta
            switch ($operator) {
                case '=':
                case '!=':
                case '>':
                case '<':
                case '>=':
                case '<=':
                    $query->where($attribute, $operator, $value);
                    break;

                case 'IN':
                    if (!is_array($value)) {
                        throw new \InvalidArgumentException("El valor para el operador 'IN' debe ser un array.");
                    }
                    $query->whereIn($attribute, $value);
                    break;

                case 'NOT IN':
                    if (!is_array($value)) {
                        throw new \InvalidArgumentException("El valor para el operador 'NOT IN' debe ser un array.");
                    }
                    $query->whereNotIn($attribute, $value);
                    break;

                case 'LIKE':
                case 'NOT LIKE':
                    $query->where($attribute, $operator, $value);
                    break;

                case 'BETWEEN':
                    if (!is_array($value)) {
                        throw new \InvalidArgumentException("El valor para el operador 'BETWEEN' debe ser un array con dos elementos.");
                    }
                    $query->whereBetween($attribute, $value);
                    break;

                case 'NOT BETWEEN':
                    if (!is_array($value) || count($value) !== 2) {
                        throw new \InvalidArgumentException("El valor para el operador 'NOT BETWEEN' debe ser un array con dos elementos.");
                    }
                    $query->whereNotBetween($attribute, $value);
                    break;

                default:
                    throw new \InvalidArgumentException("Operador no soportado: {$operator}");
            }
        }

        // Ejecutar la consulta y retornar los resultados
        return $query->get();
    }

    public function firstRecord(){
        return $this->getModel()->first();
    }

    public function firstOrCreate($params){
        return $this->getModel()->firstOrCreate($params);
    }
    //Create Operations
    public function create($object){
        return $this->getModel()->create($object);
    }

    public function find($id){
        return $this->getModel()->find($id);
    }

    public function getAll($paginate = 0){
        $result = null;
        if($paginate == 0){
            $result = $this->getModel()->get();
        }else{
            $result = $this->getModel()->paginate($paginate);
        }
        return $result;
    }

    public function update($object, $data){
        $object->fill($data);
        $object->save();
        return $object;
    }

    public function delete($object){
        $object->estado = 3;
        $object->save();
    }
}
