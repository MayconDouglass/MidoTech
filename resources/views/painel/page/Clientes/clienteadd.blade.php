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
          <li class="breadcrumb-item active"><a href="{{route('adduser')}}">Novo</a></li>
        </ol>
      </div>
    </div>
  </div>
</div>

@endsection

@section('content')
<div class="card">
  <div class="card-body">

    <form class="form-horizontal" method="POST" action="{{action('ClienteController@store')}}">
      @csrf
      <div class="form-group row">

        <div class="col-sm-6">
          <label class="control-label">Razão Social</label>
          <input class="form-control" type="hidden" id="empcad" name="empcad" value="{{$uempresa}}">
          <p><input class="form-control" type="text" id="razcad" name="razcad" required></p>
        </div>

        <div class="col-sm-6">
          <label class="control-label">Nome Fantasia</label>
          <p><input class="form-control" type="text" id="fancad" name="fancad"></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Tipo Pessoa</label>
          <select class="form-control" tabindex="-1" name="pessoacad" id="pessoa">
            <option value="0">Júridica</option>
            <option value="1">Júridica Não Contribuinte</option>
            <option value="2">Física</option>
          </select>
        </div>

        <div class="col-sm-3">
          <label class="control-label">CNPJ / CPF</label>
          <p><input class="form-control" type="text" name="cnpjcpfcad" id="cnpjcpf" maxlength="18" required></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Insc. Estadual</label>
          <p><input class="form-control" type="text" name="iestadualcad" id="iestadual" maxlength="13" value='ISENTO'>
          </p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Status</label>
          <p><select class="form-control" tabindex="-1" name="statuscad" id="status">
              <option value="0">Normal</option>
              <option value="1">Venda Suspensa</option>
              <option value="2">Bloqueado</option>
              <option value="3">Inativo</option>
            </select></p>
        </div>

        <div class="col-sm-4">
          <label class="control-label">Email</label>
          <p><input class="form-control" type="email" name="emailcad" id="email" maxlength="80"></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">CNPJ SEFAZ</label>
          <p><input class="form-control" type="email" name="cnpjsefazcad" id="cnpjsefaz" maxlength="80"></p>
        </div>

        <div class="col-sm-2">
          <label class="control-label">Limite de Crédito</label>
          <p><input class="form-control" type="email" name="limitecredcad" id="limitecred"></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Venc. Limite de Crédito</label>
          <p><input class="form-control" type="date" name="limitecredcad" id="limitecred"></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Modo de Cobrança</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <input type="checkbox" name="cModCob">
              </span>
            </div>
            <select class="form-control" tabindex="-1" name="modcobcad" id="modcob">
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
                <input type="checkbox" name="cPrazoPag">
              </span>
            </div>
            <select class="form-control" tabindex="-1" name="prazocobcad" id="prazocob">
              @foreach ($prazoCobs as $prazoCob)
              <option value="{{$prazoCob->id_prazo}}">{{$prazoCob->id_prazo . ' - ' . $prazoCob->descricao}}</option>
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
                <input type="checkbox" name="cTabPreco">
              </span>
            </div>
            <select class="form-control" tabindex="-1" name="tabprecocad" id="tabpreco">
              <option value="0">0 - Nenhum</option>
              @foreach ($tabPrecos as $tabPreco)
              <option value="{{$tabPreco->id_tabela}}">{{$tabPreco->id_tabela . ' - ' . $tabPreco->descricao}}</option>
              @endforeach
            </select>
          </div>
          <p></p>
        </div>

        <div class="col-sm-3">
          <label class="control-label">Grupo</label>
          <p><select class="form-control" tabindex="-1" name="grupocad" id="grupo">
              <option value="0">Pessoa Física</option>
              <option value="1">Pessoa Jurídica</option>
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
@endsection


@section('js')
<script src="{{url('/')}}/js/pages/clientes.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
@endsection