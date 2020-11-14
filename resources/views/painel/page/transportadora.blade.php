@extends('painel.template.template')

@section('title','Transportadora')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Transportadora
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
          <li class="breadcrumb-item active">Compras</li>
          <li class="breadcrumb-item active">Transportadoras</li>
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
<div id="div_status" class="alert alert-success d-none">
  Atualizado com sucesso!
</div>
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
        @foreach ($transportadoras as $transp)
        <tr>
          <td class="idDataTabText" name="idCliente">{{$transp->id_transp}}</td>
          <td>{{$transp->razao_social}}</td>
          <td><span @if ($transp->status > 0) class="badge badge-success" @else class="badge badge-danger"
            @endif>{{$transp->status ? "Ativo" : "Inativo"}}</span>
          </td>
          <td>
            <button type="button"
                class="btn btn-primary btn-sm fa fa-history" data-toggle="modal"></button>
            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 2)&&($acesso->ativo == 1))
            <button type="button"
                class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal">
              
            </button>
            @endif
            @endforeach

            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 3)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger" data-codigo="{{$transp->id_transp}}"></button>
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
      <div id="loadModal" class="d-none">
        <div class="overlay d-flex justify-content-center align-items-center">
          <i class="fas fa-2x fa-sync fa-spin"></i>
        </div>
      </div>
      <div class="add_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="CadastroModalLabel">Nova Transportadora</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('TranspController@store')}}"
          enctype="multipart/form-data">
          @csrf
          <div class="form-group row">

            <div class="col-sm-6">
              <label class="control-label">Razão social</label>
              <p><input class="form-control" type="text" name="razaocad" id="razao" maxlength="250" required></p>
            </div>

            <div class="col-sm-6">
              <label class="control-label">Nome Fantasia</label>
              <p><input class="form-control" type="text" name="fantasiacad" id="fantasia" maxlength="150"></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">CNPJ</label>
              <p><input class="form-control" type="text" name="cnpjcad" id="cnpj" maxlength="18" required></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">IE</label>
              <p><input class="form-control" type="text" name="iecad" id="ie" maxlength="20"></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Email</label>
              <p><input class="form-control" type="email" name="emailcad" id="email" maxlength="150"></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">CEP</label>
              <p><input class="form-control" type="text" name="cepcad" id="cep" maxlength="9" required></p>
            </div>

            <div class="col-sm-3">
              <input class="form-control" type="hidden" name="ibgecad" id="ibge" maxlength="7" required>
              <label class="control-label">Cidade</label>
              <p><input class="form-control" type="text" name="cidadecad" id="cidade" maxlength="50" required></p>
            </div>
            
            <div class="col-sm-3">
              <label class="control-label">Bairro</label>
              <p><input class="form-control" type="text" name="bairrocad" id="bairro" maxlength="50" required></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Logradouro</label>
              <p><input class="form-control" type="text" name="logradourocad" id="logradouro" maxlength="9" required></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Número</label>
              <p><input class="form-control" type="text" name="numerocad" id="numero" maxlength="8" required></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Complemento</label>
              <p><input class="form-control" type="text" name="complementocad" id="complemento" maxlength="30"></p>
            </div>

            <div class="col-sm-1">
              <label class="control-label">UF</label>
              <p><input class="form-control" type="text" name="ufcad" id="uf" maxlength="2" required></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Telefone</label>
              <p><input class="form-control" type="text" name="telefonecad" id="telefone" maxlength="30"></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Veículo / Modelo</label>
              <p><input class="form-control" type="text" name="modelocad" id="modelo" maxlength="30"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Placa Veículo</label>
              <p><input class="form-control" type="text" name="placacad" id="placa" maxlength="8"></p>
            </div>

            <div class="col-sm-1">
              <label class="control-label">UF Veículo</label>
              <p><input class="form-control" type="text" name="ufplacacad" id="ufplaca" maxlength="2"></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Cidade Veículo</label>
              <p><input class="form-control" type="text" name="cidadeplacacad" id="cidadeplaca" maxlength="50"></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Site</label>
              <p><input class="form-control" type="text" name="sitecad" id="site" maxlength="70"></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Setor</label>
              <p><select class="select2" tabindex="-1" name="setorcad" id="setor">
                @foreach ($setores as $setor)
                  <option value="{{$setor->id_setor}}">{{$setor->setor}}</option>
                @endforeach
              </select></p>
            </div>

            <div class="col-sm-1">
              <label class="control-label">Ativo</label>
              <p><select class="select-notsearch" tabindex="-1" name="ativaview" id="ativa_view">
                <option value="1">Sim</option>
                <option value="0">Não</option>
              </select></p>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label>Observação</label>
                <textarea class="form-control" name="obscad" id="observacao" maxlength="200" rows="4" placeholder="(OPCIONAL) O tamanho máximo é de  200 caracteres."></textarea>
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
    </div>4
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
        <form class="form-horizontal" method="POST" action="{{action('ClienteController@destroy')}}">
          @csrf
          <input type="text" class="form-control col-form-label-sm" id="iddelete" name="iddelete">
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
<script src="{{url('/')}}/js/pages/transportadora.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/mask/jquery.mask.min.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endsection