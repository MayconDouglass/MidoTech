@extends('painel.template.template')

@section('title','Setor')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Setor
          @foreach ($acessoPerfil as $acesso)
          @if (($acesso->role == 2)&&($acesso->ativo == 1))
          <button type="button" class="btn btn-primary fa fa-user-plus" data-toggle="modal"
            data-target="#CadastroModal">
            Cadastrar
          </button>
          @endif
          @endforeach
        </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index">Home</a></li>
          <li class="breadcrumb-item active">Unidades</li>
          <li class="breadcrumb-item active">Unidades</li>
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
          <th style="width: 20%">Empresa</th>
          <th>Setores</th>
          <th style="width: 10%">UF</th>
          <th class="statusDataTab">Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($setores as $setor)
        <tr>
          <td class="idDataTabText">{{$setor->id_setor}}</td>
          <td>{{$setor->setempresa->Sigla}}</td>
          <td>{{$setor->setor}}</td>
          <td>{{$setor->uf}}</td>
          <td>
            <span @if ($setor->ativo > 0) class="badge badge-success" @else class="badge badge-danger"
              @endif>{{$setor->ativo ? "Ativo" : "Inativo"}}</span>
          </td>
          <td>
            <button type="button" class="btn btn-primary btn-sm fa fa-eye" data-toggle="modal"
              data-target="#VisualizarTabPrecoModal" data-codigo="{{$setor->id_setor}}"
              data-empresa="{{$setor->emp_cod}}" data-setor="{{$setor->setor}}" data-estado="{{$setor->uf}}"
              data-status="{{$setor->ativo}}">
              Visualizar</button>

            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 2)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarTabPrecoModal" data-codigo="{{$setor->id_setor}}" data-empresa="{{$setor->emp_cod}}"
              data-setor="{{$setor->setor}}" data-estado="{{$setor->uf}}" data-status="{{$setor->ativo}}">
              Alterar
            </button>
            @endif
            @endforeach
            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 3)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger" data-codigo="{{$setor->id_setor}}">
            </button>
            @endif
            @endforeach
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>


<!-- Modal Cadastro-->
<div class="modal fade" id="CadastroModal" tabindex="-1" role="dialog" aria-labelledby="CadastroModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="add_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="CadastroModalLabel">Novo Setor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('SetorController@store')}}"
          enctype="multipart/form-data">
          @csrf
          <div class="form-group row">
            
            <div class="col-sm-9">
              <label class="control-label">Setor</label>
              <p><input class="form-control" type="text" name="setorcad" maxlength="36" required></p>
            </div>
            <div class="col-sm-3">
              <label class="control-label">UF</label>
              <p><input class="form-control" type="text" name="ufcad" maxlength="2" required></p>
            </div>

            <div class="col-sm-12">
              <label class="control-label">Empresa</label>
              <p><select class="select-notsearch" tabindex="-1" name="empresacad">
                  @foreach ($empresas as $empresa)
                  <option value="{{$empresa->id_empresa}}">{{$empresa->id_empresa . ' - ' . $empresa->razao_social}}
                  </option>
                  @endforeach
                </select></p>
            </div>
            

            <div class="col-sm-12">
              <label class="control-label">Ativo</label>
              <select class="select-notsearch" tabindex="-1" name="statuscad">
                <option value="1">Sim</option>
                <option value="0">Não</option>
              </select>
            </div>

          </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="reset" data-dismiss="modal"><i class="fa fa-times">
            Cancelar</i></button>
        <button type="submit" class="btn btn-primary" id="btnSalvar" name="btnSalvar"><i class="fa fa-floppy-o">
            Salvar</i></button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>


@endsection


@section('js')
<script src="{{url('/')}}/js/pages/setores.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endsection