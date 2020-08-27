<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name') }}</title>
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
</head>
<body>
@include('admin.blocks.loader')
<!-- Wrapper Start -->
<div class="wrapper">
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-sm-12 text-center">
                <div class="iq-error">
                    <h1>{{ $code }}</h1>
                    @if($code == 404)
                        <h4 class="mb-0">{{ __('oops_page_not_found') }}</h4>
                        <p>{{ __('Requested_page_not_found') }}</p>
                    @else
                        <h4 class="mb-0">{{ __('oops_something_went_wrong') }}</h4>
                        <p>{{ __('Tell_developers_about_that') }}</p>
                    @endif
                    <a class="btn btn-primary mt-3" href="{{ route('admin.dashboard') }}"><i class="ri-home-4-line"></i>{{ __('Back_to_dashboard') }}</a>
                    <img src="/admin_assets/images/error/01.png" class="img-fluid iq-error-img" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper END -->
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
</body>
</html>