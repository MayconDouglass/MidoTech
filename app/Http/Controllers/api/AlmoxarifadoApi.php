<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AlLocalizacao;
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
            return response()->json(['erro'=> '404','status'=>'Registro nao encontrado'], 404); 

        return response()->json($almoxarifado, 200);
    }

    public function showLocalizacao($id){
        $localizacao = AlLocalizacao::where('id_localizacao',$id)->with('almoxarifado')->first();
        if(!$localizacao)
            return response()->json(['erro'=> '404','status'=>'Registro nao encontrado'], 404);    

        return response()->json($localizacao, 200);
    }
  
    public function update(Request $request, $id)
    {
        $localizacao = AlLocalizacao::where('id_localizacao',$id)->first();
        //dd($localizacao);
        if(!$localizacao)
            return response()->json(['erro'=> '404','status'=>'Registro nao encontrado'], 404);    

        $localizacao->localiza_fisica = $request->locfisica;
        $localizacao->ean = $request->ean;
        $localizacao->tipo = $request->tipo;
        $localizacao->capacidade = $request->capacidade;
        $localizacao->status = $request->status;
        $localizacao->data_alt = $request->data_alt;
        $statusUpdate = $localizacao->update();

        if($statusUpdate){
            return response()->json(['code'=> '200','status'=>'Registro Atualizado'], 200);    
        }else{
            return response()->json(['erro'=> '404','status'=>'Registro nao encontrado'], 404);     
        }
    }

   
    public function destroy($id)
    {
        //
    }
}
