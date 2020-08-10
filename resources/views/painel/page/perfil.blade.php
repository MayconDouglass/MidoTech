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
              data-usucad="{{$perfil->usuario->nome}}" data-usualt="{{$perfil->usuario->nome}}"
              data-datacad="{{date('d/m/Y',strtotime($perfil->datacad))}}"
              data-dataalt="{{$perfil->dataalt ? date('d/m/Y', strtotime($perfil->dataalt)) : "Sem alteração"}}">
              Visualizar</button>
              
              @foreach ($acessoPerfil as $acesso)
              @if (($acesso->role == 2)&&($acesso->ativo == 1))
                <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
                  data-target="#AlterarPerfilModal" data-codigo="{{$perfil->id_perfil}}" data-status="{{$perfil->ativo}}">
                  Alterar
                </button>
              
                <button type="button" class="btn btn-permissao btn-sm fa fa-key" data-toggle="modal"
                  data-target="#modal-permissao" data-codigo="{{$perfil->id_perfil}}"
                  data-nome="{{$perfil->nome}}">
                </button>
              @endif
            @endforeach
            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 3)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger" data-codigo="{{$perfil->id_perfil}}">
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
              <select class="select-notsearch" tabindex="-1" name="statuscad" id="ativa">
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
            <input class="form-control" type="hidden" name="idPerfil" id="idPerfil" required>

            <div class="col-sm-12">
              <label class="control-label">Ativa</label>
              <select class="select-notsearch-perfis" tabindex="-1" name="statusalt" id="status_alt">
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
<div class="modal fade" id="modal-danger" tabindex="-1">
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

<!-- Modal de Permissao-->
<div class="modal fade" id="modal-permissao" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="permissao_modalHeader">
        <div class="modal-header">
          <h4 class="b_text_modal_title_permissao"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="{{action('PerfilController@atualizarPermissao')}}">
          @csrf
          <input type="hidden" class="form-control col-form-label-sm" id="idPerfil" name="idPerfil">
          <div class="form-group row">

            <div class="col-sm-3">
              <input type="hidden" value="1" class="form-control col-form-label-sm" id="idRoleView" name="idRole1">
              <label class="control-label">Visualizar Cadastros</label>
              <select class="select-notsearch-role" tabindex="-1" name="role1" id="role1">
                <option value="1">Sim</option>
                <option value="0">Não</option>
              </select>
            </div>

            <div class="col-sm-3">
              <input type="hidden" value="2" class="form-control col-form-label-sm" id="idRoleEdit" name="idRole2">
              <label class="control-label">Alterar/Cadastrar</label>
              <select class="select-notsearch-role" tabindex="-1" name="role2" id="role2">
                <option value="1">Sim</option>
                <option value="0">Não</option>
              </select>
            </div>

            <div class="col-sm-3">
              <input type="hidden" value="3" class="form-control col-form-label-sm" id="idRoleDel" name="idRole3">
              <label class="control-label">Deletar Cadastros</label>
              <p><select class="select-notsearch-role" tabindex="-1" name="role3" id="role3">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-3">
              <input type="hidden" value="4" class="form-control col-form-label-sm" id="idRoleDesconto" name="idRole4">
              <label class="control-label">Respeitar Desconto máx.</label>
              <p><select class="select-notsearch-role" tabindex="-1" name="role4" id="role4">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-3">
              <input type="hidden" value="5" class="form-control col-form-label-sm" id="idRoleAdmin" name="idRole5">
              <label class="control-label">Administrador</label>
              <select class="select-notsearch-role" tabindex="-1" name="role5" id="role5">
                <option value="1">Sim</option>
                <option value="0">Não</option>
              </select>
            </div>

          </div>
      </div>

      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary btn-sm fa fa-times" data-dismiss="modal"> Cancelar</button>
        <button type="submit" class="btn btn-permissao btn-sm fa fa-floppy-o"> Confirmar</button>
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

            <div class="col-sm-2">
              <label class="control-label">ID</label>
              <p><input class="form-control" type="text" name="idperfilview" id="idPerfil_view" disabled></p>
            </div>

            <div class="col-sm-10">
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
              <p><select class="select-notsearch" tabindex="-1" name="statusview" id="status_view" disabled>
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




@endsection


@section('js')
<script src="{{url('/')}}/js/pages/midotech.js"></script>
<script src="{{url('/')}}/js/plugins/bs-custom-file-input/bs-custom-file-input.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endsection