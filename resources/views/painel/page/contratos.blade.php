@extends('painel.template.template')

@section('title','Contratos')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Contratos
          @foreach ($acessoPerfil as $acesso)
          @if (($acesso->role == 5)&&($acesso->ativo == 1))
          <button type="button" class="btn btn-primary fa fa-user-plus" data-toggle="modal" data-target="#CadastroModal"
            data-codigo="{{$uempresa}}">
            Cadastrar
          </button>
          @endif
          @endforeach
        </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index">Home</a></li>
          <li class="breadcrumb-item active">Configuração</li>
          <li class="breadcrumb-item active">Contratos</li>
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
          <th style="width: 10%">ID</th>
          <th style="width: 10%">Contrato</th>
          <th style="width: 40%">Cliente</th>
          <th style="width: 10%">Emissão</th>
          <th style="width: 5%">Status</th>
          <th class="statusDataTab">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($contratos as $contrato)
        <tr>
          <td class="idDataTabText">{{$contrato['contrato']['id_contrato']}}</td>
          <td>{{$contrato['contrato']['proposta']}}</td>
          <td>{{$contrato['contrato']['razao_social']}}</td>
          <td>{{date('d/m/Y', strtotime($contrato['contrato']['data_cad']))}}</td>
          <td>
            <span @if ($contrato['contrato']['status']> 0) class="badge badge-success" @else class="badge badge-danger"
              @endif>{{$contrato['contrato']['status'] ? "Ativo" : "Inativo"}}</span>
          </td>
          <td>
            <button type="button" class="btn btn-primary btn-sm fa fa-eye" data-toggle="modal"
              data-target="#VisualizarPerfilModal"></button>

            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 2)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarPerfilModal"></button>

            <button type="button" class="btn btn-warning btn-sm fa fa-print" data-toggle="modal"
              data-target="#modal-permissao"></button>
            @endif
            @endforeach
            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 3)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger">
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
          <h5 class="modal-title" id="CadastroModalLabel">Novo Contrato</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('ContratoController@store')}}"
          enctype="multipart/form-data">
          @csrf
          <div class="form-group row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-header d-flex p-0">
                  <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Cabeçalho</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Serviços</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Anexo</a></li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <!-- Cabecalho -->
                    <div class="tab-pane active" id="tab_1">
                      <div class="form-group row">

                        <div class="col-sm-3">
                          <label class="control-label">ID</label>
                          <input class="form-control" type="hidden" id="idCliente" name="idCliente" required>
                          <p><input class="form-control" type="text" id="idDisabled" disabled></p>
                        </div>

                        <div class="col-sm-9">
                          <label class="control-label">Razão Social</label>
                          <input class="form-control" type="hidden" id="empresa">
                          <p><input class="form-control" type="text" id="razao" name="razaocad" maxlength="200"
                              required></p>
                        </div>

                        <div class="col-sm-5">
                          <label class="control-label">Pessoa</label>
                          <p><select class="select-notsearch" tabindex="-1" id="pessoa" name="pessoacad">
                              <option value="0">Física</option>
                              <option value="1">Jurídica/Não Jurídica</option>
                            </select></p>
                        </div>

                        <div class="col-sm-4">
                          <label class="control-label">Valor</label>
                          <p><input class="form-control" type="number" name="valorcad" value="0.00" min="0.00"
                              step="0.01" required>
                          </p>
                        </div>

                        <div class="col-sm-3">
                          <label class="control-label">Desconto</label>
                          <p><input class="form-control" type="number" name="descontocad" value="0.00" min="0.00"
                              step="0.01" required></p>
                        </div>

                        <div class="col-sm-5">
                          <label class="control-label">CPF / CNPJ</label>
                          <p><input class="form-control" type="text" id="cnpjcpf" name="cgccad" required></p>
                        </div>

                        <div class="col-sm-3">
                          <label class="control-label">Ativo</label>
                          <p><select class="select-notsearch" tabindex="-1" name="statuscad">
                              <option value="1">Sim</option>
                              <option value="0">Não</option>
                            </select></p>
                        </div>

                        <div class="col-sm-4">
                          <label class="control-label">Status Receita</label>
                          <p><input class="form-control" type="text" id="receita" disabled></p>
                        </div>

                      </div>

                    </div>

                    <!-- Acessos -->
                    <div class="tab-pane" id="tab_2">

                      <div class="form-group row">

                        <div class="col-sm-3">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="basico_cad" id="basico_cad">
                            <label for="basico_cad" class="custom-control-label">Básico</label>
                          </div>
                        </div>

                        <div class="col-sm-3">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="nfs_cad" id="nfs_cad">
                            <label for="nfs_cad" class="custom-control-label">NFS-e</label>
                          </div>
                        </div>

                        <div class="col-sm-3">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="nfe_cad" id="nfe_cad">
                            <label for="nfe_cad" class="custom-control-label">NF-e</label>
                          </div>
                        </div>

                        <div class="col-sm-3">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="nfce_cad" id="nfce_cad">
                            <label for="nfce_cad" class="custom-control-label">NFC-e</label>
                          </div>
                        </div>

                        <div class="col-sm-3">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="cfesat_cad" id="cfesat_cad">
                            <label for="cfesat_cad" class="custom-control-label">CFe SAT</label>
                          </div>
                        </div>

                        <div class="col-sm-3">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="mfe_cad" id="mfe_cad">
                            <label for="mfe_cad" class="custom-control-label">MF-e</label>
                          </div>
                        </div>

                        <div class="col-sm-3">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="mde_cad" id="mde_cad">
                            <label for="mde_cad" class="custom-control-label">MD-e</label>
                          </div>
                        </div>

                        <div class="col-sm-3">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="mdfe_cad" id="mdfe_cad">
                            <label for="mdfe_cad" class="custom-control-label">MDF-e</label>
                          </div>
                        </div>

                        <div class="col-sm-3">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="cte_cad" id="cte_cad">
                            <label for="cte_cad" class="custom-control-label">CT-e</label>
                          </div>
                        </div>

                        <div class="col-sm-3">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="contrato_cad" id="contratos_cad">
                            <label for="contratos_cad" class="custom-control-label">Contrato</label>
                          </div>
                        </div>

                        <div class="col-sm-3">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="servico_cad" id="servico_cad">
                            <label for="servico_cad" class="custom-control-label">Serviço</label>
                          </div>
                        </div>

                      </div>

                    </div>

                    <!-- Anexo -->
                    <div class="tab-pane" id="tab_3">
                      
                      <div class="form-group row">

                        <div class="col-sm-12">
                          <label class="control-label">Anexar Arquivo</label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFilecad" name="arquivocad">
                            <label class="custom-file-label" for="customFilecad"></label>
                          </div>
                        </div>

                      </div>

                    </div>

                  </div>

                </div>

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


@endsection


@section('js')
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="{{url('/')}}/js/plugins/mask/jquery.mask.min.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/bs-custom-file-input/bs-custom-file-input.js"></script>
<script src="{{url('/')}}/js/pages/contratos.js"></script>
@endsection