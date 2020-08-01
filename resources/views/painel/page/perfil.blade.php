@extends('painel.template.template')

@section('title','Perfil')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Perfis
          <button type="button" class="btn btn-primary fa fa-user-plus" data-toggle="modal"
            data-target="#CadastroModal">
            Cadastrar</button></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index">Home</a></li>
          <li class="breadcrumb-item active">Configuração</li>
          <li class="breadcrumb-item active">Perfis</li>
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
          <th>Usuário</th>
          <th class="statusDataTab">Status</th>
          <th class="actionDataTab">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($perfis as $perfil)
        <tr>
          <td class="idDataTabText">{{$perfil->id_perfil}}</td>
          <td>{{$perfil->setempresa->Sigla}}</td>
          <td>{{$perfil->nome}}</td>
          <td><span @if ($perfil->ativo > 0) class="badge badge-success" @else class="badge badge-danger"
              @endif>{{$perfil->ativo ? "Ativo" : "Inativo"}}</span></td>
          <td>
            <button type="button" class="btn btn-primary btn-sm fa fa-eye" data-toggle="modal"
              data-target="#VisualizarPerfilModal" data-codigo="{{$perfil->id_perfil}}"
              data-empresa="{{$perfil->emp_cod}}" data-nome="{{$perfil->nome}}" data-status="{{$perfil->ativo}}"
              data-usucad="{{$perfil->usucad}}" data-usualt="{{$perfil->usualt}}"
              data-datacad="{{date('d/m/Y',strtotime($perfil->datacad))}}"
              data-dataalt="{{$perfil->dataalt ? date('d/m/Y', strtotime($perfil->dataalt)) : "Sem alteração"}}">
              Visualizar</button>
            <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarPerfilModal" data-codigo="{{$perfil->id_perfil}}" data-empresa="{{$perfil->emp_cod}}"
              data-nome="{{$perfil->nome}}" data-status="{{$perfil->ativo}}" data-usucad="{{$perfil->usucad}}"
              data-usualt="{{$perfil->usualt}}" data-datacad="{{date('d/m/Y',strtotime($perfil->datacad))}}"
              data-dataalt="{{$perfil->dataalt ? date('d/m/Y', strtotime($perfil->dataalt)) : "Sem alteração"}}">
              Alterar</button>
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger" data-codigo="{{$perfil->id_perfil}}"></button>
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
          <h5 class="modal-title" id="CadastroModalLabel">Novo Perfil</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('PerfilController@store')}}"
          enctype="multipart/form-data">
          @csrf
          <div class="form-group row">

           <div class="col-sm-12">
              <div class="card">
                <div class="card-header d-flex p-0">
                  <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Cabeçalho</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Clientes</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Produtos</a></li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab_1" name="cabecalho">
                      <div class="col-sm-12">
                        <label class="control-label">Nome</label>
                        <p><input class="form-control" type="text" name="nomecad" id="nome" maxlength="60" required></p>
                      </div>
          
                      <div class="col-sm-9">
                        <label class="control-label">Empresa</label>
                        <p><select class="select-notsearch" tabindex="-1" name="empcad" id="emp_cod">
                            @foreach ($empresas as $empresa)
                            <option value="{{$empresa->id_empresa}}">{{$empresa->razao_social}}</option>
                            @endforeach
                          </select></p>
                      </div>
          
                      <div class="col-sm-3">
                        <label class="control-label">Ativa</label>
                        <select class="select-notsearch" tabindex="-1" name="ativacad" id="ativa">
                          <option value="1">Sim</option>
                          <option value="0">Não</option>
                        </select>
                      </div>
                    </div>
                    <div class="tab-pane" id="tab_2" name="clientes">
                      <div class="custom-control col-sm-4 custom-switch custom-switch-off-danger custom-switch-on-success">
                        <input type="checkbox" class="custom-control-input" id="menu11">
                        <label class="custom-control-label" for="menu11">Menu 11</label><br>
                      </div>
                      <div class="custom-control col-sm-4 custom-switch custom-switch-off-danger custom-switch-on-success">
                        <input type="checkbox" class="custom-control-input" id="menu12">
                        <label class="custom-control-label" for="menu12">Menu 12</label><br>
                      </div>
                    </div>
                    <div class="tab-pane" id="tab_3">
                      L
                    </div>
                  </div>
                </div>
              </div>
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

<!-- Modal Alteracao-->
<div class="modal fade" id="AlterarPerfilModal" tabindex="-1" role="dialog" aria-labelledby="AlterarPerfilModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="alt_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="AlterarPerfilModalLabel">Nova Perfil</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('PerfilController@update')}}"
          enctype="multipart/form-data">
          @csrf
          <div class="form-group row">

            <div class="col-sm-12">
              <label class="control-label">Ativa</label>
              <select class="select-notsearch-perfis" tabindex="-1" name="ativaalt" id="ativa_alt">
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


<!-- Modal Visualizacao-->
<div class="modal fade" id="VisualizarPerfilModal" tabindex="-1" role="dialog"
  aria-labelledby="VisualizarPerfilModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="view_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="VisualizarPerfilModalLabel"></h5>
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

            <div class="col-sm-12">
              <label class="control-label">Nome</label>
              <p><input class="form-control" type="text" name="nomeview" id="nome_view" disabled></p>
            </div>

            <div class="col-sm-9">
              <label class="control-label">Empresa</label>
              <select class="select-notsearch" tabindex="-1" name="empresaview" id="empresa_view" disabled>
                @foreach ($empresas as $empresa)
                <option value="{{$empresa->id_empresa}}">{{$empresa->razao_social}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Ativa</label>
              <p><select class="select-notsearch" tabindex="-1" name="ativaview" id="ativa_view" disabled>
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-6">
              <label class="control-label">Usuário Cadastro</label>
              <input class="form-control" type="text" name="usuview" id="user_cadastro_view" disabled>
            </div>

            <div class="col-sm-6">
              <label class="control-label">Data Cadastro</label>
              <p><input class="form-control" type="text" name="dataview" id="data_cadastro_view" disabled></p>
            </div>

            <div class="col-sm-6">
              <label class="control-label">Usuário Alteração</label>
              <input class="form-control" type="text" name="usuview" id="user_alteracao_view" disabled>
            </div>

            <div class="col-sm-6">
              <label class="control-label">Data Alteração</label>
              <input class="form-control" type="text" name="dataview" id="data_alteracao_view" disabled>
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
        <form class="form-horizontal" method="POST" action="{{action('PerfilController@destroy')}}">
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


@endsection


@section('js')
<script src="{{url('/')}}/js/pages/midotech.js"></script>
<script src="{{url('/')}}/js/plugins/bs-custom-file-input/bs-custom-file-input.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endsection