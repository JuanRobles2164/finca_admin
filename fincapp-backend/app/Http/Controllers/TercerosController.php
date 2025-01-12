<?php

namespace App\Http\Controllers;

use App\Domain\TerceroDomain;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TercerosController extends Controller
{
    private TerceroDomain $terceroDomain;

    function __construct(TerceroDomain $terceroDomain)
    {
        $this->terceroDomain = $terceroDomain;
    }

    function get(){
        return json_encode($this->terceroDomain->get());
    }

    function find(Request $request){
        return json_encode($this->terceroDomain->find($request->id));
    }

    function findByParams(Request $request){
        return json_encode($this->terceroDomain->findByParams($request->params));
    }

    function create(Request $request){
        return json_encode($this->terceroDomain->create($request->data));
    }

    function update(Request $request){
        return json_encode($this->terceroDomain->update($request->object_id, $request->data));
    }
}
