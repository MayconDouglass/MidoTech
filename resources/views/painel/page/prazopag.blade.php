@extends('painel.template.template')

@section('title','Prazo de Pagamento')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Prazo de Pagamento
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
          <li class="breadcrumb-item active">Prazo de Pagamento</li>
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
          <th>Nº Parcelas</th>
          <th>Tipo</th>
          <th class="statusDataTab">Status</th>
          <th class="actionDataTab">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($prazoPagamentos as $prazoPagamento)
        <tr>
          <td class="idDataTabText">{{$prazoPagamento->id_prazo}}</td>
          <td>{{$prazoPagamento->descricao}}</td>
          <td>{{$prazoPagamento->num_parcelas}}</td>
          <td>@switch($prazoPagamento->tipo_prazo)
            @case(0)
            <span class="badge badge-info">A Vista</span>
            @break
            @case(1)
            <span class="badge badge-warning">A Prazo</span>
            @break
            @case(2)
            <span class="badge badge-success">Livre de Débito</span>
            @break
            @default
            <span class="badge badge-danger">Erro</span>
            @endswitch</td>
          <td>
            <span @if ($prazoPagamento->ativo > 0) class="badge badge-success" @else class="badge badge-danger"
              @endif>{{$prazoPagamento->ativo ? "Ativo" : "Inativo"}}</span>
          </td>
          <td>
            <button type="button" class="btn btn-primary btn-sm fa fa-eye" data-toggle="modal"
              data-target="#VisualizarPrazoModal" data-codigo="{{$prazoPagamento->id_prazo}}"
              data-descricao="{{$prazoPagamento->descricao}}" data-taxa_diario="{{$prazoPagamento->taxa_diario}}"
              data-multa_atraso="{{$prazoPagamento->multa_atraso}}" data-intervalo="{{$prazoPagamento->intervalodias}}"
              data-acrescimo="{{$prazoPagamento->acrescimo_financeiro}}"
              data-desc_prazo="{{$prazoPagamento->desc_prazo}}" data-tipo="{{$prazoPagamento->tipo_prazo}}"
              data-parcelas="{{$prazoPagamento->num_parcelas}}" data-status="{{$prazoPagamento->ativo}}">
              Visualizar</button>

            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 2)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarPrazoModal" data-codigo="{{$prazoPagamento->id_prazo}}"
              data-descricao="{{$prazoPagamento->descricao}}" data-taxa_diario="{{$prazoPagamento->taxa_diario}}"
              data-multa_atraso="{{$prazoPagamento->multa_atraso}}"
              data-acrescimo="{{$prazoPagamento->acrescimo_financeiro}}"
              data-desc_prazo="{{$prazoPagamento->desc_prazo}}" data-status="{{$prazoPagamento->ativo}}">
              Alterar</button>
            @endif
            @endforeach
            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 3)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger" data-codigo="{{$prazoPagamento->id_prazo}}">
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
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="add_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="CadastroModalLabel">Novo Prazo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('PrazoController@store')}}"
          enctype="multipart/form-data">
          @csrf
          <div class="form-group row">
            <div class="col-sm-3">
              <label class="control-label">Descricao</label>
              <p><input class="form-control" type="text" name="descricaocad" id="nome" maxlength="60" required></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Parcelas</label>
              <p><input class="form-control" type="number" min="1" name="parcelascad" id="rowparcelas" value="1"
                  required></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">I.Dias</label>
              <p><input class="form-control" type="number" min="1" name="diascad" id="intDias" value="1" required></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Tipo de Prazo*</label>
              <select class="select-notsearch" tabindex="-1" name="tipocad" id="tipo_cod">
                <option value="0">A Vista</option>
                <option value="1">A Prazo</option>
                <option value="2">Livre de Débito</option>
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Ativo</label>
              <p><select class="select-notsearch" tabindex="-1" name="statuscad" id="status_cod">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Taxa de Juros Diário (%)</label>
              <input class="form-control" type="number" min="0" name="taxajuroscad" id="taxajuros" value="0.00"
                required>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Multa por Atraso (%)</label>
              <input class="form-control" type="number" min="0" name="multacad" id="multa" value="0.00" required>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Acréscimo Financeiro (%)</label>
              <input class="form-control" type="number" min="0" name="acrescimocad" id="multa" value="0.00" required>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Desc. Pagto no Prazo (%)</label>
              <p><input class="form-control" type="number" min="0" name="descontocad" id="desconto" value="0.00"
                  required></p>
            </div>

            <div>
              <label class="control-label">* Caso o tipo de prazo esteja selecionado como "A Vista" sempre será 1 parcela, ignorando o campo Parcelas.</label>
            </div>

          </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="reset" data-dismiss="modal"><i class="fa fa-times">
            Cancelar</i></button>
        <button type="submit" class="btn btn-primary" id="btnSalvarParcelas" name="btnSalvar"><i class="fa fa-floppy-o">
            Salvar</i></button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>

<!-- Modal Alteracao-->
<div class="modal fade" id="AlterarPrazoModal" tabindex="-1" role="dialog" aria-labelledby="AlterarPrazoModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="alt_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="AlterarPrazoModalLabel">Alterar Prazo de pagamento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('PrazoController@update')}}"
          enctype="multipart/form-data">
          @csrf
          <div class="form-group row">
            <div class="col-sm-12">
              <p><input class="form-control" type="hidden" name="idPrazoAlt" id="idPrazo_alt"></p>
            </div>

            <div class="col-sm-8">
              <label class="control-label">Descricao</label>
              <p><input class="form-control" type="text" name="descricaoAlt" id="descricao_alt" disabled>
              </p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Ativo</label>
              <p><select class="select-notsearch" tabindex="-1" name="statusAlt" id="status_alt">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Taxa de Juros Diário (%)</label>
              <input class="form-control" type="number" min="0" name="taxajurosAlt" id="taxajuros_alt" required>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Multa por Atraso (%)</label>
              <input class="form-control" type="number" min="0" name="multaAlt" id="multa_alt" required>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Acréscimo Financeiro (%)</label>
              <input class="form-control" type="number" min="0" name="acrescimoAlt" id="acrescimo_alt" required>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Desc. Pagto no Prazo (%)</label>
              <p><input class="form-control" type="number" min="0" name="descontoAlt" id="desconto_alt" required></p>
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
        <form class="form-horizontal" method="POST" action="{{action('PrazoController@destroy')}}">
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
<div class="modal fade" id="VisualizarPrazoModal" tabindex="-1" role="dialog"
  aria-labelledby="VisualizarPrazoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="view_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="VisualizarPrazoModalLabel"></h5>
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
              <p><input class="form-control" type="text" name="idPrazoView" id="idPrazoView" disabled></p>
            </div>
            <div class="col-sm-3">
              <label class="control-label">Descricao</label>
              <p><input class="form-control" type="text" name="descricaoView" id="descricaoView" disabled></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Parcelas</label>
              <p><input class="form-control" type="number" min="1" name="parcelasView" id="parcelasView" value="1"
                  disabled></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">I.Dias</label>
              <p><input class="form-control" type="number" min="1" name="diasView" id="diasView" value="1" disabled></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Tipo de Prazo</label>
              <select class="select-notsearch" tabindex="-1" name="tipoView" id="tipoView" disabled>
                <option value="0">A Vista</option>
                <option value="1">A Prazo</option>
                <option value="2">Livre de Débito</option>
              </select>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Taxa de Juros Diário (%)</label>
              <input class="form-control" type="number" min="0" name="taxajurosView" id="taxajurosView" disabled>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Multa por Atraso (%)</label>
              <input class="form-control" type="number" min="0" name="multaView" id="multaView" disabled>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Acréscimo Financeiro (%)</label>
              <input class="form-control" type="number" min="0" name="acrescimoView" id="acrescimoView" disabled>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Desc. Pagto no Prazo (%)</label>
              <p><input class="form-control" type="number" min="0" name="descontoView" id="descontoView" disabled></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Ativo</label>
              <p><select class="select-notsearch" tabindex="-1" name="statusView" id="statusView" disabled>
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
<script src="{{url('/')}}/js/pages/prazopag.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endsection