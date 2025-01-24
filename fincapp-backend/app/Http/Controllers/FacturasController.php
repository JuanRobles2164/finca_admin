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
        return json_encode($this->facturaDomain->getFacturasReverseOrderById());
    }

    function registrarVenta(Request $request){
        $materialesVenta = json_decode($request->input('materiales_venta'), true);
        return json_encode($this->facturaDomain->registrarVenta($materialesVenta, $request->tercero_id, $request->file('evidencias'), $request->pagada, $request->fecha_venta));
    }

    function find(Request $request){
        return json_encode($this->facturaDomain->find($request->id));
    }

    function getFacturaDetails(Request $request){
        $pdf = $this->facturaDomain->getFacturaDetailsFile($request->factura_id);
        return $pdf->download('factura_' . $request->factura_id . '.pdf');
    }
}
