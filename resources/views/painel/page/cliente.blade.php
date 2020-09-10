@extends('painel.template.template')

@section('title','Clientes')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Clientes
          @foreach ($acessoPerfil as $acesso)
          @if (($acesso->role == 2)&&($acesso->ativo == 1))
          <a href="{{route('addUser') }}">
            <button type="button" class="btn btn-primary fa fa-user-plus" data-toggle="modal">
              Cadastrar
            </button>
          </a>
          @endif
          @endforeach

        </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index">Home</a></li>
          <li class="breadcrumb-item active">Clientes</li>
          <li class="breadcrumb-item active">Cadastro</li>
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

    <table id="tableBase" class="table table-bordered table-striped">

      <thead>
        <tr>
          <th class="idDataTab">ID</th>
          <th>Empresa</th>
          <th>Razão Social</th>
          <th class="statusDataTab">Status</th>
          <th class="actionDataTab">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($clientes as $cliente)
        <tr>
          <td class="idDataTabText" name="idCliente">{{$cliente->id_cliente}}</td>
          <td>{{$cliente->setempresa->Sigla}}</td>
          <td>{{$cliente->razao_social}}</td>
          <td>@switch($cliente->status)
            @case(0)
            <span class="badge badge-success">Normal</span>
            @break
            @case(1)
            <span class="badge badge-warning">Venda Suspensa</span>
            @break
            @case(2)
            <span class="badge badge-repfinanceiro">Bloqueado</span>
            @break
            @case(3)
            <span class="badge badge-danger">Inativo</span>
            @break
            <span class="badge badge-info">ERRO</span>
            @default

            @endswitch
          </td>
          <td>
            <button type="button" class="btn btn-primary btn-sm fa fa-eye" data-toggle="modal"> Visualizar</button>
            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 2)&&($acesso->ativo == 1))
            <a href="{{ route('altUser',$cliente->id_cliente) }}"><button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o"
                data-toggle="modal">
                Alterar</button></a>
            @endif
            @endforeach

            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 3)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger"></button>
            @endif
            @endforeach
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection


@section('js')
<script src="{{url('/')}}/js/pages/clientes.js"></script>
<script src="{{url('/')}}/js/plugins/bs-custom-file-input/bs-custom-file-input.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endsection