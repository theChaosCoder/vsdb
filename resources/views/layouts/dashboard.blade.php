<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'VSDB - VapourSynth Database') }}</title>
    <meta name="description" content="VSDB - A VapourSynth Scripts & Plugins Database">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-126366564-1');
    </script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->

    <link href="{{ asset('css/normalize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="{{ asset('css/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/flag-icon.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cs-skin-elastic.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lib/datatable/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/scss/style.css') }}" rel="stylesheet">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>
<body>
        <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./"><small>VapourSynth Database</small></a>
                <a class="navbar-brand hidden" href="./"><small>VSDB</small></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="/dashboard"> <i class="menu-icon fa fa-tachometer-alt"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="/" target="_blank"> <i class="menu-icon fa fa-cube"></i>Plugins public</a>
                    </li>


                    <h3 class="menu-title">Plugins</h3><!-- /.menu-title -->
                    <li>
                        <a href="/dashboard/plugins"> <i class="menu-icon fa fa-cube"></i>Plugins</a>
                    </li>
                    <li>
                        <a href="/dashboard/pluginfunctions"> <i class="menu-icon fa fa-cubes"></i>Plugin functions</a>
                    </li>
                    <li>
                        <a href="/dashboard/categories"> <i class="menu-icon fa fa-layer-group"></i>Categories</a>
                    </li>
                    @auth
                    <li>
                        <a href="/dashboard/export"> <i class="menu-icon fa fa-file-export"></i>Export plugins</a>
                    </li>
                    @endauth

                    <h3 class="menu-title">VSRepo</h3><!-- /.menu-title -->
                    <li>
                            <a href="/dashboard/vsrepo"> <i class="menu-icon fa fa-plus-square"></i>Package generator</a>
                    </li>
                    <li>
                        <a href="/dashboard/#"> <i class="menu-icon fa fa-compact-disc"></i>Show diff</a>
                    </li>
                    <li>
                        <a href="/dashboard/sync"> <i class="menu-icon fa fa-sync"></i>Repo sync</a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    <div class="header-left">
                        <button class="search-trigger"><i class="fa fa-search"></i></button>
                        <div class="form-inline">
                            <form class="search-form">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                                <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-sm-5">
                    @auth
                    <span class="nav-link float-right"><b>{{ Auth::user()->name }}</b></span>
                    @endauth
                    <a class="nav-link float-right" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"><i class="fa fa-power -off"></i>{{ __('Logout') }}</a>
                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>

            </div>

        </header><!-- /header -->
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Table</a></li>
                            <li class="active">Data table</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">


                    @if(session('success'))
                        <div class="alert alert-success" role="alert">{{session('success')}}</div>
                    @endif
                    @yield('content')



                </div>
            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->

    <!-- Right Panel -->

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/vendor/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script src="{{ asset('js/lib/data-table/datatables.min.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/jszip.min.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('js/lib/data-table/datatables-init.js') }}"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.19/api/page.jumpToData().js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.noConflict();

            var position = document.URL.split('#')[1];

            if (position) {
                var el = $('#' + position);
                var table = $('#bootstrap-data-table').DataTable();
                table.page.jumpToData( position, 0 );
            }


        });
    </script>


</body>
</html>
