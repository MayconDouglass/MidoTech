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
          <li class="breadcrumb-item active">Clientes</li>
          <li class="breadcrumb-item active">Setores</li>
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
          <th style="width: 27%">Setores</th>
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
              data-target="#VisualizarSetorModal" data-codigo="{{$setor->id_setor}}"
              data-empresa="{{$setor->emp_cod}}" data-setor="{{$setor->setor}}" data-estado="{{$setor->uf}}"
              data-status="{{$setor->ativo}}">
              Visualizar</button>

            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 2)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarSetorModal" data-codigo="{{$setor->id_setor}}" data-empresa="{{$setor->emp_cod}}"
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
            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 5)&&($acesso->ativo == 1))
            <div class="col-sm-12">
              <label class="control-label">Empresa</label>
              <p><select class="select-notsearch" tabindex="-1" name="empresacad">
                  @foreach ($empresas as $empresa)
                  <option value="{{$empresa->id_empresa}}">{{$empresa->id_empresa . ' - ' . $empresa->razao_social}}
                  </option>
                  @endforeach
                </select></p>
            </div>
            @endif

            @if (($acesso->role == 5)&&($acesso->ativo == 0))
            <div class="col-sm-12">
            <input class="form-control" type="hidden" name="empresacad" value="{{$uempresa}}" required>
            </div>
            @endif
            
            @endforeach

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

<!-- Modal de Exclusao-->
<div class="modal fade" id="modal-danger">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="delete_modalHeader">
        <div class="modal-header">
          <h4 class="b_text_modal_title_danger"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="{{action('SetorController@destroy')}}">
          @csrf
          <input type="hidden" class="form-control col-form-label-sm" id="iddelete" name="iddelete">
          <label class="b_text_modal_danger">Deseja realmente excluir este registro?</label>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary btn-sm fa fa-times" data-dismiss="modal"> Cancelar</button>
            <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o"> Confirmar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Visualizacao-->
<div class="modal fade" id="VisualizarSetorModal" tabindex="-1" role="dialog" aria-labelledby="VisualizarSetorModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="view_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="VisualizarSetorModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST">
          @csrf
          <div class="form-group row">
            <div class="col-sm-2">
              <label class="control-label">ID</label>
              <p><input class="form-control" type="text" id="idSetor" disabled></p>
            </div>

            <div class="col-sm-7">
              <label class="control-label">Setor</label>
              <p><input class="form-control" type="text" id="setorview" disabled></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">UF</label>
              <p><input class="form-control" type="text" id="ufview" disabled></p>
            </div>
            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 5)&&($acesso->ativo == 1))
            <div class="col-sm-12">
              <label class="control-label">Empresa</label>
              <p><select class="select-notsearch" tabindex="-1" name="empresaview" id="empresaview" disabled>
                @foreach ($empresas as $empresa)
                <option value="{{$empresa->id_empresa}}">{{$empresa->razao_social}}</option> 
                @endforeach
              </select></p>
            </div>
            @endif
            @endforeach

            <div class="col-sm-12">
              <label class="control-label">Status</label>
              <p><select class="select-notsearch" tabindex="-1" name="statusview" id="statusview" disabled>
                <option value="1">Sim</option>
                <option value="0">Não</option>
              </select></p>
            </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="reset" data-dismiss="modal"><i class="fa fa-times">
                Cancelar</i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Alteracao-->
<div class="modal fade" id="AlterarSetorModal" tabindex="-1" role="dialog" aria-labelledby="AlterarSetorModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="alt_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="AlterarSetorModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('SetorController@update')}}">
          @csrf
          <div class="form-group row">

            <div class="col-sm-9">
              <label class="control-label">Setor</label>
              <input class="form-control" type="hidden" id="idSetor" name="idSetor">
              <p><input class="form-control" type="text" id="setoralt" disabled></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">UF</label>
              <p><input class="form-control" type="text" id="ufalt" disabled></p>
            </div>
            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 5)&&($acesso->ativo == 1))
            <div class="col-sm-12">
              <label class="control-label">Empresa</label>
              <p><select class="select-notsearch" tabindex="-1" name="empresaalt" id="empresaalt" disabled>
                @foreach ($empresas as $empresa)
                <option value="{{$empresa->id_empresa}}">{{$empresa->razao_social}}</option> 
                @endforeach
              </select></p>
            </div>
            @endif
            @endforeach

            <div class="col-sm-12">
              <label class="control-label">Status</label>
              <p><select class="select-notsearch" tabindex="-1" name="statusalt" id="statusalt">
                <option value="1">Sim</option>
                <option value="0">Não</option>
              </select></p>
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