<?php

namespace App\Http\Controllers;

use App\Domain\CultivoDomain;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CultivosController extends Controller
{
    private CultivoDomain $cultivoDomain;

    function __construct(CultivoDomain $cultivoDomain)
    {
        $this->cultivoDomain = $cultivoDomain;
    }

    function listarMaterialesDisponiblesParaCultivo(){
        return json_encode($this->cultivoDomain->materialesDisponiblesParaCultivo());
    }

    function agregarCultivo(Request $request){
        return json_encode($this->cultivoDomain->agregarCultivo($request->material_id, $request->edad, $request->cantidad, $request->adquisicion));
    }

    function consumirInsumosPorCultivo(Request $request){
        return json_encode($this->cultivoDomain->consumirInsumosPorCultivo($request->material_id_cultivo, $request->insumos_consumidos));
    }

    function recogerCosecha(Request $request){
        return json_encode($this->cultivoDomain->recogerCosecha($request->material_id_cultivo, $request->material_id_recoge, $request->cantidad_material_recodigo));
    }

    function listarMaterialesProcesables(){
        return json_encode($this->cultivoDomain->listarMaterialesProcesables());
    }

    function finalizarCosecha(Request $request){
        $this->cultivoDomain->finalizarCosecha($request->material_id_cosecha_sin_finalizar,
        $request->cantidad_cosechas_sin_finalizar_total,
        $request->material_id_cosecha_finalizada,
        $request->cantidad_cosecha_finalizada);
        return json_encode(true);
    }
}
