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
              data-target="#VisualizarVenModal" > Visualizar</button>
            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 2)&&($acesso->ativo == 1))
            <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarUserModal" > Alterar</button>

            <button type="button" class="btn btn-info btn-sm fa fa-key" data-toggle="modal"
              data-target="#modal-password" ></button>
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
              <input class="form-control" type="number" name="pedmincad" min="0.00" id="pedmin" value="0.00">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Comissão</label>
              <input class="form-control" type="number" name="comissaocad" min="0.00" id="comissao" value="0.00">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Pago na emissao(%)</label>
              <input class="form-control" type="number" name="pagoemissaocad" min="0.00" id="pagoemissao" value="0.00">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Pago na baixa(%)</label>
              <p><input class="form-control" type="number" name="pagobaixacad" min="0.00" id="pagobaixa" value="0.00">
              </p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Desconto máximo(%)</label>
              <input class="form-control" type="number" name="descontocad" min="0.00" id="desconto" value="0.00">
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
                <option value={{$tabPreco->id_tabela}}>{{$tabPreco->id_tabela . ' - ' . $tabPreco->descricao}}</option>
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
          <h5 class="modal-title" id="VisualizarUserModalLabel"></h5>
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
              <label class="control-label">Código Vendedor</label>
              <input class="form-control" type="text" name="idVendedor" id="ven_cod" disabled>
            </div>

            <div class="col-sm-5">
              <label class="control-label">Nome</label>
              <p><input class="form-control" type="text" name="nomeview" id="nome_view" disabled></p>
            </div>

            <div class="col-sm-3">
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
              <p><select class="select-notsearch" tabindex="-1" name="empresacad" id="empresa_view" disabled>
                @foreach ($empresas as $empresa)
                <option value={{$empresa->id_empresa}}>{{$empresa->id_empresa . ' - ' . $empresa->razao_social}}
                </option>
                @endforeach
              </select></p>
            </div>

            <div class="col-sm-2">
              <label class="control-label">Pedido Mínimo</label>
              <input class="form-control" type="number" name="pedmincad" min="0.00" id="pedmin" value="0.00">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Comissão</label>
              <input class="form-control" type="number" name="comissaocad" min="0.00" id="comissao" value="0.00">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Pago na emissao(%)</label>
              <input class="form-control" type="number" name="pagoemissaocad" min="0.00" id="pagoemissao" value="0.00">
            </div>

            <div class="col-sm-2">
              <label class="control-label">Pago na baixa(%)</label>
              <input class="form-control" type="number" name="pagobaixacad" min="0.00" id="pagobaixa" value="0.00">

            
            </div>

            <div class="col-sm-2">
              <label class="control-label">Desconto máximo(%)</label>
              <input class="form-control" type="number" name="descontocad" min="0.00" id="desconto" value="0.00">
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
                <option value={{$tabPreco->id_tabela}}>{{$tabPreco->id_tabela . ' - ' . $tabPreco->descricao}}</option>
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
<script src="{{url('/')}}/js/pages/vendedores.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="{{url('/')}}/js/plugins/mask/jquery.mask.min.js" type="text/javascript"></script>
@endsection