<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta name="description" content="">
    <!-- Twitter meta-->
    <meta property="twitter:card" content="s">
    <meta property="twitter:site" content="">
    <meta property="twitter:creator" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Seduc v1">
    <meta property="og:title" content="Seduc v1">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta property="og:description" content="">
    <title>@yield('title') - MidoTech</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="/">Seduc</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i> {{$unome}}</a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="page-user.html"><i class="fa fa-user fa-lg"></i> Perfil</a></li>
            <li><a class="dropdown-item" href="#"><i class="fa fa-sign-out fa-lg"></i> Sair</a></li>
          </ul>
        </li>
      </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <!-- Aqui pode colocar foto/usuario/perfil do funcionário-->
      <!-- Exemplo:
      -->
      <div class="app-sidebar__user text-justify">
        <img class="app-sidebar__user-avatar" src="{{$uimagem}}" width="70px" height="70px" alt="User Image">
        <div>
          <p class="app-sidebar__user-name">{{$unome}}</p>
          <p class="app-sidebar__user-designation">{{$uperfilnome}}</p>
        </div>
      </div>
      <ul class="app-menu">
        <!-- Menu simples -->
        <li>
          <a class="app-menu__item" href="/">
            <i class="app-menu__icon fa fa-dashboard"></i>
            <span class="app-menu__label">Início</span>
          </a>
        </li>
        <!-- "is-expanded" CSS Pra abrir o menu assim que carregar a página -->
        <li class="treeview ">
          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-file-text"></i>
            <span class="app-menu__label">Cadastros</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>
          <ul class="treeview-menu">
            
            <li><a class="treeview-item" href="{{route('usuario')}}"><i class="icon fa fa-circle-o"></i> Usuário</a></li>
            
            
            <li><a class="treeview-item" href="{{route('bairro')}}"><i class="icon fa fa-circle-o"></i> Bairro</a></li>
            <li><a class="treeview-item" href="{{route('escola')}}"><i class="icon fa fa-circle-o"></i> Escola</a></li>
            <li><a class="treeview-item" href="{{route('viacao')}}"><i class="icon fa fa-circle-o"></i> Viação</a></li>
          

            <li><a class="treeview-item" href="{{route('aluno')}}"><i class="icon fa fa-circle-o"></i> Aluno</a></li>
            <li><a class="treeview-item" href="{{route('funcionario')}}"><i class="icon fa fa-circle-o"></i> Funcionário</a></li>
            <li><a class="treeview-item" href="{{route('materia')}}"><i class="icon fa fa-circle-o"></i> Matéria</a></li>
            <li><a class="treeview-item" href="{{route('aula')}}"><i class="icon fa fa-circle-o"></i> Aula</a></li>

          </ul>
        </li>
      </ul>
    </aside>
    <main class="app-content">
      @yield('content')
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="{{url('/')}}/js/jquery-3.3.1.min.js"></script>
    <script src="{{url('/')}}/js/popper.min.js"></script>
    <script src="{{url('/')}}/js/bootstrap.min.js"></script>
    <script src="{{url('/')}}/js/main.js"></script>
    <script src="{{url('/')}}/js/blutec.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{url('/')}}/js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="{{url('/')}}/js/plugins/bootstrap-notify.min.js"></script>
    <script type="text/javascript" src="{{url('/')}}/js/plugins/sweetalert.min.js"></script>
    <script type="text/javascript" src="{{url('/')}}/js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="{{url('/')}}/js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="{{url('/')}}/js/plugins/dropzone.js"></script>
    <script type="text/javascript" src="{{url('/')}}/js/plugins/jquery.maskedinput.js"></script>
    
    <!-- Data table plugin-->
    <script type="text/javascript" src="{{url('/')}}/js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{url('/')}}/js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="{{url('/')}}/js/plugins/bootstrap-filestyle.min.js"> </script>

    <script type="text/javascript">$('#DataTable').DataTable();</script>
    <!-- Google analytics script-->
    <script type="text/javascript">
      if(document.location.hostname == 'pratikborsadiya.in') {
      	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      	ga('create', 'UA-72504830-1', 'auto');
      	ga('send', 'pageview');
      }

      $("body").bind("ajaxSend", function(elm, xhr, s){
          if (s.type == "POST") {
            xhr.setRequestHeader('X-CSRF-Token', getCSRFTokenValue());
          }
      });
    </script>
  </body>
</html>