@extends('painel.template.template')

@section('title','Adicionar Cliente')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Cadastro: Cliente</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index">Home</a></li>
          <li class="breadcrumb-item active">Clientes</li>
          <li class="breadcrumb-item"><a href="{{route('clientes')}}">Listar Clientes</a></li>
          <li class="breadcrumb-item active">Novo</li>
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

    <form class="form-horizontal" method="POST" action="{{action('ClienteController@store')}}">
      @csrf
      <div class="form-group row">

        <div class="col-sm-6">
          <label class="control-label">Razão Social (*)</label>
          <input class="form-control" type="hidden" id="empcod" name="empcod" value="{{$uempresa}}">
          <p><input class="form-control" type="text" id="razao" name="razao" autocomplete="off" required></p>
        </div>

        <div class="col-sm-6">
          <label class="control-label">Nome Fantasia</label>
          <p><input class="form-control" type="text" id="fantasia" name="fantasia" autocomplete="off"></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Tipo Pessoa</label>
          <select class="form-control" tabindex="-1" name="pessoa" id="pessoa">
            <option value="0">Júridica</option>
            <option value="1">Júridica Não Contribuinte</option>
            <option value="2">Física</option>
          </select>
        </div>

        <div class="col-sm-3">
          <label class="control-label">CNPJ / CPF (*)</label>
          <p><input class="form-control" type="text" name="cnpjcpf" id="cnpjcpf" maxlength="18" autocomplete="off"
              required></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Insc. Estadual (*)</label>
          <p><input class="form-control" type="text" name="iestadual" id="iestadual" maxlength="13" value='ISENTO'
              autocomplete="off" required>
          </p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Status</label>
          <p><select class="select-notsearch" tabindex="-1" name="status" id="status">
              <option value="0">Normal</option>
              <option value="1">Venda Suspensa</option>
              <option value="2">Bloqueado</option>
              <option value="3">Inativo</option>
            </select></p>
        </div>

        <div class="col-sm-4">
          <label class="control-label">Email</label>
          <p><input class="form-control" type="email" name="email" id="email" maxlength="80"></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">CNPJ SEFAZ</label>
          <p><input class="form-control" type="text" name="cnpjsefaz" id="cnpjsefaz" maxlength="80" autocomplete="off">
          </p>
        </div>

        <div class="col-sm-2">
          <label class="control-label">Limite de Crédito (*)</label>
          <p><input class="form-control" type="number" name="limitecred" id="limitecred" autocomplete="off" value="0.00" step="0.01" min="0" required></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Venc. Limite de Crédito (*)</label>
          <p><input class="form-control" type="date" name="venccred" id="venccred" autocomplete="off" required></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Modo de Cobrança</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <input type="checkbox" name="cModCob" id="cModCob">
              </span>
            </div>
            <select class="form-control" tabindex="-1" name="modcob" id="modcob">
              @foreach ($modCobs as $modCob)
              <option value="{{$modCob->id_modocob}}">{{$modCob->id_modocob . ' - ' . $modCob->descricao}}</option>
              @endforeach
            </select>
          </div>
          <p></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Prazo de Pagamento</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <input type="checkbox" name="cPrazoPag" id="cPrazoPag">
              </span>
            </div>
            <select class="form-control" tabindex="-1" name="prazocob" id="prazocob">
              @foreach ($prazoCobs as $prazoCob)
              <option value="{{$prazoCob->id_prazo}}">{{$prazoCob->id_prazo . ' - ' . $prazoCob->descricao}}
              </option>
              @endforeach
            </select>
          </div>
          <p></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Tabela de Preço</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <input type="checkbox" name="cTabPreco" id="cTabPreco">
              </span>
            </div>
            <select class="form-control" tabindex="-1" name="tabpreco" id="tabpreco">
              <option value="0">0 - Nenhum</option>
              @foreach ($tabPrecos as $tabPreco)
              <option value="{{$tabPreco->id_tabela}}">{{$tabPreco->id_tabela . ' - ' . $tabPreco->descricao}}
              </option>
              @endforeach
            </select>
          </div>
          <p></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Grupo</label>
          <p><select class="select2" tabindex="-1" name="grupo" id="grupo">
              <option value="0">Pessoa Física</option>
              <option value="1">Pessoa Jurídica</option>
            </select></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Transportadora Padrão</label>
          <p><select class="select2" tabindex="-1" name="transp" id="transp">
              <option value="0">Nenhuma</option>
              <option value="1">FAZER CRUD</option>
            </select></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Orçamento</label>
          <p><select class="select-notsearch" tabindex="-1" name="orc" id="orc">
              <option value="0">Sem ou Com Orçamento</option>
              <option value="1">Com Orçamento</option>
              <option value="2">Sem Orçamento</option>
            </select></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Tipo de Saída</label>
          <p><select class="select2" tabindex="-1" name="tes" id="tes">
              <option value="0">FAZER CRUD</option>
            </select></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Vendedor</label>
          <p><select class="select2" tabindex="-1" name="vendedor" id="vendedor">
              @foreach ($vendedores as $vendedor)
              <option value="{{$vendedor->id_vendedor}}">
                {{$vendedor->id_vendedor . ' - ' .explode(" ", $vendedor->nome)[0]}}</option>
              @endforeach
            </select></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Tipo de Endereço</label>
          <p><select class="select-notsearch" tabindex="-1" name="tipolog" id="tipolog">
              <option value="0">Endereço Comercial</option>
              <option value="1">Endereço Cobrança</option>
              <option value="1">Endereço Entrega</option>
            </select></p>
        </div>

        <div class="col-sm-4">
          <label class="control-label">Logradouro (*)</label>
          <input class="form-control" type="hidden" name="ibge" id="ibge" maxlength="20">
          <p><input class="form-control" type="text" name="logradouro" id="logradouro" maxlength="250"
              required></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Complemento</label>
          <p><input class="form-control" type="text" name="complemento" id="complemento" maxlength="40"></p>
        </div>

        <div class="col-sm-2">
          <label class="control-label">Número (*)</label>
          <p><input class="form-control" type="text" name="numero" id="numero" maxlength="6" autocomplete="off"
              required></p>
        </div>

        <div class="col-sm-4">
          <label class="control-label">Bairro (*)</label>
          <p><input class="form-control" type="text" name="bairro" id="bairro" maxlength="30" autocomplete="off"
              required></p>
        </div>

        <div class="col-sm-4">
          <label class="control-label">Cidade (*)</label>
          <p><input class="form-control" type="text" name="cidade" id="cidade" maxlength="40" autocomplete="off"
              required></p>
        </div>

        <div class="col-sm-1">
          <label class="control-label">UF (*)</label>
          <p><input class="form-control" type="text" name="uf" id="uf" maxlength="2" autocomplete="off" required></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">CEP (*)</label>
          <p><input class="form-control cep-mask" type="text" name="cep" id="cep" maxlength="9" autocomplete="off"
              required></p>
        </div>

        <div class="col-sm-12">
          <label class="control-label">Referência</label>
          <p><textarea class="form-control" rows="3" name="referencia" maxlength="200" id="referencia"
              placeholder="Máximo 200 caracteres" autocomplete="off"></textarea></p>
        </div>

        <div class="col-sm-12">
          <label class="control-label">Observação</label>
          <textarea class="form-control" rows="3" name="obs" maxlength="200" id="obs"
            placeholder="Máximo 200 caracteres" autocomplete="off"></textarea>
        </div>

      </div>

      <label style="text-align: left">(*) -> Campos obrigatórios no cadastro</label>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="reset" data-dismiss="modal"><i class="fa fa-times">
            Cancelar</i></button>
        <button type="submit" class="btn btn-primary" id="btnSalvar" name="btnSalvar"><i class="fa fa-floppy-o">
            Salvar</i></button>
      </div>
    </form>
  </div>
</div>

@endsection


@section('js')
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/mask/jquery.mask.min.js"></script>
<script src="{{url('/')}}/js/pages/clientes.js"></script>
@endsection