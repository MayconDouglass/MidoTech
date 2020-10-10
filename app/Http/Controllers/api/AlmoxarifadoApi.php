<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Almoxarifado;

class AlmoxarifadoApi extends Controller
{
    
    public function index()
    {
        $almoxarifados = Almoxarifado::with('al_localizacao')->get();
        return $almoxarifados;
    }

    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        $almoxarifado = Almoxarifado::where('id_almoxarifado',$id)->with('al_localizacao')->first();
        if(!$almoxarifado)
            return response()->json(['erro'=> '404','status'=>'Registro nao encontrado '], 404); 

        return response()->json($almoxarifado, 200);
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
