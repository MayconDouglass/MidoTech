@extends('painel.template.template')

@section('title','Vendedor')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Vendedor
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
          <li class="breadcrumb-item active">Unidades</li>
          <li class="breadcrumb-item active">Unidades</li>
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
          <th>Empresa</th>
          <th>Nome</th>
          <th class="statusDataTab">Status</th>
          <th class="actionDataTab">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($vendedores as $vendedor)
        <tr>
          <td class="idDataTabText">{{$vendedor->id_vendedor}}</td>
          <td>{{$vendedor->setempresa->Sigla}}</td>
          <td>{{$vendedor->nome}}</td>
          <td>
            <span @if ($vendedor->ativo > 0) class="badge badge-success" @else class="badge badge-danger"
              @endif>{{$vendedor->ativo ? "Ativo" : "Inativo"}}</span>
          </td>
          <td>
            <button type="button" class="btn btn-primary btn-sm fa fa-eye" data-toggle="modal"
              data-target="#VisualizarVenModal" data-codigo="{{$vendedor->id_vendedor}}"
              data-emp-cod="{{$vendedor->emp_cod}}" data-nome="{{$vendedor->nome}}"
              data-logradouro="{{$vendedor->logradouro}}" data-comp="{{$vendedor->complemento}}"
              data-numero="{{$vendedor->numero}}" data-bairro="{{$vendedor->bairro}}"
              data-cidade="{{$vendedor->cidade}}" data-estado="{{$vendedor->uf}}" data-cep="{{$vendedor->cep}}"
              data-pessoa="{{$vendedor->pessoa}}" data-cnpjcpf="{{$vendedor->cnpjcpf}}" data-tipo="{{$vendedor->tipo}}"
              data-supervisor="{{$vendedor->supervisor}}" data-gerente="{{$vendedor->gerente}}"
              data-email="{{$vendedor->email}}" data-comissao="{{$vendedor->comissao}}"
              data-pago-emissao="{{$vendedor->pago_emissao}}" data-pago-baixa="{{$vendedor->pago_baixa}}"
              data-desconto="{{$vendedor->desconto_max}}" data-pedido-min="{{$vendedor->pedido_min}}"
              data-setor="{{$vendedor->setor}}" data-status="{{$vendedor->ativo}}"
              data-telefone="{{$vendedor->telefone}}"> Visualizar</button>
            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 2)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarVenModal" data-codigo="{{$vendedor->id_vendedor}}"
              data-emp-cod="{{$vendedor->emp_cod}}" data-nome="{{$vendedor->nome}}"
              data-logradouro="{{$vendedor->logradouro}}" data-comp="{{$vendedor->complemento}}"
              data-numero="{{$vendedor->numero}}" data-bairro="{{$vendedor->bairro}}"
              data-cidade="{{$vendedor->cidade}}" data-estado="{{$vendedor->uf}}" data-cep="{{$vendedor->cep}}"
              data-pessoa="{{$vendedor->pessoa}}" data-cnpjcpf="{{$vendedor->cnpjcpf}}" data-tipo="{{$vendedor->tipo}}"
              data-supervisor="{{$vendedor->supervisor}}" data-gerente="{{$vendedor->gerente}}"
              data-email="{{$vendedor->email}}" data-comissao="{{$vendedor->comissao}}"
              data-pago-emissao="{{$vendedor->pago_emissao}}" data-pago-baixa="{{$vendedor->pago_baixa}}"
              data-desconto="{{$vendedor->desconto_max}}" data-pedido-min="{{$vendedor->pedido_min}}"
              data-setor="{{$vendedor->setor}}" data-status="{{$vendedor->ativo}}"
              data-telefone="{{$vendedor->telefone}}"> Alterar</button>

            <button type="button" class="btn btn-info btn-sm fa fa-key" data-toggle="modal"
              data-target="#modal-password" data-codigo="{{$vendedor->id_vendedor}}"></button>
            @endif
            @endforeach

            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 3)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger" data-codigo="{{$vendedor->id_vendedor}}"></button>
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
          <h5 class="modal-title" id="CadastroModalLabel">Novo Vendedor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('VendedorController@store')}}"
          enctype="multipart/form-data">
          @csrf
          <div class="form-group row">

            <div class="col-sm-5">
              <label class="control-label">Nome</label>
              <p><input class="form-control" type="text" name="nomecad" maxlength="100" required></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">CNPJ / CPF</label>
              <p><input class="form-control" type="text" name="cnpjcpfcad" id="cnpjcpf" maxlength="17" required></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Tipo Pessoa</label>
              <select class="select-notsearch" tabindex="-1" name="pessoacad" id="pessoa">
                <option value="0">Física</option>
                <option value="1">Júridica</option>
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Tipo de Vendedor</label>
              <select class="select-notsearch" tabindex="-1" name="tipocad" id="tipovendedorcad">
                <option value="0">Vendedor</option>
                <option value="1">Supervisor</option>
                <option value="2">Gerente</option>
              </select>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Supervisor</label>
              <select class="select-notsearch" tabindex="-1" name="supervisorcad" id="supervisorcad">
                <option value="0">Nenhum</option>
                @foreach ($supervisores as $supervisor)
                <option value={{$supervisor->id_vendedor}}>{{$supervisor->nome}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Gerente</label>
              <select class="select-notsearch" tabindex="-1" name="gerentecad" id="gerentecad">
                <option value="0">Nenhum</option>
                @foreach ($gerentes as $gerente)
                <option value={{$gerente->id_vendedor}}>{{$gerente->nome}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Email</label>
              <input class="form-control" type="email" name="emailcad" id="email" maxlength="200">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Ativo</label>
              <p><select class="select-notsearch" tabindex="-1" name="statuscad">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Empresa</label>
              <select class="select-notsearch" tabindex="-1" name="empresacad">
                @foreach ($empresas as $empresa)
                <option value={{$empresa->id_empresa}}>{{$empresa->id_empresa . ' - ' . $empresa->razao_social}}
                </option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Pedido Mínimo</label>
              <input class="form-control" type="number" name="pedmincad" id="pedmin" value="0.00" step="0.01" min="0">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Comissão</label>
              <input class="form-control" type="number" name="comissaocad" id="comissao" value="0.00" step="0.01" min="0">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Pago na emissao(%)</label>
              <input class="form-control" type="number" name="pagoemissaocad" id="pagoemissao" value="0.00" step="0.01" min="0">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Pago na baixa(%)</label>
              <p><input class="form-control" type="number" name="pagobaixacad" id="pagobaixa" value="0.00" step="0.01" min="0">
              </p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Desconto máximo(%)</label>
              <input class="form-control" type="number" name="descontocad" id="desconto" value="0.00" step="0.01" min="0">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Telefone</label>
              <input class="form-control" type="text" name="telefonecad" id="telefone">
            </div>

            <div class="col-sm-6">
              <label class="control-label">Logradouro</label>
              <input class="form-control" type="text" name="logradourocad" id="logradouro" maxlength="200">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Número</label>
              <p><input class="form-control" type="text" name="numerocad" id="numero" maxlength="20"></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Complemento</label>
              <p><input class="form-control" type="text" name="complementocad" id="complemento" maxlength="20"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Bairro</label>
              <p><input class="form-control" type="text" name="bairrocad" id="bairro" maxlength="60"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Cidade</label>
              <p><input class="form-control" type="text" name="cidadecad" id="cidade" maxlength="60"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">CEP</label>
              <p><input class="form-control" type="text" name="cepcad" id="cep" maxlength="9"></p>
            </div>

            <div class="col-sm-1">
              <label class="control-label">UF</label>
              <p><input class="form-control" type="text" name="ufcad" id="uf" maxlength="2"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Setor</label>
              <p><select class="select-notsearch" tabindex="-1" name="setorcad">
                  <option value="0">0 - Nenhum</option>
                  @foreach ($setores as $setor)
                  <option value={{$setor->id_setor}}>{{$setor->id_setor . ' - ' . $setor->setor}}</option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Tab.Preço</label>
              <p><select class="select-notsearch" tabindex="-1" name="tabPrecocad[]" multiple="multiple">
                  @foreach ($tabPrecos as $tabPreco)
                  <option value={{$tabPreco->id_tabela}}>{{$tabPreco->id_tabela . ' - ' . $tabPreco->descricao}}
                  </option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Modo de Cobrança</label>
              <p><select class="select-notsearch" tabindex="-1" name="modCobcad[]" multiple="multiple">
                  @foreach ($modCobs as $modCob)
                  <option value={{$modCob->id_modocob}}>{{$modCob->id_modocob . ' - ' . $modCob->descricao}}</option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Prazo de Pagamento</label>
              <p><select class="select-notsearch" tabindex="-1" name="tabPrazocad[]" multiple="multiple">
                  @foreach ($prazoCobs as $prazoCob)
                  <option value={{$prazoCob->id_prazo}}>{{$prazoCob->id_prazo . ' - ' . $prazoCob->descricao}}</option>
                  @endforeach
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

<!-- Modal Visualizacao-->
<div class="modal fade" id="VisualizarVenModal" tabindex="-1" role="dialog" aria-labelledby="VisualizarVenModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="view_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="VisualizarVenModalLabel"></h5>
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

            <div class="col-sm-1">
              <label class="control-label">ID</label>
              <input class="form-control" type="text" name="idVendedor" id="vencod_view" disabled>
            </div>

            <div class="col-sm-5">
              <label class="control-label">Nome</label>
              <p><input class="form-control" type="text" name="nomeview" id="nome_view" disabled></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">CNPJ / CPF</label>
              <p><input class="form-control" type="text" name="cnpjcpfview" id="cnpjcpf_view" disabled></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Tipo Pessoa</label>
              <select class="select-notsearch" tabindex="-1" name="pessoaview" id="pessoa_view" disabled>
                <option value="0">Física</option>
                <option value="1">Júridica</option>
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Tipo de Vendedor</label>
              <select class="select-notsearch" tabindex="-1" name="tipoview" id="tipovendedor_view" disabled>
                <option value="0">Vendedor</option>
                <option value="1">Supervisor</option>
                <option value="2">Gerente</option>
              </select>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Supervisor</label>
              <select class="select-notsearch" tabindex="-1" name="supervisorview" id="supervisor_view" disabled>
                <option value="0">Nenhum</option>
                @foreach ($supervisores as $supervisor)
                <option value={{$supervisor->id_vendedor}}>{{$supervisor->nome}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Gerente</label>
              <select class="select-notsearch" tabindex="-1" name="gerenteview" id="gerente_view" disabled>
                <option value="0">Nenhum</option>
                @foreach ($gerentes as $gerente)
                <option value={{$gerente->id_vendedor}}>{{$gerente->nome}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Email</label>
              <p><input class="form-control" type="email" name="emailview" id="email_view" disabled></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Ativo</label>
              <p><select class="select-notsearch" tabindex="-1" name="statusview" id="status_view" disabled>
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Empresa</label>
              <p><select class="select-notsearch" tabindex="-1" name="empresaview" id="empresa_view" disabled>
                  @foreach ($empresas as $empresa)
                  <option value={{$empresa->id_empresa}}>{{$empresa->id_empresa . ' - ' . $empresa->razao_social}}
                  </option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Pedido Mínimo</label>
              <input class="form-control" type="number" name="pedminview" id="pedmin_view" disabled>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Comissão</label>
              <input class="form-control" type="number" name="comissaoview" id="comissao_view" disabled>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Pago na emissao(%)</label>
              <input class="form-control" type="number" name="pagoemissaoview" id="pagoemissao_view" disabled>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Pago na baixa(%)</label>
              <input class="form-control" type="number" name="pagobaixaview" id="pagobaixa_view" disabled>


            </div>

            <div class="col-sm-2">
              <label class="control-label">Desconto máximo(%)</label>
              <input class="form-control" type="number" name="descontoview" id="desconto_view" disabled>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Telefone</label>
              <input class="form-control" type="text" name="telefoneview" id="telefone_view" disabled>
            </div>

            <div class="col-sm-6">
              <label class="control-label">Logradouro</label>
              <input class="form-control" type="text" name="logradouroview" id="logradouro_view" maxlength="200"
                disabled>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Número</label>
              <p><input class="form-control" type="text" name="numeroview" id="numero_view" maxlength="20" disabled></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Complemento</label>
              <p><input class="form-control" type="text" name="complementoview" id="complemento_view" maxlength="20"
                  disabled></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Bairro</label>
              <p><input class="form-control" type="text" name="bairroview" id="bairro_view" maxlength="60" disabled></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Cidade</label>
              <p><input class="form-control" type="text" name="cidadeview" id="cidade_view" maxlength="60" disabled></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">CEP</label>
              <p><input class="form-control" type="text" name="cepview" id="cep_view" maxlength="9" disabled></p>
            </div>

            <div class="col-sm-1">
              <label class="control-label">UF</label>
              <p><input class="form-control" type="text" name="ufcadview" id="uf_view" maxlength="2" disabled></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Setor</label>
              <p><select class="select-notsearch" tabindex="-1" name="setorview" id="setor_view" disabled>
                  <option value="0">0 - Nenhum</option>
                  @foreach ($setores as $setor)
                  <option value={{$setor->id_setor}}>{{$setor->id_setor . ' - ' . $setor->setor}}</option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Tab.Preço</label>
              <p><select class="select-notsearch" tabindex="-1" name="tabPrecocad[]" id="tabPreco_view"
                  multiple="multiple" disabled>
                  @foreach ($tabPrecos as $tabPreco)
                  <option value={{$tabPreco->id_tabela}}>{{$tabPreco->id_tabela . ' - ' . $tabPreco->descricao}}
                  </option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Modo de Cobrança</label>
              <p><select class="select-notsearch" tabindex="-1" name="modCobcad[]" multiple="multiple" id="modCob_view"
                  disabled>
                  @foreach ($modCobs as $modCob)
                  <option value={{$modCob->id_modocob}}>{{$modCob->id_modocob . ' - ' . $modCob->descricao}}</option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Prazo de Pagamento</label>
              <p><select class="select-notsearch" tabindex="-1" name="tabPrazocad[]" multiple="multiple"
                  id="tabPrazo_view" disabled>
                  @foreach ($prazoCobs as $prazoCob)
                  <option value={{$prazoCob->id_prazo}}>{{$prazoCob->id_prazo . ' - ' . $prazoCob->descricao}}</option>
                  @endforeach
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

<!-- Modal Alteracao-->
<div class="modal fade" id="AlterarVenModal" tabindex="-1" role="dialog" aria-labelledby="AlterarVenModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="alt_modalHeader">
        <div class="modal-header">
          <h5 class="modal-title" id="AlterarVenModalLabel">Alterar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">

        <!-- Form de cadastro -->
        <form class="form-horizontal" method="POST" action="{{action('VendedorController@update')}}"
          enctype="multipart/form-data">
          @csrf
          <div class="form-group row">

            <div class="col-sm-5">
              <input class="form-control" type="hidden" name="idVendedor" id="vencod_alt">
              <label class="control-label">Nome</label>
              <p><input class="form-control" type="text" name="nomealt" id="nome_alt"></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">CNPJ / CPF</label>
              <p><input class="form-control" type="text" name="cnpjcpfalt" id="cnpjcpf_alt" disabled></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Tipo Pessoa</label>
              <select class="select-notsearch" tabindex="-1" name="pessoaalt" id="pessoa_alt" disabled>
                <option value="0">Física</option>
                <option value="1">Júridica</option>
              </select>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Tipo de Vendedor</label>
              <select class="select-notsearch" tabindex="-1" name="tipoalt" id="tipovendedor_alt">
                <option value="0">Vendedor</option>
                <option value="1">Supervisor</option>
                <option value="2">Gerente</option>
              </select>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Supervisor</label>
              <select class="select-notsearch" tabindex="-1" name="supervisoralt" id="supervisor_alt">
                <option value="0">Nenhum</option>
                @foreach ($supervisores as $supervisor)
                <option value={{$supervisor->id_vendedor}}>{{$supervisor->nome}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Gerente</label>
              <select class="select-notsearch" tabindex="-1" name="gerentealt" id="gerente_alt">
                <option value="0">Nenhum</option>
                @foreach ($gerentes as $gerente)
                <option value={{$gerente->id_vendedor}}>{{$gerente->nome}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Email</label>
              <p><input class="form-control" type="email" name="emailalt" id="email_alt"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Ativo</label>
              <p><select class="select-notsearch" tabindex="-1" name="statusalt" id="status_alt">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Empresa</label>
              <p><select class="select-notsearch" tabindex="-1" name="empresaalt" id="empresa_alt">
                  @foreach ($empresas as $empresa)
                  <option value={{$empresa->id_empresa}}>{{$empresa->id_empresa . ' - ' . $empresa->razao_social}}
                  </option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Pedido Mínimo</label>
              <input class="form-control" type="number" name="pedminalt" id="pedmin_alt" step="0.01" min="0">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Comissão</label>
              <input class="form-control" type="number" name="comissaoalt" id="comissao_alt" step="0.01" min="0">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Pago na emissao(%)</label>
              <input class="form-control" type="number" name="pagoemissaoalt" id="pagoemissao_alt" step="0.01" min="0">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Pago na baixa(%)</label>
              <input class="form-control" type="number" name="pagobaixaalt" id="pagobaixa_alt" step="0.01" min="0">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Desconto máximo(%)</label>
              <input class="form-control" type="number" name="descontoalt" id="desconto_alt" step="0.01" min="0">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Telefone</label>
              <input class="form-control" type="text" name="telefonealt" id="telefone_alt">
            </div>

            <div class="col-sm-6">
              <label class="control-label">Logradouro</label>
              <input class="form-control" type="text" name="logradouroalt" id="logradouro_alt" maxlength="200">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Número</label>
              <p><input class="form-control" type="text" name="numeroalt" id="numero_alt" maxlength="20"></p>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Complemento</label>
              <p><input class="form-control" type="text" name="complementoalt" id="complemento_alt" maxlength="20"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Bairro</label>
              <p><input class="form-control" type="text" name="bairroalt" id="bairro_alt" maxlength="60"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Cidade</label>
              <p><input class="form-control" type="text" name="cidadealt" id="cidade_alt" maxlength="60"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">CEP</label>
              <p><input class="form-control" type="text" name="cepalt" id="cep_alt" maxlength="9"></p>
            </div>

            <div class="col-sm-1">
              <label class="control-label">UF</label>
              <p><input class="form-control" type="text" name="ufalt" id="uf_alt" maxlength="2"></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Setor</label>
              <p><select class="select-notsearch" tabindex="-1" name="setoralt" id="setor_alt">
                  <option value="0">0 - Nenhum</option>
                  @foreach ($setores as $setor)
                  <option value={{$setor->id_setor}}>{{$setor->id_setor . ' - ' . $setor->setor}}</option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Tab.Preço</label>
              <p><select class="select-notsearch" tabindex="-1" name="tabPrecoalt[]" id="tabPreco_alt"
                  multiple="multiple">
                  @foreach ($tabPrecos as $tabPreco)
                  <option value={{$tabPreco->id_tabela}}>{{$tabPreco->id_tabela . ' - ' . $tabPreco->descricao}}
                  </option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Modo de Cobrança</label>
              <p><select class="select-notsearch" tabindex="-1" name="modCobalt[]" multiple="multiple" id="modCob_alt">
                  @foreach ($modCobs as $modCob)
                  <option value={{$modCob->id_modocob}}>{{$modCob->id_modocob . ' - ' . $modCob->descricao}}</option>
                  @endforeach
                </select></p>
            </div>

            <div class="col-sm-4">
              <label class="control-label">Prazo de Pagamento</label>
              <p><select class="select-notsearch" tabindex="-1" name="tabPrazoalt[]" multiple="multiple"
                  id="tabPrazo_alt">
                  @foreach ($prazoCobs as $prazoCob)
                  <option value={{$prazoCob->id_prazo}}>{{$prazoCob->id_prazo . ' - ' . $prazoCob->descricao}}</option>
                  @endforeach
                </select></p>
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

<!-- Modal Resetar Senha-->
<div class="modal fade" id="modal-password">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="password_modalHeader">
        <div class="modal-header">
          <h4 class="b_text_modal_title_password"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="{{action('VendedorController@resetPassword')}}">
          @csrf
          <input type="hidden" class="form-control col-form-label-sm" id="idVendedor" name="idVendedor">
          <label class="b_text_modal_password">Deseja realmente resetar a senha deste vendedor? <br> A senha padrão será:
            123</label>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary btn-sm fa fa-times" data-dismiss="modal"> Cancelar</button>
            <button type="submit" class="btn btn-info btn-sm fa fa-trash-o"> Confirmar</button>
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
        <form class="form-horizontal" method="POST" action="{{action('VendedorController@destroy')}}">
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
<script src="{{url('/')}}/js/pages/vendedores.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="{{url('/')}}/js/plugins/mask/jquery.mask.min.js" type="text/javascript"></script>
@endsection