<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex">
    <title>Webでサイネージ | システム管理画面</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/assets/admin_lte_3.2.0/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('/assets/admin_lte_3.2.0/dist/css/adminlte.min.css')}}">
    
    @stack('article')

</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav  mr-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="w-100">
                    <div class="brand-text font-weight-light pt-2"></div>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">

                    <div class="brand-text font-weight-light pt-2">
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('admin') }}" class="brand-link">
                Webでサイネージ
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ url('/admin/news') }}" class="nav-link">
                                <i class="nav-icon fas fa-bicycle"></i>
                                <p>
                                    お知らせ
                                </p>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-bell"></i>
                                <p>
                                    FAQ管理
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item ml-4">
                                    <a href="{{asset('/admin/faq/')}}" class="nav-link">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            FAQ
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item ml-4">
                                    <a href="{{asset('/admin/faq-category/')}}" class="nav-link">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            FAQカテゴリ
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>


        @yield('content')


        <!-- /.control-sidebar -->

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{asset('/assets/admin_lte_3.2.0/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('/assets/admin_lte_3.2.0/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('/assets/admin_lte_3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('/assets/admin_lte_3.2.0/dist/js/adminlte.min.js')}}"></script>

    @stack('script')

</body>
</html>