<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settributo;

class SituacaoTribAPI extends Controller
{
    
    public function index()
    {
        $st = Settributo::with('setempresa')->get();
        return response()->json($st,200);
    }

   
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $st = Settributo::with('setempresa')->where('id_tributacao',$id)->first();
        if(!$st)
            return response()->json(['erro'=>'404','status'=>'Nenhum registro localizado'],404);
            
        return response()->json($st,200);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
