@extends('painel.template.template')

@section('title','Adicionar Cliente')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Cadastro</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index">Home</a></li>
          <li class="breadcrumb-item active">Clientes</li>
          <li class="breadcrumb-item"><a href="{{route('clientes')}}">Listar Clientes</a></li>
          <li class="breadcrumb-item active"><a href="{{route('adduser')}}">Novo</a></li>
        </ol>
      </div>
    </div>
  </div>
  @endsection

  @section('content')
  <div class="card">
    <div class="card-body" id="Cadastro">

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Minimal</label>
            <select class="select2" style="width: 100%;">
              <option selected="selected">Alabama</option>
              <option>Alaska</option>
              <option>California</option>
              <option>Delaware</option>
              <option>Tennessee</option>
              <option>Texas</option>
              <option>Washington</option>
            </select>
          </div>
        </div>
      </div>


    </div>
  </div>
  @endsection


  @section('js')
  <script src="{{url('/')}}/js/pages/clientes.js"></script>
  <script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
  @endsection