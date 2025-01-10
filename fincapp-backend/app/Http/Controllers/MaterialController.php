<?php

namespace App\Http\Controllers;

use App\Domain\MaterialDomain;
use App\Http\Controllers\Controller;
use App\Repositories\MaterialRepository;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    private MaterialDomain $materialDomain;

    function __construct(MaterialDomain $materialDomain)
    {
        $this->materialDomain = $materialDomain;
    }

    function get(){
        return json_encode($this->materialDomain->get());
    }

    function findByParams(Request $request){
        return json_encode($this->materialDomain->findByParams($request->params));
    }

    function find(Request $request){
        return json_encode($this->materialDomain->find($request->id));
    }

    function create(Request $request){
        return json_encode($this->materialDomain->create($request->data));
    }

    function update(Request $request){
        return json_encode($this->materialDomain->update($request->object_id, $request->data));
    }
}
