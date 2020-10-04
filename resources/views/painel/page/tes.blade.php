@extends('painel.template.template')

@section('title','TES')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Tipos de Entrada e Saída
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
          <li class="breadcrumb-item active">TES</li>
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
          @foreach ($acessoPerfil as $acesso)
          @if (($acesso->role == 5)&&($acesso->ativo == 1))
          <th style="width: 10%">Empresa</th>
          @endif
          @if (($acesso->role == 5)&&($acesso->ativo == 0))
          <th style="width: 10%">Código</th>
          @endif
          @endforeach
          <th style="width: 40%">Descrição</th>
          <th style="width: 5%">CFOP</th>
          <th class="statusDataTab">Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($tes as $te)
        <tr>
          <td class="idDataTabText">{{$te->id_tes}}</td>
          @foreach ($acessoPerfil as $acesso)
          @if (($acesso->role == 5)&&($acesso->ativo == 1))
          <td>{{$te->setempresa->Sigla}}</td>
          @endif
          @if (($acesso->role == 5)&&($acesso->ativo == 0))
          <td>{{$te->cod_tes}}</td>
          @endif
          @endforeach
          <td>{{$te->descricao}}</td>
          <td>{{$te->operacaofiscal->cfop}}</td>
          <td>
            <span @if ($te->status > 0) class="badge badge-success" @else class="badge badge-danger"
              @endif>{{$te->status ? "Ativo" : "Inativo"}}</span>
          </td>
          <td>
            <button type="button" class="btn btn-primary btn-sm fa fa-eye" data-toggle="modal"
          data-target="#VisualizarTESModal" data-codigo="{{$te->id_tes}}">
              Visualizar</button>

            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 2)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarTESModal"  data-codigo="{{$te->id_tes}}">
              Alterar
            </button>
            @endif
            @endforeach

            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 3)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger" data-codigo="{{$te->id_tes}}">
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
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="add_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="CadastroModalLabel">Novo TES</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('TESController@store')}}"
          enctype="multipart/form-data">
          @csrf
          <div class="form-group row">

            <div class="col-sm-1">
              <label class="control-label">Código</label>
              <p><input class="form-control" type="text" name="codigocad" maxlength="3" required></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Descrição</label>
              <p><input class="form-control" type="text" name="descricaocad" maxlength="20" required></p>
            </div>
            <div class="col-sm-2">
              <label class="control-label">Tipo</label>
              <p><select class="select-notsearch" tabindex="-1" name="tipocad">
                  <option value="0">Entrada</option>
                  <option value="1">Saída</option>
                </select></p>
            </div>

            <div class="col-sm-6">
              <label class="control-label">CFOP</label>
              <p><select class="select2" tabindex="-1" name="cfopcad">
                  @foreach ($cfops as $cfop)
                  <option value="{{$cfop->id_operacao}}">{{$cfop->cfop .' - '. $cfop->descricao}}</option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-1">
              <label class="control-label">Ativo</label>
              <p><select class="select-notsearch" tabindex="-1" name="statuscad">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-1">
              <label class="control-label">Série</label>
              <p><input class="form-control" type="text" name="seriecad" maxlength="4" required></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Almoxarifado Padrão</label>
              <p><select class="select-notsearch" tabindex="-1" name="alcodcad">
                  <option value="1">AMC</option>
                </select></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Emitir Boleto</label>
              <p><select class="select-notsearch" tabindex="-1" name="boleto_cad">
                  <option value="0">Não</option>
                  <option value="1">Sim</option>
                  <option value="2">Duplicata</option>
                </select></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">INSS(%)</label>
              <p><input class="form-control" type="number" name="aliq_inss_cad" value="0.00" min="0.00" step="0.01"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">INSS - NFe Superior</label>
              <p><input class="form-control" type="number" name="inss_cad" value="0.00" min="0.00" step="0.01"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">ISS(%)</label>
              <p><input class="form-control" type="number" name="aliq_iss_cad" value="0.00" min="0.00" step="0.01"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">ISS - NFe Superior</label>
              <p><input class="form-control" type="number" name="iss_cad" value="0.00" min="0.00" step="0.01"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Alíquota IRRF(%)</label>
              <p><input class="form-control" type="number" name="aliq_irrf_cad" value="0.00" min="0.00" step="0.01"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">IRRF - NFe Superior</label>
              <p><input class="form-control" type="number" name="irrf_cad" value="0.00" min="0.00" step="0.01"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Retenção PIS</label>
              <p><input class="form-control" type="number" name="ret_pis_cad" value="0.00" min="0.00" step="0.01"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">PIS - NFe Superior</label>
              <p><input class="form-control" type="number" name="pis_nf_cad" value="0.00" min="0.00" step="0.01"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Retenção COFINS</label>
              <p><input class="form-control" type="number" name="ret_cofins_cad" value="0.00" min="0.00" step="0.01">
              </p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">COFINS - NFe Superior</label>
              <p><input class="form-control" type="number" name="cofins_nf_cad" value="0.00" min="0.00" step="0.01"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Retenção CSLL</label>
              <p><input class="form-control" type="number" name="ret_csll_cad" value="0.00" min="0.00" step="0.01"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Abat. Suframa - PIS</label>
              <p><input class="form-control" type="number" name="abat_suframa_pis_cad" value="0.00" min="0.00"
                  step="0.01"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Abat. Suframa - COFINS</label>
              <p><input class="form-control" type="number" name="abat_suframa_cofins_cad" value="0.00" min="0.00"
                  step="0.01"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Simples Nacional</label>
              <p><select class="select-notsearch" tabindex="-1" name="simples_cad">
                  <option value="0">Não</option>
                  <option value="1">Sim</option>
                </select></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Simples Nacional (%)</label>
              <p><input class="form-control" type="number" name="aliq_simples_cad" value="0.00" min="0.00" step="0.01">
              </p>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="calc_icms_cad" id="calc_icms_cad">
                <label for="calc_icms_cad" class="custom-control-label">Calcular ICMS</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="calc_ipi_cad" id="calc_ipi_cad">
                <label for="calc_ipi_cad" class="custom-control-label">Calcular IPI</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="cred_icm_cad" id="cred_icm_cad">
                <label for="cred_icm_cad" class="custom-control-label">Creditar ICM</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="cred_ipi_cad" id="cred_ipi_cad">
                <label for="cred_ipi_cad" class="custom-control-label">Creditar IPI</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="cred_piscofins_cad" id="cred_piscofins_cad">
                <label for="cred_piscofins_cad" class="custom-control-label">Creditar PIS e COFINS</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="financeiro_cad" id="financeiro_cad">
                <label for="financeiro_cad" class="custom-control-label">Gera Financeiro</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="emissao_cad" id="emissao_cad">
                <label for="emissao_cad" class="custom-control-label">Emissão</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="mov_est_cad" id="mov_est_cad">
                <label for="mov_est_cad" class="custom-control-label">Movimentar Estoque</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="dest_ipi_cad" id="dest_ipi_cad">
                <label for="dest_ipi_cad" class="custom-control-label">Destacar IPI</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="incide_ipi_cad" id="incide_ipi_cad">
                <label for="incide_ipi_cad" class="custom-control-label">Incide IPI na Base ICMS</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="incide_frete_cad" id="incide_frete_cad">
                <label for="incide_frete_cad" class="custom-control-label">Incide Frete na B. ICMS</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="incide_despesas_cad" id="incide_despesas_cad">
                <label for="incide_despesas_cad" class="custom-control-label">Outras Desp. na B. ICMS</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="incide_base_ipi_cad" id="incide_base_ipi_cad">
                <label for="incide_base_ipi_cad" class="custom-control-label">Frete/Despesas/Seguro na B. IPI</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="calc_iss_cad" id="calc_iss_cad">
                <label for="calc_iss_cad" class="custom-control-label">Calcular ISS</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="at_custo_cad" id="at_custo_cad">
                <label for="at_custo_cad" class="custom-control-label">Atualizar Custo</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="at_custo_medio_cad" id="at_custo_medio_cad">
                <label for="at_custo_medio_cad" class="custom-control-label">Atualizar C. Médio</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="at_custo_aq_cad" id="at_custo_aq_cad">
                <label for="at_custo_aq_cad" class="custom-control-label">Atualizar C. Aquisição</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="at_preco_cad" id="at_preco_cad">
                <label for="at_preco_cad" class="custom-control-label">Atualizar P. de Venda</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="soma_cad" id="soma_cad">
                <label for="soma_cad" class="custom-control-label">Influencia em Relatórios</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="espelho_cad" name="espelho_cad">
                <label for="espelho_cad" class="custom-control-label">Imprime Espelho NFe</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="comissao_cad" name="comissao_cad">
                <label for="comissao_cad" class="custom-control-label">Comissão</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="calc_import_cad" name="calc_import_cad">
                <label for="calc_import_cad" class="custom-control-label">Calc. Importação</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="soma_import_cad" name="soma_import_cad">
                <label for="soma_import_cad" class="custom-control-label">Soma ICMS Importação no total</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="lanc_ipi_cad" name="lanc_ipi_cad">
                <label for="lanc_ipi_cad" class="custom-control-label">Lançar IPI na 1ª Parcela (*)</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="incide_icms_pci_cad" name="incide_icms_pci_cad">
                <label for="incide_icms_pci_cad" class="custom-control-label">ICMS na B. PIS e COFINS Imp.</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="incide_despesas_pc_cad"
                  name="incide_despesas_pc_cad">
                <label for="incide_despesas_pc_cad" class="custom-control-label">Outras Desp. na B. PIS e COFINS</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="ded_icms_pc_cad" name="ded_icms_pc_cad">
                <label for="ded_icms_pc_cad" class="custom-control-label">Deduzir ICMS na B. PIS e COFINS</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="calc_fecp_cad" name="calc_fecp_cad">
                <label for="calc_fecp_cad" class="custom-control-label">Calcular FECP</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="calc_difal_cad" name="calc_difal_cad">
                <label for="calc_difal_cad" class="custom-control-label">Calcular Partilha (Difal)</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="dup_st_cad" name="dup_st_cad">
                <label for="dup_st_cad" class="custom-control-label">Gerar Duplicata ST</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="desc_icms_cad" name="desc_icms_cad">
                <label for="desc_icms_cad" class="custom-control-label">Não incide desconto B. ICMS</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="desc_icms_des_cad" name="desc_icms_des_cad">
                <label for="desc_icms_des_cad" class="custom-control-label">Subtrair Desoneração na Nota</label>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="desc_ipi_cad" name="desc_ipi_cad">
                <label for="desc_ipi_cad" class="custom-control-label">Deduz Desconto na B. IPI</label>
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
        <form class="form-horizontal" method="POST" action="{{action('TESController@destroy')}}">
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
<div class="modal fade" id="VisualizarTESModal" tabindex="-1" role="dialog"
  aria-labelledby="VisualizarTESModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="view_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="VisualizarTESModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST"></form>
        @csrf
        <div class="form-group row">
          <div class="col-sm-1">
            <label class="control-label">Código</label>
            <p><input class="form-control" type="text" id="codigoview" maxlength="3" disabled></p>
          </div>

          <div class="col-sm-3">
            <label class="control-label">Descrição</label>
            <p><input class="form-control" type="text" id="descricaoview" maxlength="20" disabled></p>
          </div>
          <div class="col-sm-2">
            <label class="control-label">Tipo</label>
            <p><select class="select-notsearch" tabindex="-1" disabled id="tipoview">
                <option value="0">Entrada</option>
                <option value="1">Saída</option>
              </select></p>
          </div>

          <div class="col-sm-6">
            <label class="control-label">CFOP</label>
            <p><select class="select2" tabindex="-1" disabled id="cfopview">
                @foreach ($cfops as $cfop)
                <option value="{{$cfop->id_operacao}}">{{$cfop->cfop .' - '. $cfop->descricao}}</option>
                @endforeach
              </select></p>
          </div>

          <div class="col-sm-1">
            <label class="control-label">Ativo</label>
            <p><select class="select-notsearch" tabindex="-1" disabled id="statusview">
                <option value="1">Sim</option>
                <option value="0">Não</option>
              </select></p>
          </div>

          <div class="col-sm-1">
            <label class="control-label">Série</label>
            <p><input class="form-control" type="text" disabled id="serieview" maxlength="4" disabled></p>
          </div>

          <div class="col-sm-2">
            <label class="control-label">Almoxarifado Padrão</label>
            <p><select class="select-notsearch" tabindex="-1" disabled id="alcodview">
                <option value="1">AMC</option>
              </select></p>
          </div>

          <div class="col-sm-2">
            <label class="control-label">Emitir Boleto</label>
            <p><select class="select-notsearch" tabindex="-1" disabled id="boleto_view">
                <option value="0">Não</option>
                <option value="1">Sim</option>
                <option value="2">Duplicata</option>
              </select></p>
          </div>

          <div class="col-sm-2">
            <label class="control-label">INSS(%)</label>
            <p><input class="form-control" type="text" disabled id="aliq_inss_view" value="0.00" min="0.00"
                step="0.01">
            </p>
          </div>

          <div class="col-sm-2">
            <label class="control-label">INSS - NFe Superior</label>
            <p><input class="form-control" type="text" disabled id="inss_view" value="0.00" min="0.00" step="0.01">
            </p>
          </div>

          <div class="col-sm-2">
            <label class="control-label">ISS(%)</label>
            <p><input class="form-control" type="text" disabled id="aliq_iss_view" value="0.00" min="0.00"
                step="0.01">
            </p>
          </div>

          <div class="col-sm-2">
            <label class="control-label">ISS - NFe Superior</label>
            <p><input class="form-control" type="text" disabled id="iss_view" value="0.00" min="0.00" step="0.01"></p>
          </div>

          <div class="col-sm-2">
            <label class="control-label">Alíquota IRRF(%)</label>
            <p><input class="form-control" type="text" disabled id="aliq_irrf_view" value="0.00" min="0.00"
                step="0.01">
            </p>
          </div>

          <div class="col-sm-2">
            <label class="control-label">IRRF - NFe Superior</label>
            <p><input class="form-control" type="text" disabled id="irrf_view" value="0.00" min="0.00" step="0.01">
            </p>
          </div>

          <div class="col-sm-2">
            <label class="control-label">Retenção PIS</label>
            <p><input class="form-control" type="text" disabled id="ret_pis_view" value="0.00" min="0.00" step="0.01">
            </p>
          </div>

          <div class="col-sm-2">
            <label class="control-label">PIS - NFe Superior</label>
            <p><input class="form-control" type="text" disabled id="pis_nf_view" value="0.00" min="0.00" step="0.01">
            </p>
          </div>

          <div class="col-sm-2">
            <label class="control-label">Retenção COFINS</label>
            <p><input class="form-control" type="text" disabled id="ret_cofins_view" value="0.00" min="0.00"
                step="0.01">
            </p>
          </div>

          <div class="col-sm-2">
            <label class="control-label">COFINS - NFe Superior</label>
            <p><input class="form-control" type="text" disabled id="cofins_nf_view" value="0.00" min="0.00"
                step="0.01">
            </p>
          </div>

          <div class="col-sm-2">
            <label class="control-label">Retenção CSLL</label>
            <p><input class="form-control" type="text" disabled id="ret_csll_view" value="0.00" min="0.00"
                step="0.01">
            </p>
          </div>

          <div class="col-sm-2">
            <label class="control-label">Abat. Suframa - PIS</label>
            <p><input class="form-control" type="text" disabled id="abat_suframa_pis_view" value="0.00" min="0.00"
                step="0.01"></p>
          </div>

          <div class="col-sm-2">
            <label class="control-label">Abat. Suframa - COFINS</label>
            <p><input class="form-control" type="text" disabled id="abat_suframa_cofins_view" value="0.00" min="0.00"
                step="0.01"></p>
          </div>

          <div class="col-sm-2">
            <label class="control-label">Simples Nacional</label>
            <p><select class="select-notsearch" tabindex="-1" disabled id="simples_view">
                <option value="0">Não</option>
                <option value="1">Sim</option>
              </select></p>
          </div>

          <div class="col-sm-2">
            <label class="control-label">Simples Nacional (%)</label>
            <p><input class="form-control" type="text" disabled id="aliq_simples_view" value="0.00" min="0.00"
                step="0.01">
            </p>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="calc_icms_view" disabled id="calc_icms_view">
              <label for="calc_icms_view" class="custom-control-label">Calcular ICMS</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="calc_ipi_view" disabled id="calc_ipi_view">
              <label for="calc_ipi_view" class="custom-control-label">Calcular IPI</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="cred_icm_view" disabled id="cred_icm_view">
              <label for="cred_icm_view" class="custom-control-label">Creditar ICM</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="cred_ipi_view" disabled id="cred_ipi_view">
              <label for="cred_ipi_view" class="custom-control-label">Creditar IPI</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="cred_piscofins_view" disabled
                id="cred_piscofins_view">
              <label for="cred_piscofins_view" class="custom-control-label">Creditar PIS e COFINS</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="financeiro_view" disabled id="financeiro_view">
              <label for="financeiro_view" class="custom-control-label">Gera Financeiro</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="emissao_view" disabled id="emissao_view">
              <label for="emissao_view" class="custom-control-label">Emissão</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="mov_est_view" disabled id="mov_est_view">
              <label for="mov_est_view" class="custom-control-label">Movimentar Estoque</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="dest_ipi_view" disabled id="dest_ipi_view">
              <label for="dest_ipi_view" class="custom-control-label">Destacar IPI</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="incide_ipi_view" disabled id="incide_ipi_view">
              <label for="incide_ipi_view" class="custom-control-label">Incide IPI na Base ICMS</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="incide_frete_view" disabled
                id="incide_frete_view">
              <label for="incide_frete_view" class="custom-control-label">Incide Frete na B. ICMS</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="incide_despesas_view" disabled
                id="incide_despesas_view">
              <label for="incide_despesas_view" class="custom-control-label">Outras Desp. na B. ICMS</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="incide_base_ipi_view" disabled
                id="incide_base_ipi_view">
              <label for="incide_base_ipi_view" class="custom-control-label">Frete/Despesas/Seguro na B. IPI</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="calc_iss_view" disabled id="calc_iss_view">
              <label for="calc_iss_view" class="custom-control-label">Calcular ISS</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="at_custo_view" disabled id="at_custo_view">
              <label for="at_custo_view" class="custom-control-label">Atualizar Custo</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="at_custo_medio_view" disabled
                id="at_custo_medio_view">
              <label for="at_custo_medio_view" class="custom-control-label">Atualizar C. Médio</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="at_custo_aq_view" disabled
                id="at_custo_aq_view">
              <label for="at_custo_aq_view" class="custom-control-label">Atualizar C. Aquisição</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="at_preco_view" disabled id="at_preco_view">
              <label for="at_preco_view" class="custom-control-label">Atualizar P. de Venda</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" name="soma_view" disabled id="soma_view">
              <label for="soma_view" class="custom-control-label">Influencia em Relatórios</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" disabled id="espelho_view" name="espelho_view">
              <label for="espelho_view" class="custom-control-label">Imprime Espelho NFe</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" disabled id="comissao_view" name="comissao_view">
              <label for="comissao_view" class="custom-control-label">Comissão</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" disabled id="calc_import_view"
                name="calc_import_view">
              <label for="calc_import_view" class="custom-control-label">Calc. Importação</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" disabled id="soma_import_view"
                name="soma_import_view">
              <label for="soma_import_view" class="custom-control-label">Soma ICMS Importação no total</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" disabled id="lanc_ipi_view" name="lanc_ipi_view">
              <label for="lanc_ipi_view" class="custom-control-label">Lançar IPI na 1ª Parcela (*)</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" disabled id="incide_icms_pci_view"
                name="incide_icms_pci_view">
              <label for="incide_icms_pci_view" class="custom-control-label">ICMS na B. PIS e COFINS Imp.</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" disabled id="incide_despesas_pc_view"
                name="incide_despesas_pc_view">
              <label for="incide_despesas_pc_view" class="custom-control-label">Outras Desp. na B. PIS e COFINS</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" disabled id="ded_icms_pc_view"
                name="ded_icms_pc_view">
              <label for="ded_icms_pc_view" class="custom-control-label">Deduzir ICMS na B. PIS e COFINS</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" disabled id="calc_fecp_view" name="calc_fecp_view">
              <label for="calc_fecp_view" class="custom-control-label">Calcular FECP</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" disabled id="calc_difal_view" name="calc_difal_view">
              <label for="calc_difal_view" class="custom-control-label">Calcular Partilha (Difal)</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" disabled id="dup_st_view" name="dup_st_view">
              <label for="dup_st_view" class="custom-control-label">Gerar Duplicata ST</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" disabled id="desc_icms_view" name="desc_icms_view">
              <label for="desc_icms_view" class="custom-control-label">Não incide desconto B. ICMS</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" disabled id="desc_icms_des_view"
                name="desc_icms_des_view">
              <label for="desc_icms_des_view" class="custom-control-label">Subtrair Desoneração na Nota</label>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" disabled id="desc_icms_ipi_view"
                name="desc_icms_ipi_view">
              <label for="desc_icms_ipi_view" class="custom-control-label">Deduz Desconto na B. IPI</label>
            </div>
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

<!-- Modal Alteracao-->
<div class="modal fade" id="AlterarTESModal" tabindex="-1" role="dialog" aria-labelledby="AlterarSetorModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="alt_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="AlterarTESModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('TESController@update')}}">
          @csrf
          <div class="form-group row">
            <div class="col-sm-1">
              <label class="control-label">Código</label>
              <input class="form-control" type="hidden" id="idTES" name="idTES">
              <p><input class="form-control" type="text" id="codigoalt" name="codigoalt" maxlength="3" disabled></p>
            </div>
  
            <div class="col-sm-3">
              <label class="control-label">Descrição</label>
              <p><input class="form-control" type="text" id="descricaoalt"  name="descricaoalt" maxlength="20"></p>
            </div>
            <div class="col-sm-2">
              <label class="control-label">Tipo</label>
              <p><select class="select-notsearch" tabindex="-1" id="tipoalt" name="tipoalt" disabled>
                  <option value="0">Entrada</option>
                  <option value="1">Saída</option>
                </select></p>
            </div>
  
            <div class="col-sm-6">
              <label class="control-label">CFOP</label>
              <p><select class="select2" tabindex="-1" id="cfopalt"  name="cfopalt">
                  @foreach ($cfops as $cfop)
                  <option value="{{$cfop->id_operacao}}">{{$cfop->cfop .' - '. $cfop->descricao}}</option>
                  @endforeach
                </select></p>
            </div>
  
            <div class="col-sm-1">
              <label class="control-label">Ativo</label>
              <p><select class="select-notsearch" tabindex="-1" id="statusalt" name="statusalt">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>
  
            <div class="col-sm-1">
              <label class="control-label">Série</label>
              <p><input class="form-control" type="text" id="seriealt" name="seriealt" maxlength="4"></p>
            </div>
  
            <div class="col-sm-2">
              <label class="control-label">Almoxarifado Padrão</label>
              <p><select class="select-notsearch" tabindex="-1" id="alcodalt" name="alcodalt">
                  <option value="1">AMC</option>
                </select></p>
            </div>
  
            <div class="col-sm-2">
              <label class="control-label">Emitir Boleto</label>
              <p><select class="select-notsearch" tabindex="-1" id="boleto_alt" name="boleto_alt">
                  <option value="0">Não</option>
                  <option value="1">Sim</option>
                  <option value="2">Duplicata</option>
                </select></p>
            </div>
  
            <div class="col-sm-2">
              <label class="control-label">INSS(%)</label>
              <p><input class="form-control" type="number" id="aliq_inss_alt" name="aliq_inss_alt" value="0.00" min="0.00"
                  step="0.01">
              </p>
            </div>
  
            <div class="col-sm-2">
              <label class="control-label">INSS - NFe Superior</label>
              <p><input class="form-control" type="number" id="inss_alt" name="inss_alt" value="0.00" min="0.00" step="0.01">
              </p>
            </div>
  
            <div class="col-sm-2">
              <label class="control-label">ISS(%)</label>
              <p><input class="form-control" type="number" id="aliq_iss_alt" name="aliq_iss_alt" value="0.00" min="0.00"
                  step="0.01">
              </p>
            </div>
  
            <div class="col-sm-2">
              <label class="control-label">ISS - NFe Superior</label>
              <p><input class="form-control" type="number" id="iss_alt" name="iss_alt" value="0.00" min="0.00" step="0.01"></p>
            </div>
  
            <div class="col-sm-2">
              <label class="control-label">Alíquota IRRF(%)</label>
              <p><input class="form-control" type="number" id="aliq_irrf_alt" name="aliq_irrf_alt" value="0.00" min="0.00"
                  step="0.01">
              </p>
            </div>
  
            <div class="col-sm-2">
              <label class="control-label">IRRF - NFe Superior</label>
              <p><input class="form-control" type="number" id="irrf_alt" name="irrf_alt" value="0.00" min="0.00" step="0.01">
              </p>
            </div>
  
            <div class="col-sm-2">
              <label class="control-label">Retenção PIS</label>
              <p><input class="form-control" type="number" id="ret_pis_alt" name="ret_pis_alt" value="0.00" min="0.00" step="0.01">
              </p>
            </div>
  
            <div class="col-sm-2">
              <label class="control-label">PIS - NFe Superior</label>
              <p><input class="form-control" type="number" id="pis_nf_alt" name="pis_nf_alt" value="0.00" min="0.00" step="0.01">
              </p>
            </div>
  
            <div class="col-sm-2">
              <label class="control-label">Retenção COFINS</label>
              <p><input class="form-control" type="number" id="ret_cofins_alt" name="ret_cofins_alt" value="0.00" min="0.00"
                  step="0.01">
              </p>
            </div>
  
            <div class="col-sm-2">
              <label class="control-label">COFINS - NFe Superior</label>
              <p><input class="form-control" type="number" id="cofins_nf_alt" name="cofins_nf_alt" value="0.00" min="0.00"
                  step="0.01">
              </p>
            </div>
  
            <div class="col-sm-2">
              <label class="control-label">Retenção CSLL</label>
              <p><input class="form-control" type="number" id="ret_csll_alt" name="ret_csll_alt" value="0.00" min="0.00"
                  step="0.01">
              </p>
            </div>
  
            <div class="col-sm-2">
              <label class="control-label">Abat. Suframa - PIS</label>
              <p><input class="form-control" type="number" id="abat_suframa_pis_alt" name="abat_suframa_pis_alt" value="0.00" min="0.00"
                  step="0.01"></p>
            </div>
  
            <div class="col-sm-2">
              <label class="control-label">Abat. Suframa - COFINS</label>
              <p><input class="form-control" type="number" id="abat_suframa_cofins_alt" name="abat_suframa_cofins_alt" value="0.00" min="0.00"
                  step="0.01"></p>
            </div>
  
            <div class="col-sm-2">
              <label class="control-label">Simples Nacional</label>
              <p><select class="select-notsearch" tabindex="-1" id="simples_alt" name="simples_alt">
                  <option value="0">Não</option>
                  <option value="1">Sim</option>
                </select></p>
            </div>
  
            <div class="col-sm-2">
              <label class="control-label">Simples Nacional (%)</label>
              <p><input class="form-control" type="number" id="aliq_simples_alt" name="aliq_simples_alt" value="0.00" min="0.00"
                  step="0.01">
              </p>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="calc_icms_alt" id="calc_icms_alt">
                <label for="calc_icms_alt" class="custom-control-label">Calcular ICMS</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="calc_ipi_alt" id="calc_ipi_alt">
                <label for="calc_ipi_alt" class="custom-control-label">Calcular IPI</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="cred_icm_alt" id="cred_icm_alt">
                <label for="cred_icm_alt" class="custom-control-label">Creditar ICM</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="cred_ipi_alt" id="cred_ipi_alt">
                <label for="cred_ipi_alt" class="custom-control-label">Creditar IPI</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="cred_piscofins_alt"
                  id="cred_piscofins_alt">
                <label for="cred_piscofins_alt" class="custom-control-label">Creditar PIS e COFINS</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="financeiro_alt" id="financeiro_alt">
                <label for="financeiro_alt" class="custom-control-label">Gera Financeiro</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="emissao_alt" id="emissao_alt">
                <label for="emissao_alt" class="custom-control-label">Emissão</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="mov_est_alt" id="mov_est_alt">
                <label for="mov_est_alt" class="custom-control-label">Movimentar Estoque</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="dest_ipi_alt" id="dest_ipi_alt">
                <label for="dest_ipi_alt" class="custom-control-label">Destacar IPI</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="incide_ipi_alt" id="incide_ipi_alt">
                <label for="incide_ipi_alt" class="custom-control-label">Incide IPI na Base ICMS</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="incide_frete_alt"
                  id="incide_frete_alt">
                <label for="incide_frete_alt" class="custom-control-label">Incide Frete na B. ICMS</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="incide_despesas_alt"
                  id="incide_despesas_alt">
                <label for="incide_despesas_alt" class="custom-control-label">Outras Desp. na B. ICMS</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="incide_base_ipi_alt"
                  id="incide_base_ipi_alt">
                <label for="incide_base_ipi_alt" class="custom-control-label">Frete/Despesas/Seguro na B. IPI</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="calc_iss_alt" id="calc_iss_alt">
                <label for="calc_iss_alt" class="custom-control-label">Calcular ISS</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="at_custo_alt" id="at_custo_alt">
                <label for="at_custo_alt" class="custom-control-label">Atualizar Custo</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="at_custo_medio_alt"
                  id="at_custo_medio_alt">
                <label for="at_custo_medio_alt" class="custom-control-label">Atualizar C. Médio</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="at_custo_aq_alt"
                  id="at_custo_aq_alt">
                <label for="at_custo_aq_alt" class="custom-control-label">Atualizar C. Aquisição</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="at_preco_alt" id="at_preco_alt">
                <label for="at_preco_alt" class="custom-control-label">Atualizar P. de Venda</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="soma_alt" id="soma_alt">
                <label for="soma_alt" class="custom-control-label">Influencia em Relatórios</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="espelho_alt" name="espelho_alt">
                <label for="espelho_alt" class="custom-control-label">Imprime Espelho NFe</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="comissao_alt" name="comissao_alt">
                <label for="comissao_alt" class="custom-control-label">Comissão</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="calc_import_alt"
                  name="calc_import_alt">
                <label for="calc_import_alt" class="custom-control-label">Calc. Importação</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="soma_import_alt"
                  name="soma_import_alt">
                <label for="soma_import_alt" class="custom-control-label">Soma ICMS Importação no total</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="lanc_ipi_alt" name="lanc_ipi_alt">
                <label for="lanc_ipi_alt" class="custom-control-label">Lançar IPI na 1ª Parcela (*)</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="incide_icms_pci_alt"
                  name="incide_icms_pci_alt">
                <label for="incide_icms_pci_alt" class="custom-control-label">ICMS na B. PIS e COFINS Imp.</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="incide_despesas_pc_alt"
                  name="incide_despesas_pc_alt">
                <label for="incide_despesas_pc_alt" class="custom-control-label">Outras Desp. na B. PIS e COFINS</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="ded_icms_pc_alt"
                  name="ded_icms_pc_alt">
                <label for="ded_icms_pc_alt" class="custom-control-label">Deduzir ICMS na B. PIS e COFINS</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="calc_fecp_alt" name="calc_fecp_alt">
                <label for="calc_fecp_alt" class="custom-control-label">Calcular FECP</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="calc_difal_alt" name="calc_difal_alt">
                <label for="calc_difal_alt" class="custom-control-label">Calcular Partilha (Difal)</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="dup_st_alt" name="dup_st_alt">
                <label for="dup_st_alt" class="custom-control-label">Gerar Duplicata ST</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="desc_icms_alt" name="desc_icms_alt">
                <label for="desc_icms_alt" class="custom-control-label">Não incide desconto B. ICMS</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="desc_icms_des_alt"
                  name="desc_icms_des_alt">
                <label for="desc_icms_des_alt" class="custom-control-label">Subtrair Desoneração na Nota</label>
              </div>
            </div>
  
            <div class="col-sm-3">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="desc_icms_ipi_alt"
                  name="desc_icms_ipi_alt">
                <label for="desc_icms_ipi_view" class="custom-control-label">Deduz Desconto na B. IPI</label>
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

@endsection


@section('js')
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="{{url('/')}}/js/pages/tes.js"></script>
@endsection