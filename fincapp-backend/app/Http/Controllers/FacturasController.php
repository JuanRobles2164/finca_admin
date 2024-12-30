<?php

namespace App\Http\Controllers;

use App\Domain\FacturaDomain;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FacturasController extends Controller
{
    private FacturaDomain $facturaDomain;
    function __construct(FacturaDomain $facturaDomain)
    {
        $this->facturaDomain = $facturaDomain;
    }

    function get(){
        return json_encode($this->facturaDomain->get());
    }

    function registrarVenta(Request $request){
        return json_encode($this->facturaDomain->registrarVenta($request->materiales_venta, $request->tercero_id, $request->pagada, $request->fecha_venta));
    }

    function find(Request $request){
        return json_encode($this->facturaDomain->find($request->id));
    }
}
