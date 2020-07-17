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
          <button type="button" class="btn btn-primary fa fa-user-plus" data-toggle="modal"
            data-target="#CadastroModal">
            Cadastrar</button></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index">Home</a></li>
          <li class="breadcrumb-item active">Empresas</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

@if (session('status_error'))
<div class="alert alert-danger">
  {{ session('status_error') }}
</div>
@endif
@if (session('status_success'))
<div class="alert alert-success">
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
        <tr>
          <td>1</td>
          <td>Internet
            Explorer 4.0
          </td>
          <td><span class="badge badge-success">Ativo</span></td>
          <td>
            <button type="button" class="btn btn-primary btn-sm fa fa-eye" data-toggle="modal"
              data-target="#VisualizarCadModal"> Visualizar</button>
            <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarCadEmpModal"> Alterar</button>
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger"> Excluir</button>
          </td>
        </tr>

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
                <input type="file" class="custom-file-input" id="customFile">
                <label class="custom-file-label" for="customFile">Selecionar Logo</label>
              </div><br>
              <label class="control-label">Razão Social</label>
              <input class="form-control" type="text" name="razaocad" id="razao_social" required>
              <label class="control-label">Nome Fantasia</label>
              <input class="form-control" type="text" name="fantasiacad" id="nome_fantasia" required>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Regime Tributário</label>
              <select class="select-notsearch" tabindex="-1" name="regimecad" id="regime_tributario">
                <option value="1">Regime Normal</option>
                <option value="2">Regime Normal - excesso de sublimite da receita bruta</option>
                <option value="3">Simples Nacional</option>
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
                <option value="1">Consolidado</option>
                <option value="2">Individual</option>
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Ativa</label>
              <select class="select-notsearch" tabindex="-1" name="ativacad" id="ativa">
                <option value="1">Sim</option>
                <option value="2">Não</option>
              </select>
            </div>

            <div class="col-sm-1">
              <label class="control-label">SIGLA</label>
              <input class="form-control" type="text" name="siglacad" id="sigla">
            </div>

            <div class="col-sm-4">
              <label class="control-label">Logradouro</label>
              <input class="form-control" type="text" name="logradourocad" id="logradouro" required>
            </div>

            <div class="col-sm-1">
              <label class="control-label">Número</label>
              <input class="form-control" type="number" name="numerocad" id="numero" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Complemento</label>
              <input class="form-control" type="text" name="complementocad" id="complemento">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Bairro</label>
              <input class="form-control" type="text" name="bairrocad" id="bairro" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Cidade</label>
              <input class="form-control" type="text" name="cidadecad" id="cidade" required>
            </div>

            <div class="col-sm-1">
              <label class="control-label">UF</label>
              <input class="form-control" type="text" name="ufcad" id="uf" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">CEP</label>
              <input class="form-control" type="text" name="cepcad" id="cep" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">CNPJ</label>
              <input class="form-control" type="text" name="cnpjcad" id="cnpj" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Insc. Estadual</label>
              <input class="form-control" type="text" name="iecad" id="ie" required>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Insc. Municipal</label>
              <input class="form-control" type="text" name="imcad" id="im">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Telefone</label>
              <input class="form-control" type="text" name="telefonecad" id="telefone">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Data Cadastro</label>
              <input class="form-control" type="text" name="datacad" id="data_cadastro">
            </div>

            <div class="col-sm-6">
              <label class="control-label">Email</label>
              <input class="form-control" type="text" name="emailcad" id="email">
            </div>

            <div class="col-sm-6">
              <label class="control-label">Site</label>
              <input class="form-control" type="text" name="sitecad" id="site">
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


  @endsection


  @section('js')
  <script src="{{url('/')}}/js/pages/midotech.js"></script>
  <script src="{{url('/')}}/js/plugins/bs-custom-file-input/bs-custom-file-input.js"></script>
  <script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
  <script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
  <script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  @endsection