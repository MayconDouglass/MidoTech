@extends('painel.template.template')

@section('title','Dashboard')

@section('head')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Clientes</span>
                    <span class="info-box-number">{{$clientes}}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-industry"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Fornecedores</span>
                    <span class="info-box-number">10</span>
                </div>
            </div>
        </div>

        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Pedidos</span>
                    <span class="info-box-number">760</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-roxo elevation-1"><i class="fas fa-cubes"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Produtos</span>
                    <span class="info-box-number">2000</span>
                </div>
            </div>
        </div>

    </div>

     <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <div class="col-md-8">

      <!-- TABLE: LATEST ORDERS -->
      <div class="card">
        <div class="card-header border-transparent">
          <h3 class="card-title">Últimos Pedidos</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table m-0">
              <thead>
                <tr>
                  <th>Nº Pedido</th>
                  <th>Razão Social</th>
                  <th>Status</th>
                  <th>Origem</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><a href="pagina do pedido">9842</a></td>
                  <td>Cereais Bramil Supermercados</td>
                  <td><span class="badge badge-success">Liberado p/ faturar</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">Telemarketing</div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pagina do pedido">1848</a></td>
                  <td>MidoTech</td>
                  <td><span class="badge badge-warning">Montagem de Carga</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">Digitado</div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pagina do pedido">3849</a></td>
                  <td>MidoTech</td>
                  <td><span class="badge badge-danger">Bloqueado</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">Digitado</div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pagina do pedido">4848</a></td>
                  <td>MidoTech</td>
                  <td><span class="badge badge-danger">Bloqueado Financeiro</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">Digitado</div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pagina do pedido">5748</a></td>
                  <td>MidoTech</td>
                  <td><span class="badge badge-info">Expedição</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">Digitado</div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pagina do pedido">6948</a></td>
                  <td>MidoTech</td>
                  <td><span class="badge badge-faturado">Faturado</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">Digitado</div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pagina do pedido">11348</a></td>
                  <td>MidoTech</td>
                  <td><span class="badge badge-credit">Analise de Crédito</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">Digitado</div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pagina do pedido">33848</a></td>
                  <td>MidoTech</td>
                  <td><span class="badge badge-repestoque">Reprovado Estoque</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">Digitado</div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pagina do pedido">55848</a></td>
                  <td>MidoTech</td>
                  <td><span class="badge badge-repfinanceiro">Reprovado Financeiro</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">Digitado</div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
          <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Novo Pedido</a>
          <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">Visualizar todos os pedidos</a>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->

    <div class="col-md-4">
      <!-- Info Boxes Style 2 -->
      <div class="info-box mb-3 bg-warning">
        <span class="info-box-icon"><i class="fas fa-tag"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Ticket Médio (MENSAL)</span>
          <span class="info-box-number">20</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-success">
        <span class="info-box-icon"><i class="fa fa-cart-arrow-down"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Devoluções / Perda (MENSAL)</span>
          <span class="info-box-number">1</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-danger">
        <span class="info-box-icon"><i class="fas fa-archive "></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Almoxarifado</span>
          <span class="info-box-number">{{$almoxarifado}}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-info">
        <span class="info-box-icon"><i class="fa fa-user-o"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Vendedores</span>
          <span class="info-box-number">{{$vendedores}}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->

      <!-- PRODUCT LIST -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Últimos produtos cadastrados</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <ul class="products-list product-list-in-card pl-2 pr-2">
            <li class="item">
              <div class="product-img">
                <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
              </div>
              <div class="product-info">
                <a href="javascript:void(0)" class="product-title">Produto 1
                  <span class="badge badge-info float-right">R$1800</span></a>
                <span class="product-description">
                  Código: XXXX
                </span>
              </div>
            </li>
            <!-- /.item -->
            <li class="item">
              <div class="product-img">
                <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
              </div>
              <div class="product-info">
                <a href="javascript:void(0)" class="product-title">Produto 2
                  <span class="badge badge-info float-right">R$700</span></a>
                <span class="product-description">
                  Código: XXXX
                </span>
              </div>
            </li>
            <!-- /.item -->
          </ul>
        </div>
        <!-- /.card-body -->
        <div class="card-footer text-center">
          <a href="produtos" class="uppercase">Visualizar todos</a>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
@endsection

@section('js')
<script src="{{url('/')}}/js/pages/midotech.js"></script>
@endsection