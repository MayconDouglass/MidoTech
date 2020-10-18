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
            data-target="#VisualizarTabPrecoModal"></button>

          @foreach ($acessoPerfil as $acesso)
          @if (($acesso->role == 2)&&($acesso->ativo == 1))
          <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
            data-target="#AlterarTabPrecoModal" ></button>
          @endif
          @endforeach
          @foreach ($acessoPerfil as $acesso)
          @if (($acesso->role == 3)&&($acesso->ativo == 1))
          <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
            data-target="#modal-danger"></button>
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
                          <select class="select-notsearch" tabindex="-1" name="tipocad">
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
                          </select>
                      </div>

                      <div class="col-sm-8">
                          <label class="control-label">Origem</label>
                          <select class="select-notsearch" tabindex="-1" name="origemcad">
                            <option value="0">Nacional</option>
                            <option value="1">Estrangeira Importação Direta</option>
                            <option value="2">Estrangeira Adquirida no Mercado Interno</option>
                            <option value="3">Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40%</option>
                            <option value="4">Nacional, cuja produção tenha sido feita em conformidade com o Decreto-Lei nº 288/67</option>
                            <option value="5">Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%</option>
                            <option value="6">Estrangeira - Importação direta, sem similar nacional, constante em lista de Resolução CAMEX</option>
                            <option value="7">Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista de Resolução CAMEX</option>
                            <option value="8">Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%</option>
                          </select>
                      </div>

                      <div class="col-sm-8">
                          <label class="control-label">CST</label>
                          <select class="select-notsearch" tabindex="-1" name="cstcad">
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
                          </select>
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



@endsection


@section('js')
<script src="{{url('/')}}/js/pages/unidades.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endsection