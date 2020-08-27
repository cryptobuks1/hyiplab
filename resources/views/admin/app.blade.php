<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="/admin_assets/images/favicon.ico" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/admin_assets/css/{{ getCurrentAdminTemplate() }}/bootstrap.min.css">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="/admin_assets/css/{{ getCurrentAdminTemplate() }}/typography.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="/admin_assets/css/{{ getCurrentAdminTemplate() }}/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="/admin_assets/css/{{ getCurrentAdminTemplate() }}/responsive.css">

    @yield('css')
</head>
<body>
@include('admin.blocks.servertime')
@include('admin.blocks.loader')
<!-- Wrapper Start -->
<div class="wrapper">
    <!-- Sidebar  -->
    <div class="iq-sidebar">
        <div class="iq-sidebar-logo d-flex justify-content-between">
            @include('admin.blocks.logo')
            <div class="iq-menu-bt align-self-center">
                <div class="wrapper-menu">
                    <div class="line-menu half start"></div>
                    <div class="line-menu"></div>
                    <div class="line-menu half end"></div>
                </div>
            </div>
        </div>
        <div id="sidebar-scrollbar">
            <nav class="iq-sidebar-menu">
                <ul id="iq-sidebar-toggle" class="iq-menu">
                    @include('admin.blocks.menu-vertical')
                </ul>
            </nav>
            <div class="p-3"></div>
        </div>
    </div>
    <!-- TOP Nav Bar -->
    <div class="iq-top-navbar">
        <div class="iq-navbar-custom">
            <div class="iq-sidebar-logo">
                <div class="top-logo">
                    @include('admin.blocks.logo')
                </div>
            </div>
            @include('admin.blocks.breadcrumbs')
            @include('admin.blocks.navbar_right')
        </div>
    </div>
    <!-- TOP Nav Bar END -->
    @yield('content')
    </div>
    <!-- Wrapper END -->
<!-- Footer -->
<footer class="bg-white iq-footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
{{--                <ul class="list-inline mb-0">--}}
{{--                    <li class="list-inline-item"><a href="{{ route('customer.main') }}">{{ __('Go_to_main_page') }}</a></li>--}}
{{--                </ul>--}}
            </div>
            <div class="col-lg-6 text-right">
                {{ date('Y') > 2020 ? '2020' : '' }}{{ date('Y') }} - <a href="https://hyiplab.net" target="_blank">Hyiplab</a>
            </div>
        </div>
    </div>
</footer>
<!-- Footer END -->
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="/admin_assets/js/jquery.min.js"></script>
<script src="/admin_assets/js/popper.min.js"></script>
<script src="/admin_assets/js/bootstrap.min.js"></script>
<!-- Appear JavaScript -->
<script src="/admin_assets/js/jquery.appear.js"></script>
<!-- Countdown JavaScript -->
<script src="/admin_assets/js/countdown.min.js"></script>
<!-- Counterup JavaScript -->
<script src="/admin_assets/js/waypoints.min.js"></script>
<script src="/admin_assets/js/jquery.counterup.min.js"></script>
<!-- Wow JavaScript -->
<script src="/admin_assets/js/wow.min.js"></script>
<!-- Apexcharts JavaScript -->
<script src="/admin_assets/js/apexcharts.js"></script>
<!-- Slick JavaScript -->
<script src="/admin_assets/js/slick.min.js"></script>
<!-- Select2 JavaScript -->
<script src="/admin_assets/js/select2.min.js"></script>
<!-- Owl Carousel JavaScript -->
<script src="/admin_assets/js/owl.carousel.min.js"></script>
<!-- Magnific Popup JavaScript -->
<script src="/admin_assets/js/jquery.magnific-popup.min.js"></script>
<!-- Smooth Scrollbar JavaScript -->
<script src="/admin_assets/js/smooth-scrollbar.js"></script>
<!-- lottie JavaScript -->
<script src="/admin_assets/js/lottie.js"></script>
<!-- Chart Custom JavaScript -->
<script src="/admin_assets/js/chart-custom.js"></script>
<!-- Custom JavaScript -->
<script src="/admin_assets/js/custom.js"></script>

<script>
    $(document).ready(function(){
        $('.sure').click(function(obj) {
            var confirm = window.confirm('{{ __('Do_you_confirm_this_action?') }}');

            if (!confirm) {
                obj.preventDefault();
            }
        });
    });

    function sureAndRedirect(obj, url) {
        var confirm = window.confirm('{{ __('Do_you_confirm_this_action?') }}');

        if (!confirm) {
            obj.preventDefault();
        } else {
            window.location.assign(url);
        }
    }
</script>

@yield('js')

</body>
</html>