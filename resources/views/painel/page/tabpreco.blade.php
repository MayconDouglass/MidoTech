@extends('painel.template.template')

@section('title','Tabela de Preço')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Tabela de Preço
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
          <li class="breadcrumb-item active">Tabelas Genéricas</li>
          <li class="breadcrumb-item active">Tabela de Preço</li>
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
          <th>Descrição</th>
          <th class="statusDataTab">Status</th>
          <th class="actionDataTab">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($tabPrecos as $tabPreco)
        <tr>
          <td class="idDataTabText">{{$tabPreco->id_tabela}}</td>
          <td>{{$tabPreco->descricao}}</td>
          <td>
            <span @if ($tabPreco->ativo > 0) class="badge badge-success" @else class="badge badge-danger"
              @endif>{{$tabPreco->ativo ? "Ativo" : "Inativo"}}</span>
          </td>
          <td>
            <button type="button" class="btn btn-primary btn-sm fa fa-eye" data-toggle="modal"
              data-target="#VisualizarTabPrecoModal" data-codigo="{{$tabPreco->id_tabela}}"
              data-empresa="{{$tabPreco->emp_cod}}" data-descricao="{{$tabPreco->descricao}}"
              data-prevenda="{{$tabPreco->prevenda}}" data-pedidoweb="{{$tabPreco->pedidoweb}}"
              data-status="{{$tabPreco->ativo}}">
              Visualizar</button>

            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 2)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarTabPrecoModal" data-codigo="{{$tabPreco->id_tabela}}"
              data-empresa="{{$tabPreco->emp_cod}}" data-descricao="{{$tabPreco->descricao}}"
              data-prevenda="{{$tabPreco->prevenda}}" data-pedidoweb="{{$tabPreco->pedidoweb}}"
              data-status="{{$tabPreco->ativo}}">
              Alterar
            </button>
            @endif
            @endforeach
            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 3)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger" data-codigo="{{$tabPreco->id_tabela}}">
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
          <h5 class="modal-title" id="CadastroModalLabel">Nova Tabela de Preço</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('TabPrecoController@store')}}"
          enctype="multipart/form-data">
          @csrf
          <div class="form-group row">
            <div class="col-sm-12">
              <label class="control-label">Descricao</label>
              <p><input class="form-control" type="text" name="descricaocad" maxlength="60" required></p>
            </div>
           
            <div class="col-sm-12">
            <input class="form-control" type="hidden" name="empresacad" value="{{$uempresa}}" required>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Ativo</label>
              <p><select class="select-notsearch" tabindex="-1" name="statuscad">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Pré Venda</label>
              <p><select class="select-notsearch" tabindex="-1" name="prevendacad">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Pedido Web</label>
              <p><select class="select-notsearch" tabindex="-1" name="pedwebcad">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
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
<div class="modal fade" id="AlterarTabPrecoModal" tabindex="-1" role="dialog"
  aria-labelledby="AlterarTabPrecoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="alt_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="AlterarTabPrecoModalLabel">Alterar Tabela de Preço</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('TabPrecoController@update')}}"
          enctype="multipart/form-data">
          @csrf
          <div class="form-group row">

            <div class="col-sm-12">
              <input class="form-control" type="hidden" name="idTabPrecoAlt" id="idTabPrecoAlt">
              <label class="control-label">Descricao</label>
              <p><input class="form-control" type="text" name="descricaoalt" id="descrical_alt" maxlength="60" disabled>
              </p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Ativo</label>
              <p><select class="select-notsearch" tabindex="-1" name="statusalt" id="status_alt">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Pré Venda</label>
              <p><select class="select-notsearch" tabindex="-1" name="prevendaalt" id="prevenda_alt">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Pedido Web</label>
              <p><select class="select-notsearch" tabindex="-1" name="pedwebalt" id="pedweb_alt">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
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
        <form class="form-horizontal" method="POST" action="{{action('TabPrecoController@destroy')}}">
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
<div class="modal fade" id="VisualizarTabPrecoModal" tabindex="-1" role="dialog"
  aria-labelledby="VisualizarTabPrecoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="view_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="VisualizarTabPrecoModalLabel"></h5>
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
            <div class="col-sm-3">
              <label class="control-label">ID</label>
              <p><input class="form-control" type="text" name="idTabPreco_view" id="idTabPreco_view" disabled></p>
            </div>

            <div class="col-sm-9">
              <label class="control-label">Descricao</label>
              <p><input class="form-control" type="text" name="descricao_view" id="descricao_view" maxlength="60" disabled>
              </p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Ativo</label>
              <p><select class="select-notsearch" tabindex="-1" name="status_view" id="status_view" disabled>
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Pré Venda</label>
              <p><select class="select-notsearch" tabindex="-1" name="prevenda_view" id="prevenda_view" disabled>
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Pedido Web</label>
              <p><select class="select-notsearch" tabindex="-1" name="pedweb_view" id="pedweb_view" disabled>
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




@endsection


@section('js')
<script src="{{url('/')}}/js/pages/tabpreco.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endsection