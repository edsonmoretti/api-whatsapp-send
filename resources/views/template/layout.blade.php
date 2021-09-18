<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
<head>
    @include('template.head')
</head>
<body class="sidebar-fixed sidebar-dark header-light header-fixed" id="body">
<script>
    NProgress.configure({showSpinner: false});
    NProgress.start();
</script>
<div class="mobile-sticky-body-overlay"></div>
<div class="wrapper">
    <aside class="left-sidebar bg-sidebar">
        @include('template.sidebar')
    </aside>
    <div class="page-wrapper">
        <!-- Header -->
        <header class="main-header " id="header">
            @include('template.header')
        </header>

        <div class="content-wrapper">
            <div class="content">
                {{--   ERRORs     /--}}
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                            <ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <i class="fa fa-info mx-2"></i>
                                <strong>{{ $error }}</strong>
                            </ul>
                        </div>
                    @endforeach
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <i class="fa fa-info mx-2"></i>
                        <strong>{{ session('error') }}</strong>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <i class="fa fa-info mx-2"></i>
                        <strong>{{ session('success') }}</strong>
                    </div>
                @endif
                {{--FIM ERRORs--}}
                <div class="page-header row no-gutters py-4">
                    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                        <span class="text-uppercase page-subtitle">{{ $subtitle ?? '' }}</span>
                        <h3 class="page-title">{{ $title ?? '' }}</h3>
                    </div>
                </div>
                @yield('content')
            </div>
        </div>
        <footer class="footer mt-auto">
            @include('template.footer')
        </footer>
    </div>
</div>
</body>
</html>
