<?php

namespace App\Http\Controllers;

use App\Domain\CompraDomain;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComprasController extends Controller
{
    private CompraDomain $compraDomain;

    function __construct(CompraDomain $compra_domain)
    {
        $this->compraDomain = $compra_domain;
    }

    function get(){
        return json_encode($this->compraDomain->get());
    }

    function create(Request $request){
        $response = $this->compraDomain->registrarCompra($request->materiales_compra, $request->tercero_id, $request->fecha_compra);
        return json_encode($response);
    }

    function find(Request $request){
        return json_encode($this->compraDomain->find($request->id));
    }
}
