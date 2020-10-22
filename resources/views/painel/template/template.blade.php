<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title') | Midotech</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{url('/')}}/js/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" type="text/css"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{url('/')}}/js/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('/')}}/css/adminlte.min.css">
  <link rel="stylesheet" href="{{url('/')}}/css/midotech.css">
  <!-- CSS midotech -->
  @yield('css')
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fa fa-user-circle-o"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">{{explode(" ", $unome)[0]}}</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fa fa-user mr-2"></i> Perfil
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fa fa-envelope mr-2"></i> Mensagem
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fa fa-cogs mr-2"></i> Configuração
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{route('logout')}}" class="dropdown-item">
              <i class="fa fa-sign-out mr-2"></i> Sair
            </a>
          </div>
        </li>

      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="/" class="brand-link">
        <img src="{{url('/')}}/storage/sys/logoportal.png" alt="Logo" class="brand-image img-circle elevation-3"
          style="opacity: .8">
        <span class="brand-text font-weight-light">Midotech</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="app-sidebar__user text-justify">
          <img class="app-sidebar__user-avatar" src="{{$uimagem}}" width="70px" height="70px" alt="User Image">
          <div>
            <p class="app-sidebar__user-name">{{explode(" ", $unome)[0]}}</p>
            <p class="app-sidebar__user-designation">{{explode(" ", $unomeperfil)[0]}}</p>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add perfil : ADM -->
            @foreach ($acessoPerfil as $acesso)
            @if (($acesso->role == 1)&&($acesso->ativo == 1))
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                  Configuração
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              @foreach ($acessoPerfil as $acesso)
              @if (($acesso->role == 7)&&($acesso->ativo == 1))
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('perfis')}}" class="nav-link">
                    <i class="fas fa-users nav-icon"></i>
                    <p>Perfil</p>
                  </a>
                </li>
              </ul>
              @endif
              @endforeach

              @foreach ($acessoPerfil as $acesso)
              @if (($acesso->role == 6)&&($acesso->ativo == 1))
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('usuarios')}}" class="nav-link">
                    <i class="fas fa-user-plus nav-icon"></i>
                    <p>Usuário</p>
                  </a>
                </li>
              </ul>
              @endif
              @endforeach
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('empresas')}}" class="nav-link">
                    <i class="fas fa-building nav-icon"></i>
                    <p>Empresa</p>
                  </a>
                </li>
              </ul>

              @foreach ($acessoPerfil as $acesso)
              @if (($acesso->role == 5)&&($acesso->ativo == 1))
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('contratos')}}" class="nav-link">
                    <i class="fas fa-clipboard nav-icon"></i>
                    <p>Contratos</p>
                  </a>
                </li>
              </ul>
              @endif
              @endforeach
            </li>
            @endif
            @endforeach

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-superpowers"></i>
                <p>
                  Tabelas Genéricas
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @foreach ($acessoPerfil as $acesso)
                @if (($acesso->role == 1)&&($acesso->ativo == 1))
                <li class="nav-item">
                  <a href="{{route('modoCob')}}" class="nav-link">
                    <i class="fa fa-money nav-icon"></i>
                    <p>Modo de Cobrança</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('prazoPag')}}" class="nav-link">
                    <i class="fa fa-calendar nav-icon"></i>
                    <p>Prazo de Cobrança</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('tabPreco')}}" class="nav-link">
                    <i class="fa fa-usd nav-icon"></i>
                    <p>Tabela de Preço</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('tes')}}" class="nav-link">
                    <i class="fa fa-exchange nav-icon"></i>
                    <p>Tipo de Entrada/Saída</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('unidade')}}" class="nav-link">
                    <i class="fa fa-underline nav-icon"></i>
                    <p>Unidades</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('almoxarifado')}}" class="nav-link">
                    <i class="fa fa-archive nav-icon"></i>
                    <p>Almoxarifado</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('situacaotrib')}}" class="nav-link">
                    <i class="fa fa-gavel nav-icon"></i>
                    <p>Situação Tributária</p>
                  </a>
                </li>
                @endif
                @endforeach
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-circle"></i>
                <p>
                  Clientes
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @foreach ($acessoPerfil as $acesso)
                @if (($acesso->role == 1)&&($acesso->ativo == 1))
                <li class="nav-item">
                  <a href="{{route('clientes')}}" class="nav-link">
                    <i class="fa fa-user-o nav-icon"></i>
                    <p>Clientes</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('vendedores')}}" class="nav-link">
                    <i class="fa fa-address-card nav-icon"></i>
                    <p>Vendedores</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('setores')}}" class="nav-link">
                    <i class="fa fa-map-marker nav-icon"></i>
                    <p>Setores</p>
                  </a>
                </li>
                @endif
                @endforeach
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                      Relatórios
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>

                  <ul class="nav nav-treeview">

                    <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          121 . Cadastro
                          <i class="right fas fa-angle-left"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>1211 . Listagem Completa</p>
                          </a>
                        </li>

                        <li class="nav-item">
                          <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>1212 . Listagem Resumida</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="nav-item has-treeview">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>--</p>
                      </a>
                    </li>
                </li>
              </ul>
            </li>
              </ul>
              
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-cart-arrow-down "></i>
                <p>
                  Compras
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @foreach ($acessoPerfil as $acesso)
                @if (($acesso->role == 1)&&($acesso->ativo == 1))
                <li class="nav-item">
                  <a href="{{route('transportadora')}}" class="nav-link">
                    <i class="fa fa-truck nav-icon"></i>
                    <p>Transportadora</p>
                  </a>
                </li>
                @endif
                @endforeach
              </ul>
            </li>

        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      @yield('head')

      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        @yield('content')
      </section>

      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2020 <a href="{{url('/')}}">Midotech</a>.</strong>
      Todos os direitos reservados.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 0.0.1
      </div>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="{{url('/')}}/js/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="{{url('/')}}/js/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="{{url('/')}}/js/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="{{url('/')}}/js/adminlte.js"></script>


  <!-- PAGE PLUGINS -->
  @yield('js')
  <!-- jQuery Mapael -->
  <script src="{{url('/')}}/js/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="{{url('/')}}/js/plugins/raphael/raphael.min.js"></script>
  <script src="{{url('/')}}/js/plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="{{url('/')}}/js/plugins/jquery-mapael/maps/usa_states.min.js"></script>

  <!-- PAGE SCRIPTS -->
  <script src="{{url('/')}}/js/pages/dashboard2.js"></script>
</body>

</html>