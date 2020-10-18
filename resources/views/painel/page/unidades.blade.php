@extends('painel.template.template')

@section('title','Unidades')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Unidades
          @foreach ($acessoPerfil as $acesso)
          @if (($acesso->role == 5)&&($acesso->ativo == 1))
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
          <li class="breadcrumb-item active">Tabelas Genéricas</li>
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
          <th>Unidades</th>
          <th class="statusDataTab">Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($unidades as $unidade)
        <tr>
          <td class="idDataTabText">{{$unidade->id_unidade}}</td>
          <td>{{$unidade->descricao}}</td>
          <td>
            <span @if ($unidade->ativo > 0) class="badge badge-success" @else class="badge badge-danger"
              @endif>{{$unidade->ativo ? "Ativo" : "Inativo"}}</span>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>


<!-- Modal Cadastro-->
<div class="modal fade" id="CadastroModal" tabindex="-1" role="dialog" aria-labelledby="CadastroModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <div class="add_modalHeader">
              <div class="modal-header">
                  <h5 class="modal-title" id="CadastroModalLabel">Nova Unidade</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          </div>
          <div class="modal-body">
              <!-- Form de cadastro -->
              <form class="form-horizontal" method="POST" action="{{action('UnidadesController@store')}}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group row">
                      <div class="col-sm-12">
                          <label class="control-label">Descricao</label>
                          <p><input class="form-control" type="text" name="descricaocad" maxlength="5" required /></p>
                      </div>

                      <div class="col-sm-12">
                          <label class="control-label">Ativo</label>
                          <select class="select-notsearch" tabindex="-1" name="statuscad">
                              <option value="1">Sim</option>
                              <option value="0">Não</option>
                          </select>
                      </div>
                  </div>

                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" id="reset" data-dismiss="modal"><i class="fa fa-times"> Cancelar</i></button>
                      <button type="submit" class="btn btn-primary" id="btnSalvar" name="btnSalvar"><i class="fa fa-floppy-o"> Salvar</i></button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>



@endsection


@section('js')
<script src="{{url('/')}}/js/pages/unidades.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endsection