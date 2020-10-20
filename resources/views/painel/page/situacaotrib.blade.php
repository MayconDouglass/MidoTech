@extends('painel.template.template')

@section('title','Situação tributária')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Situação tributária
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
          <li class="breadcrumb-item active">Situação tributária</li>
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
          <th class="statusDataTab">Código</th>
          <th style="width: 50%">Descrição</th>
          <th class="statusDataTab">Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($sittributarias as $sittributaria)
        <tr>
          <td class="idDataTabText">{{$sittributaria->id_tributacao}}</td>
          <td>{{$sittributaria->codigo}}</td>
          <td>{{$sittributaria->descricao}}</td>
          <td>
            <span @if ($sittributaria->ativo > 0) class="badge badge-success" @else class="badge badge-danger"
              @endif>{{$sittributaria->ativo ? "Ativo" : "Inativo"}}</span>
          </td>
          <td>
            <button type="button" class="btn btn-primary btn-sm fa fa-eye" data-toggle="modal"
            data-target="#VisualizarModal" data-codigo="{{$sittributaria->id_tributacao}}" ></button>

          @foreach ($acessoPerfil as $acesso)
          @if (($acesso->role == 2)&&($acesso->ativo == 1))
          <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
          data-target="#AlterarModal" data-codigo="{{$sittributaria->id_tributacao}}" ></button>
          @endif
          @endforeach
          @foreach ($acessoPerfil as $acesso)
          @if (($acesso->role == 3)&&($acesso->ativo == 1))
          <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
            data-target="#modal-danger" data-codigo="{{$sittributaria->id_tributacao}}" ></button>
          @endif
          @endforeach
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>


<!-- Modal Visualizar-->
<div class="modal fade" id="VisualizarModal" tabindex="-1" role="dialog" aria-labelledby="VisualizarModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="view_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="VisualizarModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal">
          @csrf
          <div class="form-group row">
                <div class="col-sm-1">
                  <input class="form-control" type="hidden" name="idST" id="idST" required />
                  <label class="control-label">Código</label>
                  <p><input class="form-control" type="text" name="codigoview" disabled id="viewcodigo" minlength="3" maxlength="3" required /></p>
              </div>

              <div class="col-sm-6">
                  <label class="control-label">Descricao</label>
                  <p><input class="form-control" type="text" name="descricaoview" disabled id="viewdescricao" maxlength="40" required /></p>
              </div>

              <div class="col-sm-5">
                  <label class="control-label">Tipo</label>
                  <p><select class="select-notsearch" tabindex="-1" name="tipoview" disabled id="viewtipo">
                    <option value="0">Isento</option>
                    <option value="1">Substituição Tributária</option>
                    <option value="2">Tributado ICMS</option>
                    <option value="3">Tributado ISS</option>
                    <option value="4">Imposto Fixo</option>
                    <option value="5">Substituição Tributária( Com Retenção )</option>
                    <option value="6">Substituição Tributária( Sem Retenção )</option>
                    <option value="7">ICMS Dispensado</option>
                    <option value="8">Diferimento Total</option>
                    <option value="9">Substituição Tributária Reduzida( Com Retenção )</option>
                    <option value="10">Substituição Tributária Reduzida( Sem Retenção )</option>
                    <option value="11">ST ( Informações Complementares )</option>
                    <option value="12">ST Reduzida ( Informações Complementares )</option>
                    <option value="13">Outros - Substituição Tributária</option>
                    <option value="14">Isento - com Cobrança de ICMS por Substuição Tributária</option>
                  </select></p>
              </div>

              <div class="col-sm-6">
                  <label class="control-label">Origem</label>
                  <p><select class="select-notsearch" tabindex="-1" name="origemview" disabled id="vieworigem">
                    <option value="0">Nacional</option>
                    <option value="1">Estrangeira Importação Direta</option>
                    <option value="2">Estrangeira Adquirida no Mercado Interno</option>
                    <option value="3">Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40%</option>
                    <option value="4">Nacional, cuja produção tenha sido feita em conformidade com o Decreto-Lei nº 288/67</option>
                    <option value="5">Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%</option>
                    <option value="6">Estrangeira - Importação direta, sem similar nacional, constante em lista de Resolução CAMEX</option>
                    <option value="7">Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista de Resolução CAMEX</option>
                    <option value="8">Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%</option>
                  </select></p>
              </div>

              <div class="col-sm-6">
                  <label class="control-label">CST</label>
                  <p><select class="select-notsearch" tabindex="-1" name="cstview" disabled id="viewcst">
                    <option value="00">00 - Tributada integralmente</option>
                    <option value="10">10 - Tributada e com cobrança do ICMS por subst. tributária</option>
                    <option value="20">20 - Com redução de base de cálculo</option>
                    <option value="30">30 - Isenta ou não tributada e com cobrança do ICMS por subst. tributária</option>
                    <option value="40">40 - Isenta</option>
                    <option value="41">41 - Não tributada</option>
                    <option value="50">50 - Suspensão</option>
                    <option value="51">51 - Diferimento</option>
                    <option value="60">60 - ICMS cobrado anteriormente por subst. tributária</option>
                    <option value="70">70 - Com redução de base de cálculo e cobrança do ICMS por subst. tributária</option>
                    <option value="90">90 - Outras</option>
                  </select></p>
              </div>

              <div class="col-sm-3">
                <label class="control-label">Modalidade Base do ICMS</label>
                <p><select class="select-notsearch" tabindex="-1" name="mod_icmsview" disabled id="viewmod_icms">
                  <option value="0">0 - Margem Valor Agregado (%)</option>
                  <option value="1">1 - Pauta (Valor)</option>
                  <option value="2">2 - Preço Tabelado Máximo</option>
                  <option value="3">3 - Valor da Operação</option>
                </select></p>
            </div>

              <div class="col-sm-4">
                <label class="control-label">Modalidade Base do ICMS ST</label>
                <p><select class="select-notsearch" tabindex="-1" name="mod_icms_stview" disabled id="viewmod_icms_st">
                  <option value="0">0 - Preço Tabelado ou Máximo Sugerido</option>
                  <option value="1">1 - Lista Negativa (Valor)</option>
                  <option value="2">2 - Lista Positiva (Valor)</option>
                  <option value="3">3 - Lista Neutra (Valor)</option>
                  <option value="4">4 - Margem Valor Agregado (%)</option>
                  <option value="5">5 - Pauta (Valor)</option>
                  <option value="6">6 - Valor da Operação</option>
                </select></p>
            </div>

              <div class="col-sm-5">
                <label class="control-label">Motivo da Desoneração</label>
                <p><select class="select-notsearch" tabindex="-1" name="mot_desoneracaoview" disabled id="viewmot_desoneracao">
                  <option value="0">0 - Nenhum</option>
                  <option value="1">1 - Táxi</option>
                  <option value="3">3 - Produtor Agropecuário</option>
                  <option value="4">4 - Frotista/Locadora</option>
                  <option value="5">5 - Diplomático/Consular</option>
                  <option value="6">6 - Utilitários e Motocicletas da Amazônia Ocidental e Áreas de Livre Comércio(Resolução 714/88 e 790/94 | CONTRAN e suas alterações)</option>
                  <option value="7">7 - SUFRAMA</option>
                  <option value="8">8 - Venda a Órgão Público</option>
                  <option value="9">9 - Outros (NT 2011/004)</option>
                  <option value="10">10 - Deficiente Condutor (Convênio ICMS 38/12)</option>
                  <option value="11">11 - Deficiente Não Condutor (Convênio ICMS 38/12)</option>
                  <option value="12">12 - Órgão de Fomento e Desenvolvimento Agropecuário</option>
                  <option value="16">16 - Olimpíadas RIO 2016(NT 2015/002)</option>
                  <option value="90">90 - Solicitado pelo Fisco</option>
                </select></p>
            </div>
            
          <div class="col-sm-4">
            <label class="control-label">Tipo de Custo Cálculo ST - RIOLOG</label>
            <p><select class="select-notsearch" tabindex="-1" name="riologview" disabled id="viewriolog">
              <option value="0">Custo Unitário</option>
              <option value="1">Custo de Aquisição</option>
              <option value="2">Valor de Pauta do Produto</option>
              <option value="3">Preço Unitário</option>
            </select></p>
          </div>

            <div class="col-sm-6">
              <label class="control-label">CSOSN</label>
              <p><select class="select-notsearch" tabindex="-1" name="csosnview" disabled id="viewcsosn">
                <option value="101">101 - Tributada pelo Simples Nacional com permissão de crédito</option>
                <option value="102">101 - Tributada pelo Simples Nacional sem permissão de crédito</option>
                <option value="103">103 - Isenção do ICMS no Simples Nacional para faixa de receita bruta</option>
                <option value="201">201 - Tributada pelo Simples Nacional com permissão de crédito e com cobrança do ICMS ST</option>
                <option value="202">202 - Tributada pelo Simples Nacional sem permissão de crédito e com cobrança do ICMS ST</option>
                <option value="203">203 - Isenção do ICMS no Simples Nacional para faixa de receita bruta e com cobrança do ICMS ST</option>
                <option value="300">300 - Imune</option>
                <option value="400">400 - Não tributada pelo Simples Nacional</option>
                <option value="500">500 - ICMS cobrado anteriormente por subst. tributária (subsituído) ou por antecipação</option>
                <option value="900">900 - Tributado pelo ICMS - Outros</option>
              </select></p>
          </div>    

          <div class="col-sm-2">
            <label class="control-label">Status</label>
            <p><select class="select-notsearch" tabindex="-1" name="statusview" disabled id="viewstatus">
              <option value="1">Sim</option>
              <option value="0">Não</option>
            </select></p>
          </div>

            <div class="col-sm-2">
              <label class="control-label">% MVA</label>
              <p><input class="form-control" type="number" name="mvaview" disabled id="viewmva" min="0.00" value="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">% MVA - Simples</label>
              <p><input class="form-control" type="number" name="mva_simplesview" disabled id="viewmva_simples" value="0.00" min="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">% ICMS</label>
              <p><input class="form-control" type="number" name="aliq_icmsview" disabled id="viewaliq_icms" value="0.00" min="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">% ICMS ST</label>
              <p><input class="form-control" type="number" name="aliq_icms_stview" disabled id="viewaliq_icms_st" value="0.00" min="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">% ICMS UF de Destino</label>
              <p><input class="form-control" type="number" name="aliq_icms_ufview" disabled id="viewaliq_icms_uf" value="0.00" min="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">% Redução BC ICMS</label>
              <p><input class="form-control" type="number" name="aliq_red_icmsview" disabled id="viewaliq_red_icms" value="0.00" min="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">% Redução BC ICMS ST</label>
              <p><input class="form-control" type="number" name="aliq_red_icms_stview" disabled id="viewaliq_red_icms_st" value="0.00" min="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">% Simples</label>
              <p><input class="form-control" type="number" name="aliq_simplesview" disabled id="viewaliq_simples" value="0.00" min="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">% Redução Val. Unitário</label>
              <p><input class="form-control" type="number" name="aliq_red_unitarioview" disabled id="viewaliq_red_unitario" value="0.00" min="0.00" step="0.01" required /></p>
            </div>
            
            <div class="col-sm-2">
              <label class="control-label">% FECP</label>
              <p><input class="form-control" type="number" name="aliq_fecpview" disabled id="viewaliq_fecp" value="0.00" min="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Diferimento</label>
              <p><input class="form-control" type="number" name="aliq_diferimentoview" disabled id="viewaliq_diferimento" value="0.00" min="0.00" step="0.01" required /></p>
            </div>
            
            <div class="col-sm-2">
              <label class="control-label">Código de Benef. Fiscal</label>
              <p><input class="form-control" type="text" name="beneficioview" disabled id="viewbeneficio" maxlength="8" /></p>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="viewreset" data-dismiss="modal"><i class="fa fa-times">
                Cancelar</i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Alteracao-->
<div class="modal fade" id="AlterarModal" tabindex="-1" role="dialog" aria-labelledby="AlterarModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="alt_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="AlterarModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('SituacaoTribController@update')}}"
          enctype="multipart/form-data">
          @csrf
          <div class="form-group row">
                <div class="col-sm-1">
                  <input class="form-control" type="hidden" name="idST" id="idST" required />
                  <label class="control-label">Código</label>
                  <p><input class="form-control" type="text" name="codigoalt" disabled id="codigo" minlength="3" maxlength="3" required /></p>
              </div>

              <div class="col-sm-6">
                  <label class="control-label">Descricao</label>
                  <p><input class="form-control" type="text" name="descricaoalt" id="descricao" maxlength="40" required /></p>
              </div>

              <div class="col-sm-5">
                  <label class="control-label">Tipo</label>
                  <p><select class="select-notsearch" tabindex="-1" name="tipoalt" id="tipo">
                    <option value="0">Isento</option>
                    <option value="1">Substituição Tributária</option>
                    <option value="2">Tributado ICMS</option>
                    <option value="3">Tributado ISS</option>
                    <option value="4">Imposto Fixo</option>
                    <option value="5">Substituição Tributária( Com Retenção )</option>
                    <option value="6">Substituição Tributária( Sem Retenção )</option>
                    <option value="7">ICMS Dispensado</option>
                    <option value="8">Diferimento Total</option>
                    <option value="9">Substituição Tributária Reduzida( Com Retenção )</option>
                    <option value="10">Substituição Tributária Reduzida( Sem Retenção )</option>
                    <option value="11">ST ( Informações Complementares )</option>
                    <option value="12">ST Reduzida ( Informações Complementares )</option>
                    <option value="13">Outros - Substituição Tributária</option>
                    <option value="14">Isento - com Cobrança de ICMS por Substuição Tributária</option>
                  </select></p>
              </div>

              <div class="col-sm-6">
                  <label class="control-label">Origem</label>
                  <p><select class="select-notsearch" tabindex="-1" name="origemalt" id="origem">
                    <option value="0">Nacional</option>
                    <option value="1">Estrangeira Importação Direta</option>
                    <option value="2">Estrangeira Adquirida no Mercado Interno</option>
                    <option value="3">Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40%</option>
                    <option value="4">Nacional, cuja produção tenha sido feita em conformidade com o Decreto-Lei nº 288/67</option>
                    <option value="5">Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%</option>
                    <option value="6">Estrangeira - Importação direta, sem similar nacional, constante em lista de Resolução CAMEX</option>
                    <option value="7">Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista de Resolução CAMEX</option>
                    <option value="8">Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%</option>
                  </select></p>
              </div>

              <div class="col-sm-6">
                  <label class="control-label">CST</label>
                  <p><select class="select-notsearch" tabindex="-1" name="cstalt" id="cst">
                    <option value="00">00 - Tributada integralmente</option>
                    <option value="10">10 - Tributada e com cobrança do ICMS por subst. tributária</option>
                    <option value="20">20 - Com redução de base de cálculo</option>
                    <option value="30">30 - Isenta ou não tributada e com cobrança do ICMS por subst. tributária</option>
                    <option value="40">40 - Isenta</option>
                    <option value="41">41 - Não tributada</option>
                    <option value="50">50 - Suspensão</option>
                    <option value="51">51 - Diferimento</option>
                    <option value="60">60 - ICMS cobrado anteriormente por subst. tributária</option>
                    <option value="70">70 - Com redução de base de cálculo e cobrança do ICMS por subst. tributária</option>
                    <option value="90">90 - Outras</option>
                  </select></p>
              </div>

              <div class="col-sm-3">
                <label class="control-label">Modalidade Base do ICMS</label>
                <p><select class="select-notsearch" tabindex="-1" name="mod_icmsalt" id="mod_icms">
                  <option value="0">0 - Margem Valor Agregado (%)</option>
                  <option value="1">1 - Pauta (Valor)</option>
                  <option value="2">2 - Preço Tabelado Máximo</option>
                  <option value="3">3 - Valor da Operação</option>
                </select></p>
            </div>

              <div class="col-sm-4">
                <label class="control-label">Modalidade Base do ICMS ST</label>
                <p><select class="select-notsearch" tabindex="-1" name="mod_icms_stalt" id="mod_icms_st">
                  <option value="0">0 - Preço Tabelado ou Máximo Sugerido</option>
                  <option value="1">1 - Lista Negativa (Valor)</option>
                  <option value="2">2 - Lista Positiva (Valor)</option>
                  <option value="3">3 - Lista Neutra (Valor)</option>
                  <option value="4">4 - Margem Valor Agregado (%)</option>
                  <option value="5">5 - Pauta (Valor)</option>
                  <option value="6">6 - Valor da Operação</option>
                </select></p>
            </div>

              <div class="col-sm-5">
                <label class="control-label">Motivo da Desoneração</label>
                <p><select class="select-notsearch" tabindex="-1" name="mot_desoneracaoalt" id="mot_desoneracao">
                  <option value="0">0 - Nenhum</option>
                  <option value="1">1 - Táxi</option>
                  <option value="3">3 - Produtor Agropecuário</option>
                  <option value="4">4 - Frotista/Locadora</option>
                  <option value="5">5 - Diplomático/Consular</option>
                  <option value="6">6 - Utilitários e Motocicletas da Amazônia Ocidental e Áreas de Livre Comércio(Resolução 714/88 e 790/94 | CONTRAN e suas alterações)</option>
                  <option value="7">7 - SUFRAMA</option>
                  <option value="8">8 - Venda a Órgão Público</option>
                  <option value="9">9 - Outros (NT 2011/004)</option>
                  <option value="10">10 - Deficiente Condutor (Convênio ICMS 38/12)</option>
                  <option value="11">11 - Deficiente Não Condutor (Convênio ICMS 38/12)</option>
                  <option value="12">12 - Órgão de Fomento e Desenvolvimento Agropecuário</option>
                  <option value="16">16 - Olimpíadas RIO 2016(NT 2015/002)</option>
                  <option value="90">90 - Solicitado pelo Fisco</option>
                </select></p>
            </div>
            
          <div class="col-sm-4">
            <label class="control-label">Tipo de Custo Cálculo ST - RIOLOG</label>
            <p><select class="select-notsearch" tabindex="-1" name="riologalt" id="riolog">
              <option value="0">Custo Unitário</option>
              <option value="1">Custo de Aquisição</option>
              <option value="2">Valor de Pauta do Produto</option>
              <option value="3">Preço Unitário</option>
            </select></p>
          </div>

            <div class="col-sm-6">
              <label class="control-label">CSOSN</label>
              <p><select class="select-notsearch" tabindex="-1" name="csosnalt" id="csosn">
                <option value="101">101 - Tributada pelo Simples Nacional com permissão de crédito</option>
                <option value="102">101 - Tributada pelo Simples Nacional sem permissão de crédito</option>
                <option value="103">103 - Isenção do ICMS no Simples Nacional para faixa de receita bruta</option>
                <option value="201">201 - Tributada pelo Simples Nacional com permissão de crédito e com cobrança do ICMS ST</option>
                <option value="202">202 - Tributada pelo Simples Nacional sem permissão de crédito e com cobrança do ICMS ST</option>
                <option value="203">203 - Isenção do ICMS no Simples Nacional para faixa de receita bruta e com cobrança do ICMS ST</option>
                <option value="300">300 - Imune</option>
                <option value="400">400 - Não tributada pelo Simples Nacional</option>
                <option value="500">500 - ICMS cobrado anteriormente por subst. tributária (subsituído) ou por antecipação</option>
                <option value="900">900 - Tributado pelo ICMS - Outros</option>
              </select></p>
          </div>    

          <div class="col-sm-2">
            <label class="control-label">Status</label>
            <p><select class="select-notsearch" tabindex="-1" name="statusalt" id="status">
              <option value="1">Sim</option>
              <option value="0">Não</option>
            </select></p>
          </div>

            <div class="col-sm-2">
              <label class="control-label">% MVA</label>
              <p><input class="form-control" type="number" name="mvaalt" id="mva" min="0.00" value="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">% MVA - Simples</label>
              <p><input class="form-control" type="number" name="mva_simplesalt" id="mva_simples" value="0.00" min="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">% ICMS</label>
              <p><input class="form-control" type="number" name="aliq_icmsalt" id="aliq_icms" value="0.00" min="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">% ICMS ST</label>
              <p><input class="form-control" type="number" name="aliq_icms_stalt" id="aliq_icms_st" value="0.00" min="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">% ICMS UF de Destino</label>
              <p><input class="form-control" type="number" name="aliq_icms_ufalt" id="aliq_icms_uf" value="0.00" min="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">% Redução BC ICMS</label>
              <p><input class="form-control" type="number" name="aliq_red_icmsalt" id="aliq_red_icms" value="0.00" min="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">% Redução BC ICMS ST</label>
              <p><input class="form-control" type="number" name="aliq_red_icms_stalt" id="aliq_red_icms_st" value="0.00" min="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">% Simples</label>
              <p><input class="form-control" type="number" name="aliq_simplesalt" id="aliq_simples" value="0.00" min="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">% Redução Val. Unitário</label>
              <p><input class="form-control" type="number" name="aliq_red_unitarioalt" id="aliq_red_unitario" value="0.00" min="0.00" step="0.01" required /></p>
            </div>
            
            <div class="col-sm-2">
              <label class="control-label">% FECP</label>
              <p><input class="form-control" type="number" name="aliq_fecpalt" id="aliq_fecp" value="0.00" min="0.00" step="0.01" required /></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Diferimento</label>
              <p><input class="form-control" type="number" name="aliq_diferimentoalt" id="aliq_diferimento" value="0.00" min="0.00" step="0.01" required /></p>
            </div>
            
            <div class="col-sm-2">
              <label class="control-label">Código de Benef. Fiscal</label>
              <p><input class="form-control" type="text" name="beneficioalt" id="beneficio" maxlength="8" /></p>
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

<!-- Modal Cadastro-->
<div class="modal fade" id="CadastroModal" tabindex="-1" role="dialog" aria-labelledby="CadastroModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
          <div class="add_modalHeader">
              <div class="modal-header">
                  <h5 class="modal-title" id="CadastroModalLabel">Situação tributária</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          </div>
          <div class="modal-body">
              <!-- Form de cadastro -->
              <form class="form-horizontal" method="POST" action="{{action('SituacaoTribController@store')}}">
                  @csrf
                  <div class="form-group row">

                      <div class="col-sm-1">
                          <label class="control-label">Código</label>
                          <p><input class="form-control" type="text" name="codigocad" minlength="3" maxlength="3" required /></p>
                      </div>

                      <div class="col-sm-6">
                          <label class="control-label">Descricao</label>
                          <p><input class="form-control" type="text" name="descricaocad" maxlength="40" required /></p>
                      </div>

                      <div class="col-sm-5">
                          <label class="control-label">Tipo</label>
                          <p><select class="select-notsearch" tabindex="-1" name="tipocad">
                            <option value="0">Isento</option>
                            <option value="1">Substituição Tributária</option>
                            <option value="2">Tributado ICMS</option>
                            <option value="3">Tributado ISS</option>
                            <option value="4">Imposto Fixo</option>
                            <option value="5">Substituição Tributária( Com Retenção )</option>
                            <option value="6">Substituição Tributária( Sem Retenção )</option>
                            <option value="7">ICMS Dispensado</option>
                            <option value="8">Diferimento Total</option>
                            <option value="9">Substituição Tributária Reduzida( Com Retenção )</option>
                            <option value="10">Substituição Tributária Reduzida( Sem Retenção )</option>
                            <option value="11">ST ( Informações Complementares )</option>
                            <option value="12">ST Reduzida ( Informações Complementares )</option>
                            <option value="13">Outros - Substituição Tributária</option>
                            <option value="14">Isento - com Cobrança de ICMS por Substuição Tributária</option>
                          </select></p>
                      </div>

                      <div class="col-sm-6">
                          <label class="control-label">Origem</label>
                          <p><select class="select-notsearch" tabindex="-1" name="origemcad">
                            <option value="0">Nacional</option>
                            <option value="1">Estrangeira Importação Direta</option>
                            <option value="2">Estrangeira Adquirida no Mercado Interno</option>
                            <option value="3">Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40%</option>
                            <option value="4">Nacional, cuja produção tenha sido feita em conformidade com o Decreto-Lei nº 288/67</option>
                            <option value="5">Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%</option>
                            <option value="6">Estrangeira - Importação direta, sem similar nacional, constante em lista de Resolução CAMEX</option>
                            <option value="7">Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista de Resolução CAMEX</option>
                            <option value="8">Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%</option>
                          </select></p>
                      </div>

                      <div class="col-sm-6">
                          <label class="control-label">CST</label>
                          <p><select class="select-notsearch" tabindex="-1" name="cstcad">
                            <option value="00">00 - Tributada integralmente</option>
                            <option value="10">10 - Tributada e com cobrança do ICMS por subst. tributária</option>
                            <option value="20">20 - Com redução de base de cálculo</option>
                            <option value="30">30 - Isenta ou não tributada e com cobrança do ICMS por subst. tributária</option>
                            <option value="40">40 - Isenta</option>
                            <option value="41">41 - Não tributada</option>
                            <option value="50">50 - Suspensão</option>
                            <option value="51">51 - Diferimento</option>
                            <option value="60">60 - ICMS cobrado anteriormente por subst. tributária</option>
                            <option value="70">70 - Com redução de base de cálculo e cobrança do ICMS por subst. tributária</option>
                            <option value="90">90 - Outras</option>
                          </select></p>
                      </div>

                      <div class="col-sm-3">
                        <label class="control-label">Modalidade Base do ICMS</label>
                        <p><select class="select-notsearch" tabindex="-1" name="mod_icmscad">
                          <option value="0">0 - Margem Valor Agregado (%)</option>
                          <option value="1">1 - Pauta (Valor)</option>
                          <option value="2">2 - Preço Tabelado Máximo</option>
                          <option value="3">3 - Valor da Operação</option>
                        </select></p>
                    </div>

                      <div class="col-sm-4">
                        <label class="control-label">Modalidade Base do ICMS ST</label>
                        <p><select class="select-notsearch" tabindex="-1" name="mod_icms_stcad">
                          <option value="0">0 - Preço Tabelado ou Máximo Sugerido</option>
                          <option value="1">1 - Lista Negativa (Valor)</option>
                          <option value="2">2 - Lista Positiva (Valor)</option>
                          <option value="3">3 - Lista Neutra (Valor)</option>
                          <option value="4">4 - Margem Valor Agregado (%)</option>
                          <option value="5">5 - Pauta (Valor)</option>
                          <option value="6">6 - Valor da Operação</option>
                        </select></p>
                    </div>

                      <div class="col-sm-5">
                        <label class="control-label">Motivo da Desoneração</label>
                        <p><select class="select-notsearch" tabindex="-1" name="mot_desoneracaocad">
                          <option value="0">0 - Nenhum</option>
                          <option value="1">1 - Táxi</option>
                          <option value="3">3 - Produtor Agropecuário</option>
                          <option value="4">4 - Frotista/Locadora</option>
                          <option value="5">5 - Diplomático/Consular</option>
                          <option value="6">6 - Utilitários e Motocicletas da Amazônia Ocidental e Áreas de Livre Comércio(Resolução 714/88 e 790/94 | CONTRAN e suas alterações)</option>
                          <option value="7">7 - SUFRAMA</option>
                          <option value="8">8 - Venda a Órgão Público</option>
                          <option value="9">9 - Outros (NT 2011/004)</option>
                          <option value="10">10 - Deficiente Condutor (Convênio ICMS 38/12)</option>
                          <option value="11">11 - Deficiente Não Condutor (Convênio ICMS 38/12)</option>
                          <option value="12">12 - Órgão de Fomento e Desenvolvimento Agropecuário</option>
                          <option value="16">16 - Olimpíadas RIO 2016(NT 2015/002)</option>
                          <option value="90">90 - Solicitado pelo Fisco</option>
                        </select></p>
                    </div>
                    
                  <div class="col-sm-4">
                    <label class="control-label">Tipo de Custo Cálculo ST - RIOLOG</label>
                    <p><select class="select-notsearch" tabindex="-1" name="riologcad">
                      <option value="0">Custo Unitário</option>
                      <option value="1">Custo de Aquisição</option>
                      <option value="2">Valor de Pauta do Produto</option>
                      <option value="3">Preço Unitário</option>
                    </select></p>
                  </div>

                    <div class="col-sm-6">
                      <label class="control-label">CSOSN</label>
                      <p><select class="select-notsearch" tabindex="-1" name="csosncad">
                        <option value="101">101 - Tributada pelo Simples Nacional com permissão de crédito</option>
                        <option value="102">101 - Tributada pelo Simples Nacional sem permissão de crédito</option>
                        <option value="103">103 - Isenção do ICMS no Simples Nacional para faixa de receita bruta</option>
                        <option value="201">201 - Tributada pelo Simples Nacional com permissão de crédito e com cobrança do ICMS ST</option>
                        <option value="202">202 - Tributada pelo Simples Nacional sem permissão de crédito e com cobrança do ICMS ST</option>
                        <option value="203">203 - Isenção do ICMS no Simples Nacional para faixa de receita bruta e com cobrança do ICMS ST</option>
                        <option value="300">300 - Imune</option>
                        <option value="400">400 - Não tributada pelo Simples Nacional</option>
                        <option value="500">500 - ICMS cobrado anteriormente por subst. tributária (subsituído) ou por antecipação</option>
                        <option value="900">900 - Tributado pelo ICMS - Outros</option>
                      </select></p>
                  </div>    

                  <div class="col-sm-2">
                    <label class="control-label">Status</label>
                    <p><select class="select-notsearch" tabindex="-1" name="statuscad">
                      <option value="1">Sim</option>
                      <option value="0">Não</option>
                    </select></p>
                  </div>

                    <div class="col-sm-2">
                      <label class="control-label">% MVA</label>
                      <p><input class="form-control" type="number" name="mvacad" min="0.00" value="0.00" step="0.01" required /></p>
                    </div>

                    <div class="col-sm-2">
                      <label class="control-label">% MVA - Simples</label>
                      <p><input class="form-control" type="number" name="mva_simplescad" value="0.00" min="0.00" step="0.01" required /></p>
                    </div>

                    <div class="col-sm-2">
                      <label class="control-label">% ICMS</label>
                      <p><input class="form-control" type="number" name="aliq_icmscad" value="0.00" min="0.00" step="0.01" required /></p>
                    </div>

                    <div class="col-sm-2">
                      <label class="control-label">% ICMS ST</label>
                      <p><input class="form-control" type="number" name="aliq_icms_stcad" value="0.00" min="0.00" step="0.01" required /></p>
                    </div>

                    <div class="col-sm-2">
                      <label class="control-label">% ICMS UF de Destino</label>
                      <p><input class="form-control" type="number" name="aliq_icms_ufcad" value="0.00" min="0.00" step="0.01" required /></p>
                    </div>

                    <div class="col-sm-2">
                      <label class="control-label">% Redução BC ICMS</label>
                      <p><input class="form-control" type="number" name="aliq_red_icmscad" value="0.00" min="0.00" step="0.01" required /></p>
                    </div>

                    <div class="col-sm-2">
                      <label class="control-label">% Redução BC ICMS ST</label>
                      <p><input class="form-control" type="number" name="aliq_red_icms_stcad" value="0.00" min="0.00" step="0.01" required /></p>
                    </div>

                    <div class="col-sm-2">
                      <label class="control-label">% Simples</label>
                      <p><input class="form-control" type="number" name="aliq_simplescad" value="0.00" min="0.00" step="0.01" required /></p>
                    </div>

                    <div class="col-sm-2">
                      <label class="control-label">% Redução Val. Unitário</label>
                      <p><input class="form-control" type="number" name="aliq_red_unitariocad" value="0.00" min="0.00" step="0.01" required /></p>
                    </div>
                    
                    <div class="col-sm-2">
                      <label class="control-label">% FECP</label>
                      <p><input class="form-control" type="number" name="aliq_fecpcad" value="0.00" min="0.00" step="0.01" required /></p>
                    </div>

                    <div class="col-sm-2">
                      <label class="control-label">Diferimento</label>
                      <p><input class="form-control" type="number" name="aliq_diferimentocad" value="0.00" min="0.00" step="0.01" required /></p>
                    </div>
                    
                    <div class="col-sm-2">
                      <label class="control-label">Código de Benef. Fiscal</label>
                      <p><input class="form-control" type="text" name="beneficiocad" maxlength="8" /></p>
                    </div>

                  </div>

                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" id="reset" data-dismiss="modal"><i class="fa fa-times"> Cancelar</i></button>
                      <button type="submit" class="btn btn-primary" id="btnSalvar" name="btnSalvar"><i class="fa fa-floppy-o"> Salvar</i></button>
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
        <form class="form-horizontal" method="POST" action="{{action('SituacaoTribController@destroy')}}">
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
<script src="{{url('/')}}/js/pages/situacaotrib.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endsection