@extends('painel.template.template')

@section('title','Empresa')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Usuários
          <button type="button" class="btn btn-primary fa fa-user-plus" data-toggle="modal"
            data-target="#CadastroModal">
            Cadastrar</button></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index">Home</a></li>
          <li class="breadcrumb-item active">Empresas</li>
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
        @foreach ($usuarios as $usuario)
        <tr>
          <td class="idDataTabText">{{$usuario->id_usuario}}</td>
          <td>{{$usuario->setempresa->Sigla}}</td>
          <td>{{$usuario->nome}}</td>
          <td><span @if ($usuario->ativo > 0) class="badge badge-success" @else class="badge badge-danger"
              @endif>{{$usuario->ativo ? "Ativo" : "Inativo"}}</span></td>
          <td>
            <button type="button" class="btn btn-primary btn-sm fa fa-eye" data-toggle="modal" data-target="#VisualizarUserModal" 
            data-codigo="{{$usuario->id_usuario}}" data-empresa="{{$usuario->empresa}}" data-perfil="{{$usuario->perfil_fk}}"
            data-nome="{{$usuario->nome}}" data-email="{{$usuario->email}}" data-status="{{$usuario->ativo}}" 
            data-datacad="{{date('d/m/Y',strtotime($usuario->data_cadastro))}}" data-dataalt="{{$usuario->data_alteracao ? date('d/m/Y', strtotime($usuario->data_alteracao)) : "Sem alteração"}}" 
            data-imgview="<?php 
            $arquivo = 'storage/img/users/'.$usuario->id_usuario.'.jpg';
                                    if(file_exists($arquivo)){
                                    $imagem = $arquivo;
                                    } else {
                                    $imagem = 'storage/img/users/default.jpg';
                                    }
                                    echo ($imagem);
            ?>"> Visualizar</button>
            <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarUserModal" data-imgalt="<?php 
            $arquivo = 'storage/img/users/'.$usuario->id_usuario.'.jpg';
                                    if(file_exists($arquivo)){
                                    $imagem = $arquivo;
                                    } else {
                                    $imagem = 'storage/img/users/default.jpg';
                                    }
                                    echo ($imagem);
            ?>"> Alterar</button>
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger" data-codigo="{{$usuario->id_usuario}}"> Excluir</button>
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
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="add_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="CadastroModalLabel">Novo Usuário</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
          @csrf
          <div class="form-group row">
            <div class="col-sm-6">
              <p><img id="previewImg" src="storage/img/users/default.jpg" class="imgCad"></p>
            </div>
            <div class="col-sm-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="fotocad">
                <label class="custom-file-label" for="customFile">Selecionar Logo</label>
              </div><br>
              <label class="control-label">Email</label>
              <input class="form-control" type="email" name="emailcad" id="email" maxlength="150" required>
              <label class="control-label">Senha</label>
              <p><input class="form-control" type="password" name="passwordcad" id="email" maxlength="10"
                  placeholder="Máximo de 10 caracteres" required></p>
            </div>

            <div class="col-sm-5">
              <label class="control-label">Nome</label>
              <input class="form-control" type="text" name="nomecad" id="nome" maxlength="250" required>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Empresa</label>
              <p><select class="select-notsearch" tabindex="-1" name="saldocad" id="saldo_cliente">
                  @foreach ($empresas as $empresa)
                  <option value="{{$empresa->id_empresa}}">{{$empresa->razao_social}}</option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Ativa</label>
              <select class="select-notsearch" tabindex="-1" name="ativacad" id="ativa">
                <option value="1">Sim</option>
                <option value="0">Não</option>
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Perfil</label>
              <select class="select-notsearch" tabindex="-1" name="perfilcad" id="perfil">
                @foreach ($perfis as $perfil)
                <option value="{{$perfil->id_perfil}}">{{$perfil->nome}}</option>
                @endforeach
              </select>
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
<div class="modal fade" id="AlterarUserModal" tabindex="-1" role="dialog" aria-labelledby="AlterarUserModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="alt_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="AlterarUserModalLabel">Nova Empresa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
          @csrf
          <div class="form-group row">
            <div class="col-sm-6">
              <p><img id="previewImgAlt" src="storage/img/users/default.jpg" class="imgCad"></p>
            </div>
            <div class="col-sm-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFileAlt" name="fotoalt">
                <label class="custom-file-label" for="customFileAlt">Selecionar Logo</label>
              </div><br>
              <input class="form-control" type="hidden" name="idEmp" id="emp_cod" required>
              <label class="control-label">Razão Social</label>
              <input class="form-control" type="text" name="razaoalt" id="razao_social_alt" maxlength="150" required>
              <label class="control-label">Nome Fantasia</label>
              <input class="form-control" type="text" name="fantasiaalt" id="nome_fantasia_alt" maxlength="150"
                required>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Regime Tributário</label>
              <select class="select-notsearch-emp" tabindex="-1" name="regimealt" id="regime_tributario_alt">
                <option value="1">0</option>
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Saldo dos Clientes</label>
              <select class="select-notsearch-emp" tabindex="-1" name="saldoalt" id="saldo_cliente_alt">
                <option value="1">Consolidado</option>
                <option value="2">Individual</option>
              </select>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Atividade</label>
              <select class="select2-emp" tabindex="-1" name="atividadealt" id="atividade_alt">
                <option value="1">0</option>
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Ativa</label>
              <select class="select-notsearch-emp" tabindex="-1" name="ativaalt" id="ativa_alt">
                <option value="1">Sim</option>
                <option value="0">Não</option>
              </select>
            </div>

            <div class="col-sm-1">
              <label class="control-label">SIGLA</label>
              <input class="form-control" type="text" name="siglaalt" maxlength="6" id="sigla_alt">
            </div>

            <div class="col-sm-4">
              <label class="control-label">Logradouro</label>
              <input class="form-control" type="text" name="logradouroalt" maxlength="150" id="logradouro_alt" required>
            </div>

            <div class="col-sm-1">
              <label class="control-label">Número</label>
              <input class="form-control" type="number" name="numeroalt" min="0" id="numero_alt" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Complemento</label>
              <input class="form-control" type="text" name="complementoalt" maxlength="50" id="complemento_alt">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Bairro</label>
              <input class="form-control" type="text" name="bairroalt" maxlength="60" id="bairro_alt" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Cidade</label>
              <input class="form-control" type="text" name="cidadealt" maxlength="60" id="cidade_alt" required>
            </div>

            <div class="col-sm-1">
              <label class="control-label">UF</label>
              <input class="form-control" type="text" name="ufalt" id="uf_alt" maxlength="2" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">CEP</label>
              <input class="form-control" type="text" name="cepalt" id="cep_alt" maxlength="9" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">CNPJ</label>
              <input class="form-control" type="text" name="cnpjalt" id="cnpj_alt" maxlength="18" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Insc. Estadual</label>
              <input class="form-control" type="text" name="iealt" id="ie_alt" maxlength="10" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Insc. Municipal</label>
              <input class="form-control" type="text" name="imalt" maxlength="10" id="im_alt">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Telefone</label>
              <input class="form-control" type="text" name="telefonealt" maxlength="15" id="telefone_alt">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Data Cadastro</label>
              <input class="form-control" type="text" name="dataalt" id="data_cadastro_alt" disabled>
            </div>

            <div class="col-sm-6">
              <label class="control-label">Email</label>
              <input class="form-control" type="text" name="emailalt" maxlength="150" id="email_alt">
            </div>

            <div class="col-sm-6">
              <label class="control-label">Site</label>
              <input class="form-control" type="text" name="sitealt" id="site_alt" maxlength="150">
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
<div class="modal fade" id="VisualizarUserModal" tabindex="-1" role="dialog" aria-labelledby="VisualizarUserModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="view_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="VisualizarUserModalLabel"></h5>
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
            <div class="col-sm-6">
              <p><img id="viewImg" src="storage/img/users/default.jpg" class="imgCad"></p>
            </div>
            <div class="col-sm-6">
              <label class="control-label">Código Usuário</label>
              <input class="form-control" type="text" name="idUser" id="user_cod" disabled>
              <label class="control-label">Email</label>
              <input class="form-control" type="email" name="emailview" id="email_view" disabled>
              <label class="control-label">Nome</label>
              <p><input class="form-control" type="text" name="nomeview" id="nome_view" disabled></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Empresa</label>
              <select class="select-notsearch" tabindex="-1" name="empresaview" id="empresa_view" disabled>
                @foreach ($empresas as $empresa)
                <option value="{{$empresa->id_empresa}}">{{$empresa->razao_social}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Perfil</label>
              <select class="select-notsearch" tabindex="-1" name="perfilview" id="perfil_view" disabled>
                @foreach ($perfis as $perfil)
                <option value="{{$perfil->id_perfil}}">{{$perfil->nome}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Ativa</label>
              <select class="select-notsearch" tabindex="-1" name="ativaview" id="ativa_view" disabled>
                <option value="1">Sim</option>
                <option value="0">Não</option>
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Data Cadastro</label>
              <input class="form-control" type="text" name="dataview" id="data_cadastro_view" disabled>
            </div>

            <div class="col-sm-2">
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
        <form class="form-horizontal" method="POST" action="{{action('EmpresaController@destroy')}}">
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