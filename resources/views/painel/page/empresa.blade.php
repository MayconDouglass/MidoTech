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
        <h1 class="m-0 text-dark">Empresas
          @foreach ($acessoPerfil as $acesso)
          @if (($acesso->role == 5)&&($acesso->ativo == 1))
          <button type="button" class="btn btn-primary fa fa-user-plus" data-toggle="modal"
            data-target="#CadastroModal">
            Cadastrar</button></h1>
        @endif
        @endforeach
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index">Home</a></li>
          <li class="breadcrumb-item active">Configuração</li>
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
          <th>Razão Social</th>
          <th class="statusDataTab">Status</th>
          <th class="actionDataTab">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($empresas as $empresa)
        <tr>
          <td class="idDataTabText">{{$empresa->id_empresa}}</td>
          <td>{{$empresa->razao_social}}</td>
          <td><span @if ($empresa->ativo > 0) class="badge badge-success" @else class="badge badge-danger"
              @endif>{{$empresa->ativo ? "Ativo" : "Inativo"}}</span></td>
          <td>
            <button type="button" class="btn btn-primary btn-sm fa fa-eye" data-toggle="modal"
              data-target="#VisualizarEmpModal" data-codigo="{{$empresa->id_empresa}}"
              data-razao="{{$empresa->razao_social}}" data-fantasia="{{$empresa->nome_fantasia}}"
              data-logradouro="{{$empresa->Logradouro}}" data-numero="{{$empresa->Numero}}"
              data-complemento="{{$empresa->Complemento}}" data-bairro="{{$empresa->Bairro}}"
              data-cidade="{{$empresa->Cidade}}" data-estado="{{$empresa->Estado}}" data-cep="{{$empresa->CEP}}"
              data-cnpj="{{$empresa->CNPJ}}" data-ie="{{$empresa->IE}}" data-im="{{$empresa->IM}}"
              data-telefone="{{$empresa->Telefone}}" data-ativo="{{$empresa->ativo}}" data-site="{{$empresa->Pag_web}}"
              data-email="{{$empresa->email}}" data-sigla="{{$empresa->Sigla}}"
              data-cadastro="{{date('d/m/Y',strtotime($empresa->DataCad))}}"
              data-alteracao="{{$empresa->DataAlt ? date('d/m/Y', strtotime($empresa->DataAlt)) : "Sem alteração"}}"
              data-regimetrib="{{$empresa->regimetrib}}" data-atividade="{{$empresa->atividade}}"
              data-saldocliente="{{$empresa->saldo_cliente}}" data-processamento="{{$empresa->data_processamento}}"
              data-licenca="{{$empresa->Licenca}}" data-imgview="<?php 
            $arquivo = 'storage/img/emp/'.$empresa->id_empresa.'.jpg';
                                    if(file_exists($arquivo)){
                                    $imagem = $arquivo;
                                    } else {
                                    $imagem = 'storage/img/emp/default.jpg';
                                    }
                                    echo ($imagem);
            ?>"> Visualizar</button>
            <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarEmpModal" data-codigo="{{$empresa->id_empresa}}"
              data-razao="{{$empresa->razao_social}}" data-fantasia="{{$empresa->nome_fantasia}}"
              data-logradouro="{{$empresa->Logradouro}}" data-numero="{{$empresa->Numero}}"
              data-complemento="{{$empresa->Complemento}}" data-bairro="{{$empresa->Bairro}}"
              data-cidade="{{$empresa->Cidade}}" data-estado="{{$empresa->Estado}}" data-cep="{{$empresa->CEP}}"
              data-cnpj="{{$empresa->CNPJ}}" data-ie="{{$empresa->IE}}" data-im="{{$empresa->IM}}"
              data-telefone="{{$empresa->Telefone}}" data-ativo="{{$empresa->ativo}}" data-site="{{$empresa->Pag_web}}"
              data-email="{{$empresa->email}}" data-sigla="{{$empresa->Sigla}}"
              data-cadastro="{{date('d/m/Y',strtotime($empresa->DataCad))}}"
              data-alteracao="{{$empresa->DataAlt ? date('d/m/Y', strtotime($empresa->DataAlt)) : "Sem alteração"}}"
              data-regimetrib="{{$empresa->regimetrib}}" data-atividade="{{$empresa->atividade}}"
              data-saldocliente="{{$empresa->saldo_cliente}}" data-processamento="{{$empresa->data_processamento}}"
              data-licenca="{{$empresa->Licenca}}" data-imgalt="<?php 
            $arquivo = 'storage/img/emp/'.$empresa->id_empresa.'.jpg';
                                    if(file_exists($arquivo)){
                                    $imagem = $arquivo;
                                    } else {
                                    $imagem = 'storage/img/emp/default.jpg';
                                    }
                                    echo ($imagem);
            ?>"> Alterar</button>
            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 5)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger" data-codigo="{{$empresa->id_empresa}}"> Excluir</button>
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
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="add_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="CadastroModalLabel">Nova Empresa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('EmpresaController@store')}}"
          enctype="multipart/form-data">
          @csrf
          <div class="form-group row">
            <div class="col-sm-6">
              <p><img id="previewImg" src="storage/img/emp/default.jpg" class="imgCad"></p>
            </div>
            <div class="col-sm-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="fotocad">
                <label class="custom-file-label" for="customFile">Selecionar Logo</label>
              </div><br>
              <label class="control-label">Razão Social</label>
              <input class="form-control" type="text" name="razaocad" id="razao_social" maxlength="150" required>
              <label class="control-label">Nome Fantasia</label>
              <input class="form-control" type="text" name="fantasiacad" id="nome_fantasia" maxlength="150" required>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Regime Tributário</label>
              <select class="select-notsearch" tabindex="-1" name="regimecad" id="regime_tributario">
                @foreach ($regimetributados as $regimetrib)
                <option value="{{$regimetrib->id_regime}}">{{$regimetrib->descricao}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Saldo dos Clientes</label>
              <select class="select-notsearch" tabindex="-1" name="saldocad" id="saldo_cliente">
                <option value="1">Consolidado</option>
                <option value="2">Individual</option>
              </select>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Atividade</label>
              <select class="select2" tabindex="-1" name="atividadecad" id="atividade">
                @foreach ($atividades as $atividade)
                <option value="{{$atividade->id_atividade}}">{{$atividade->descricao}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Ativa</label>
              <select class="select-notsearch" tabindex="-1" name="ativacad" id="ativa">
                <option value="1">Sim</option>
                <option value="0">Não</option>
              </select>
            </div>

            <div class="col-sm-1">
              <label class="control-label">SIGLA</label>
              <input class="form-control" type="text" name="siglacad" id="sigla" maxlength="6">
            </div>

            <div class="col-sm-4">
              <label class="control-label">Logradouro</label>
              <input class="form-control" type="text" name="logradourocad" id="logradouro" maxlength="150" required>
            </div>

            <div class="col-sm-1">
              <label class="control-label">Número</label>
              <input class="form-control" type="number" name="numerocad" id="numero" min="0" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Complemento</label>
              <input class="form-control" type="text" name="complementocad" maxlength="50" id="complemento">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Bairro</label>
              <input class="form-control" type="text" name="bairrocad" maxlength="60" id="bairro" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Cidade</label>
              <input class="form-control" type="text" name="cidadecad" id="cidade" maxlength="60" required>
              <input class="form-control" type="hidden" name="ibgecad" id="ibge" maxlength="7" required>
            </div>

            <div class="col-sm-1">
              <label class="control-label">UF</label>
              <input class="form-control" type="text" name="ufcad" id="uf" maxlength="2" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">CEP</label>
              <input class="form-control" type="text" name="cepcad" id="cep" maxlength="9" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">CNPJ</label>
              <input class="form-control" type="text" name="cnpjcad" id="cnpj" maxlength="18" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Insc. Estadual</label>
              <input class="form-control" type="text" name="iecad" id="ie" maxlength="10" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Insc. Municipal</label>
              <input class="form-control" type="text" name="imcad" maxlength="15" id="im">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Telefone</label>
              <input class="form-control" type="text" name="telefonecad" maxlength="80" id="telefone">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Nº de Licenças</label>
              <input class="form-control" type="number" name="licencacad" id="licenca_cadastro" min="0">
            </div>

            <div class="col-sm-6">
              <label class="control-label">Email</label>
              <input class="form-control" type="text" name="emailcad" maxlength="150" id="email">
            </div>

            <div class="col-sm-6">
              <label class="control-label">Site</label>
              <input class="form-control" type="text" name="sitecad" maxlength="150" id="site">
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
<div class="modal fade" id="AlterarEmpModal" tabindex="-1" role="dialog" aria-labelledby="AlterarEmpModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="alt_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="AlterarEmpModalLabel">Nova Empresa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('EmpresaController@update')}}"
          enctype="multipart/form-data">
          @csrf
          <div class="form-group row">
            <div class="col-sm-6">
              <p><img id="previewImgAlt" src="storage/img/emp/default.jpg" class="imgCad"></p>
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
                @foreach ($regimetributados as $regimetrib)
                <option value="{{$regimetrib->id_regime}}">{{$regimetrib->descricao}}</option>
                @endforeach
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
                @foreach ($atividades as $atividade)
                <option value="{{$atividade->id_atividade}}">{{$atividade->descricao}}</option>
                @endforeach
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
              <input class="form-control" type="hidden" name="ibgealt" maxlength="7" id="ibge_alt" required>
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
              <input class="form-control" type="text" name="cnpjalt" id="cnpj_alt" maxlength="18" autocomplete="off" required>
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

            <div class="col-sm-4">
              <label class="control-label">Site</label>
              <input class="form-control" type="text" name="sitealt" id="site_alt" maxlength="150">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Nº de Licenças</label>
              @foreach ($acessoPerfil as $acesso)
              @if (($acesso->role == 5)&&($acesso->ativo == 1))
              <input class="form-control" type="number" name="licencaalt" id="licenca_alt" min="0" step="1">
              @endif
              @if (($acesso->role == 5)&&($acesso->ativo == 0))
              <input class="form-control" type="number" id="licencaalt" min="0" step="1" disabled>
              <input class="form-control" type="hidden" name="licencaalt" id="licenca_alt" min="0" step="1">
              @endif
              @endforeach
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
<div class="modal fade" id="VisualizarEmpModal" tabindex="-1" role="dialog" aria-labelledby="VisualizarEmpModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="view_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="VisualizarEmpModalLabel"></h5>
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
              <p><img id="viewImg" src="storage/img/emp/default.jpg" class="imgCad"></p>
            </div>
            <div class="col-sm-6">
              <label class="control-label">Código Empresa</label>
              <input class="form-control" type="text" name="idEmp" id="emp_cod" disabled>
              <label class="control-label">Razão Social</label>
              <input class="form-control" type="text" name="razaoview" id="razao_social_view" disabled>
              <label class="control-label">Nome Fantasia</label>
              <input class="form-control" type="text" name="fantasiaview" id="nome_fantasia_view" disabled>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Regime Tributário</label>
              <select class="select-notsearch" tabindex="-1" name="regimeview" id="regime_tributario_view" disabled>
                <option value="1">Regime Normal</option>
                <option value="2">Simples Nacional</option>
                <option value="3">Simples Nacional - excesso de sublimite da receita bruta</option>
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Saldo dos Clientes</label>
              <select class="select-notsearch" tabindex="-1" name="saldoview" id="saldo_cliente_view" disabled>
                <option value="1">Consolidado</option>
                <option value="2">Individual</option>
              </select>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Atividade</label>
              <select class="select2" tabindex="-1" name="atividadeview" id="atividade_view" disabled>
                @foreach ($atividades as $atividade)
                <option value="{{$atividade->id_atividade}}">{{$atividade->descricao}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Ativa</label>
              <select class="select-notsearch" tabindex="-1" name="ativaview" id="ativa_view" disabled>
                <option value="1">Sim</option>
                <option value="2">Não</option>
              </select>
            </div>

            <div class="col-sm-1">
              <label class="control-label">SIGLA</label>
              <input class="form-control" type="text" name="siglaview" id="sigla_view" disabled>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Logradouro</label>
              <input class="form-control" type="text" name="logradouroview" id="logradouro_view" disabled>
            </div>

            <div class="col-sm-1">
              <label class="control-label">Número</label>
              <input class="form-control" type="number" name="numeroview" id="numero_view" disabled>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Complemento</label>
              <input class="form-control" type="text" name="complementoview" id="complemento_view" disabled>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Bairro</label>
              <input class="form-control" type="text" name="bairroview" id="bairro_view" disabled>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Cidade</label>
              <input class="form-control" type="text" name="cidadeview" id="cidade_view" disabled>
            </div>

            <div class="col-sm-1">
              <label class="control-label">UF</label>
              <input class="form-control" type="text" name="ufview" id="uf_view" disabled>
            </div>

            <div class="col-sm-2">
              <label class="control-label">CEP</label>
              <input class="form-control" type="text" name="cepview" id="cep_view" disabled>
            </div>

            <div class="col-sm-2">
              <label class="control-label">CNPJ</label>
              <input class="form-control" type="text" name="cnpjview" id="cnpj_view" disabled>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Insc. Estadual</label>
              <input class="form-control" type="text" name="ieview" id="ie_view" disabled>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Insc. Municipal</label>
              <input class="form-control" type="text" name="imview" id="im_view" disabled>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Telefone</label>
              <input class="form-control" type="text" name="telefoneview" id="telefone_view" disabled>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Data Cadastro</label>
              <input class="form-control" type="text" name="dataview" id="data_cadastro_view" disabled>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Data Alteração</label>
              <input class="form-control" type="text" name="dataview" id="data_alteracao_view" disabled>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Email</label>
              <input class="form-control" type="text" name="emailview" id="email_view" disabled>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Site</label>
              <input class="form-control" type="text" name="siteview" id="site_view" disabled>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Nº de Licenças</label>
              <input class="form-control" type="number" name="licencaview" id="licenca_view" min="0" disabled>
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
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="{{url('/')}}/js/plugins/mask/jquery.mask.min.js"></script>
<script src="{{url('/')}}/js/plugins/bs-custom-file-input/bs-custom-file-input.js"></script>
<script src="{{url('/')}}/js/pages/midotech.js"></script>
@endsection