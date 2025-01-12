<?php

namespace App\Http\Controllers;

use App\Domain\KardexesDomain;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KardexController extends Controller
{
    private KardexesDomain $kardexesDomain;

    function __construct(KardexesDomain $kardexesDomain)
    {
        $this->kardexesDomain = $kardexesDomain;
    }

    function get(){
        return json_encode($this->kardexesDomain->get());
    }

    function findByParams(Request $request){
        return json_encode($this->kardexesDomain->findByParams($request->params));
    }

    function update(Request $request){
        return json_encode($this->kardexesDomain->update($request->object_id, $request->data));
    }

    function listarExistenciaMateriales(){
        return json_encode($this->kardexesDomain->listarExistenciaMateriales());
    }

    function editarUltimoKardexPorMaterial(Request $request){
        return json_encode($this->kardexesDomain->editarUltimoMovimientoKardexPorMaterial($request->material_id, $request->nuevo_total_inventario));
    }

    function registrarMovimientoKardex(Request $request){
        return json_encode($this->kardexesDomain->registrarMovimientoKardex($request->material_id, $request->cantidad, $request->tipo_movimiento));
    }
}
