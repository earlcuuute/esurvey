<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>eSurvey</title>

    <!-- Fonts -->
    <!-- Font Awesome 4.6.3 -->
    <link rel="stylesheet" href="{{ asset('plugins/font-awesome-4.6.3/css/font-awesome.min.css') }}">
    <!-- Lato Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">



    <!-- Miscs -->
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('plugins/ionicons-2.0.1/css/ionicons.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
    <!-- jQuery Toast -->
    <link rel="stylesheet" href="{{ asset('plugins/jquery-toast-plugin/jquery.toast.min.css') }}">

    <!-- Styles -->
    <!-- Bootstrap 3.3.7-->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-3.3.7/css/bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('plugins/AdminLTE-2.3.5/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('plugins/AdminLTE-2.3.5/dist/css/skins/_all-skins.min.css') }}">

    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body id="app-layout" class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

    <header class="main-header top-header">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <a href="@if (Auth::guest()){{ url('/') }} @else {{ url('/home') }} @endif" class="navbar-brand"><b>e</b>Survey</a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <!-- Left Side Of Navbar -->
                <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        @if (Auth::user())
                            <li class="active"><a href="{{ url('/home') }}">My Surveys <span class="sr-only">(current)</span></a></li>
                            <li><a href="#">I'm a Hero!</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Examples <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>

                <!-- Right Side Of Navbar -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                        @else

                        <!-- Create Survey, Display in all pages -->
                            <li><div><a href="{{ url('/create') }}" id="create-survey" class="btn btn-warning"><i class="fa fa-plus"></i> Create Survey</a></div></li>

                        <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->
                                    <img src="{{ asset('images/guest.png') }}" class="user-image" alt="User Image">
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs">{{ Auth::user()->username }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="{{ asset('images/guest.png') }}" class="img-circle" alt="User Image">

                                        <p>
                                            {{ Auth::user()->first_name ." "  .Auth::user()->last_name }} - Web Developer
                                            <small>Member since <?php
                                                $dt = new \Carbon\Carbon(Auth::user()->created_at);
                                                echo $dt->toFormattedDateString();
                                            ?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        <div class="row">
                                        </div>
                                        <!-- /.row -->
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- content goes here -->
    <div class="content-wrapper">
        <div class="container">
            <section class="content-header">
                <h1>
@yield('header')
                </h1>
                <ol class="breadcrumb">
@yield('breadcrumb')
                </ol>
            </section>

            <section class="content">
@yield('content')
            </section>
        </div>
    </div>

    <footer class="main-footer">
        <div class="container">
            <div class="pull-right hidden-xs">
                <b>Version</b> 0.1.2
            </div>
            <strong>Copyright &copy; 2016-2017 <a href="#">Fantastic Four</a>.</strong> All rights
            reserved.
        </div>
        <!-- /.container -->
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('plugins/bootstrap-3.3.7/js/bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('plugins/AdminLTE-2.3.5/dist/js/app.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('plugins/AdminLTE-2.3.5/dist/js/demo.js') }}"></script>

<!-- Miscellaneous -->
<!-- To Title Case -->
<script src="{{ asset('plugins/to-title-case/to-title-case.js') }}"></script>
<!-- BootBox 4.4.0-->
<script src="{{ asset('plugins/bootbox/bootbox.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- jQuery Toast -->
<script src="{{ asset('plugins/jquery-toast-plugin/jquery.toast.min.js') }}"></script>

<!-- Survey Script -->
<script src="{{ asset('js/survey.js') }}"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

</body>
</html>