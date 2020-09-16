@extends('painel.template.template')

@section('title','Visualizar Cliente')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Visualizar: Cliente #<label class="control-label">{{$cliente[0]}}</label></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index">Home</a></li>
          <li class="breadcrumb-item active">Clientes</li>
          <li class="breadcrumb-item"><a href="{{route('clientes')}}">Listar Clientes</a></li>
          <li class="breadcrumb-item active">Visualizar</li>
        </ol>
      </div>
    </div>
  </div>
</div>

@if (session('status_error'))
<div class="alert alert-danger status ">
  {{ session('status_error') }}
</div>
@endif
@if (session('status_success'))
<div class="alert alert-success status">
  {{ session('status_success') }}
</div>
@endif
@if (session('status_warning'))
<div class="alert alert-warning status">
  {{ session('status_warning') }}
</div>
@endif
@endsection

@section('content')
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-sm-6">
        <input class="form-control" type="hidden" id="idCliente" value="{{$cliente[0]}}">
        <label class="control-label">Razão Social</label><br>
        <label class="textSimples" id="razao"></label>
      </div>

      <div class="col-sm-2">
        <label class="control-label">Limite de Crédito</label>
        <p><label class="control-label" id="limitecred"></label></p>
      </div>

      <div class="col-sm-2">
        <label class="control-label">Vencimento</label>
        <p><label class="control-label" id="venclimitecred"></label></p>
      </div>

      <div class="col-sm-2">
        <label class="control-label">Status</label>
        <p><label class="control-label" id="status"></label></p>
      </div>

      <div class="col-sm-12">
        <label class="control-label">Histórico de Movimentação:</label><br>
        <div class="card-body table-responsive p-0" style="height: 300px;">
          <table id="historico" class="table table-head-fixed text-nowrap textSimples">
            <thead>
              <tr>
                <th>Nº Doc</th>
                <th>Série</th>
                <th>Valor Bruto</th>
                <th>Valor Liq.</th>
                <th>Tipo</th>
                <th>Data Mov.</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection


@section('js')
<script src="{{url('/')}}/js/pages/clientesview.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/mask/jquery.mask.min.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
@endsection