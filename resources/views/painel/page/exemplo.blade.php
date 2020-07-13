@extends('painel.template.template')

@section('title','Empresa')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
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
              data-target="#AlterarCadModal"> Alterar</button>
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger"> Excluir</button>
          </td>
        </tr>
        <tr>
          <td>1</td>
          <td>Internet
            Explorer 5.0
          </td>
          <td><span class="badge badge-danger">Inativo</span></td>
          <td>
            <button type="button" class="btn btn-primary btn-sm fa fa-eye" data-toggle="modal"
              data-target="#VisualizarCadModal"> Visualizar</button>
            <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarCadModal"> Alterar</button>
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger"> Excluir</button>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>Internet
            Explorer 5.5
          </td>
          <td><span class="badge badge-danger">Inativo</span></td>
          <td>
            <button type="button" class="btn btn-primary btn-sm fa fa-eye" data-toggle="modal"
              data-target="#VisualizarCadModal"> Visualizar</button>
            <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarCadModal"> Alterar</button>
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
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="b_add_modalHeader">
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
              <label class="control-label">Nome</label>
              <input class="form-control" type="text" name="nomecad" placeholder="Digite o nome" required>
            </div>


            <div class="col-sm-6">
              <label class="control-label">Escola/Setor</label>
              <select class="form-control">
                <option>Alabama</option>
                <option>Alaska</option>
                <option>California</option>
                <option>Delaware</option>
                <option>Tennessee</option>
                <option>Texas</option>
                <option>Washington</option>
              </select>
              <p></p>
            </div>

            <div class="col-sm-6">
              <label class="control-label">Login</label>
              <input class="form-control" type="email" name="logincad" placeholder="Digite o login" required>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Senha</label>
              <input class="form-control" type="password" name="passwordcad" placeholder="Digite a senha" required>
            </div>



            <div class="col-sm-3">
              <label class="control-label">Perfil</label>
              <select class="select" name="perfilcad">
                <option value="1">AAA</option>
              </select>
              <p></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Status</label>
              <select class="form-control" name="statuscad">
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
              </select>
            </div>

            <div class="col-sm-6">
              <label class="control-label">Foto de Perfil</label>
              <input class="filestyle" type="file" name="fotocad" id="fileImg" accept=".jpg,.png">
            </div>

            <div class="col-sm-3">
              <img id="previewImg" src="storage/img/users/default.jpg" alt="User Image" class="imgCad">
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
  <script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
  <script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  @endsection