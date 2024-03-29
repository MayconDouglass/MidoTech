@extends('painel.template.template')

@section('title','Modo de Cobrança')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Modo de Cobranças
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
          <li class="breadcrumb-item active">Modo de Cobrança</li>
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
          <th>Cobrança</th>
          <th class="statusDataTab">Liberação de crédito</th>
          <th class="statusDataTab">Status</th>
          <th class="actionDataTab">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($modoCobs as $modoCob)
        <tr>
          <td class="idDataTabText">{{$modoCob->id_modocob}}</td>
          <td>{{$modoCob->descricao}}</td>
          <td>{{$modoCob->situacaomodcob->descricao}}</td>
          <td>
            @switch($modoCob->lib_credito)
            @case(1)
            <span class="badge badge-success">Sim</span>
            @break
            @case(2)
            <span class="badge badge-info">Obrigatório</span>
            @break
            @default
            <span class="badge badge-danger">Não</span>
            @endswitch
          </td>
          <td>
            <span @if ($modoCob->ativo > 0) class="badge badge-success" @else class="badge badge-danger"
              @endif>{{$modoCob->ativo ? "Ativo" : "Inativo"}}</span>
          </td>
          <td>
            <button type="button" class="btn btn-primary btn-sm fa fa-eye" data-toggle="modal"
              data-target="#VisualizarModCobModal" data-codigo="{{$modoCob->id_modocob}}"
              data-descricao="{{$modoCob->descricao}}" data-situacao="{{$modoCob->situacao}}"
              data-natureza="{{$modoCob->natureza}}" data-liberacao="{{$modoCob->lib_credito}}"
              data-pagnfe="{{$modoCob->pag_nfe}}" data-status="{{$modoCob->ativo}}"
              data-observacao="{{$modoCob->observacao}}" data-usucad="{{$modoCob->usuario->nome}}"
              data-usualt="{{$modoCob->usuarioAlt ? $modoCob->usuarioa->nome : "Sem alteração"}}"
              data-datacad="{{date('d/m/Y',strtotime($modoCob->dataCad))}}"
              data-dataalt="{{$modoCob->dataalt ? date('d/m/Y', strtotime($modoCob->dataAlt)) : "Sem alteração"}}">
              Visualizar</button>

            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 2)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarModCobModal" data-codigo="{{$modoCob->id_modocob}}"
              data-descricao="{{$modoCob->descricao}}" data-situacao="{{$modoCob->situacao}}"
              data-natureza="{{$modoCob->natureza}}" data-liberacao="{{$modoCob->lib_credito}}"
              data-pagnfe="{{$modoCob->pag_nfe}}" data-status="{{$modoCob->ativo}}"
              data-observacao="{{$modoCob->observacao}}" data-usucad="{{$modoCob->usuario->nome}}"
              data-usualt="{{$modoCob->usuarioAlt ? $modoCob->usuarioa->nome : "Sem alteração"}}"
              data-datacad="{{date('d/m/Y',strtotime($modoCob->dataCad))}}"
              data-dataalt="{{$modoCob->dataalt ? date('d/m/Y', strtotime($modoCob->dataAlt)) : "Sem alteração"}}">
              Alterar
            </button>
            @endif
            @endforeach
            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 3)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger" data-codigo="{{$modoCob->id_modocob}}">
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
          <h5 class="modal-title" id="CadastroModalLabel">Novo Modo de Cobrança</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('ModCobController@store')}}"
          enctype="multipart/form-data">
          @csrf
          <div class="form-group row">
            <div class="col-sm-8">
              <label class="control-label">Descricao</label>
              <p><input class="form-control" type="text" name="descricaocad" id="nome" maxlength="60" required></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Lib. de Crédito</label>
              <select class="select-notsearch" tabindex="-1" name="liberacaocad" id="liberacao_cod">
                <option value="1">Sim</option>
                <option value="0">Não</option>
                <option value="2">Obrigatório</option>
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Ativo</label>
              <p><select class="select-notsearch" tabindex="-1" name="statuscad" id="status_cod">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-6">
              <label class="control-label">Situação</label>
              <p><select class="select-notsearch" tabindex="-1" name="situacaocad" id="situacao_cod">
                  @foreach ($situacoesCob as $situacaoCob)
                  <option value="{{$situacaoCob->id_situacao}}">{{$situacaoCob->descricao}}</option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-6">
              <label class="control-label">Forma Pagamento NF-e</label>
              <p><select class="select-notsearch" tabindex="-1" name="formacad" id="forma_cod">
                  <option value="01">Dinheiro</option>
                  <option value="02">Cheque</option>
                  <option value="03">Cartão de Crédito</option>
                  <option value="04">Cartão de Débito</option>
                  <option value="05">Crédito Loja</option>
                  <option value="10">Vale Alimentação</option>
                  <option value="11">Vale Refeição</option>
                  <option value="12">Vale Presente</option>
                  <option value="13">Vale Combustivel</option>
                  <option value="15">Boleto Bancário</option>
                  <option value="90">Sem Pagamento</option>
                  <option value="99">Outros</option>
                </select></p>
            </div>


            <div class="col-sm-12">
              <label class="control-label">Natureza</label>
              <p><select class="select2" tabindex="-1" name="naturezacad" id="natureza_cod">
                  @foreach ($natOperacoes as $natOperacao)
                  <option value="{{$natOperacao->id_natoperacao}}">{{$natOperacao->descricao}}</option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-12">
              <label class="control-label">Observação</label>
              <textarea class="form-control" rows="3" name="obscad" maxlength="100"
                placeholder="Máximo 100 caracteres"></textarea>
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
<div class="modal fade" id="AlterarModCobModal" tabindex="-1" role="dialog" aria-labelledby="AlterarModCobModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="alt_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="AlterarModCobModalLabel">Alterar Modo de Cobrança</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('ModCobController@update')}}"
          enctype="multipart/form-data">
          @csrf
          <div class="form-group row">
            <div class="col-sm-12">
              <p><input class="form-control" type="hidden" name="idModCob" id="idModCob"></p>
            </div>
            <div class="col-sm-8">
              <label class="control-label">Descricao</label>
              <p><input class="form-control" type="text" name="descricaoalt" id="desc_alt" maxlength="60" disabled></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Lib. de Crédito</label>
              <select class="select-notsearch" tabindex="-1" name="liberacaoalt" id="liberacao_alt">
                <option value="1">Sim</option>
                <option value="0">Não</option>
                <option value="2">Obrigatório</option>
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Ativo</label>
              <p><select class="select-notsearch" tabindex="-1" name="statusalt" id="status_alt">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-6">
              <label class="control-label">Situação</label>
              <p><select class="select-notsearch" tabindex="-1" name="situacaoalt" id="situacao_alt">
                  @foreach ($situacoesCob as $situacaoCob)
                  <option value="{{$situacaoCob->id_situacao}}">{{$situacaoCob->descricao}}</option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-6">
              <label class="control-label">Forma Pagamento NF-e</label>
              <p><select class="select-notsearch" tabindex="-1" name="formaalt" id="forma_alt">
                  <option value="1">Dinheiro</option>
                  <option value="2">Cheque</option>
                  <option value="3">Cartão de Crédito</option>
                  <option value="4">Cartão de Débito</option>
                  <option value="5">Crédito Loja</option>
                  <option value="10">Vale Alimentação</option>
                  <option value="11">Vale Refeição</option>
                  <option value="12">Vale Presente</option>
                  <option value="13">Vale Combustivel</option>
                  <option value="15">Boleto Bancário</option>
                  <option value="90">Sem Pagamento</option>
                  <option value="99">Outros</option>
                </select></p>
            </div>

            <div class="col-sm-12">
              <label class="control-label">Natureza</label>
              <p><select class="select2" tabindex="-1" name="naturezaalt" id="natureza_alt">
                  @foreach ($natOperacoes as $natOperacao)
                  <option value="{{$natOperacao->id_natoperacao}}">{{$natOperacao->descricao}}</option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-12">
              <label class="control-label">Observação</label>
              <textarea class="form-control" rows="3" name="obsalt" maxlength="100" id="obs_alt"
                placeholder="Máximo 100 caracteres"></textarea>
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
        <form class="form-horizontal" method="POST" action="{{action('ModCobController@destroy')}}">
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
<div class="modal fade" id="VisualizarModCobModal" tabindex="-1" role="dialog"
  aria-labelledby="VisualizarModCobModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="view_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="VisualizarModCobModalLabel"></h5>
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
              <p><input class="form-control" type="text" name="descricaoview" id="idModCob" maxlength="60" disabled></p>
            </div>
            <div class="col-sm-6">
              <label class="control-label">Descricao</label>
              <p><input class="form-control" type="text" name="descricaoview" id="desc_view" maxlength="60" disabled>
              </p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Lib. de Crédito</label>
              <select class="select-notsearch" tabindex="-1" name="liberacaoview" id="liberacao_view" disabled>
                <option value="1">Sim</option>
                <option value="0">Não</option>
                <option value="2">Obrigatório</option>
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Ativo</label>
              <p><select class="select-notsearch" tabindex="-1" name="statusview" id="status_view" disabled>
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-6">
              <label class="control-label">Situação</label>
              <p><select class="select-notsearch" tabindex="-1" name="situacaoview" id="situacao_view" disabled>
                  @foreach ($situacoesCob as $situacaoCob)
                  <option value="{{$situacaoCob->id_situacao}}">{{$situacaoCob->descricao}}</option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-6">
              <label class="control-label">Forma Pagamento NF-e</label>
              <p><select class="select-notsearch" tabindex="-1" name="formaview" id="forma_view" disabled>
                  <option value="01">Dinheiro</option>
                  <option value="02">Cheque</option>
                  <option value="03">Cartão de Crédito</option>
                  <option value="04">Cartão de Débito</option>
                  <option value="05">Crédito Loja</option>
                  <option value="10">Vale Alimentação</option>
                  <option value="11">Vale Refeição</option>
                  <option value="12">Vale Presente</option>
                  <option value="13">Vale Combustivel</option>
                  <option value="15">Boleto Bancário</option>
                  <option value="90">Sem Pagamento</option>
                  <option value="99">Outros</option>
                </select></p>
            </div>

            <div class="col-sm-12">
              <label class="control-label">Natureza</label>
              <p><select class="select2" tabindex="-1" name="naturezaview" id="natureza_view" disabled>
                  @foreach ($natOperacoes as $natOperacao)
                  <option value="{{$natOperacao->id_natoperacao}}">{{$natOperacao->descricao}}</option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-12">
              <label class="control-label">Observação</label>
              <textarea class="form-control" rows="3" name="obsview" maxlength="100" id="obs_view"
                placeholder="Máximo 100 caracteres" disabled></textarea>
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
<script src="{{url('/')}}/js/pages/modcob.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endsection