<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ __('admin_authorization') }}</title>
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
@include('admin.blocks.demo-access')
@include('admin.blocks.loader')
@include('admin.blocks.change_language')

<!-- Sign in Start -->
<section class="sign-in- bg-white">
    <div class="container-fluid p-0">
        <div class="row no-gutters" style="height:100%; width:100%; position: fixed;">
            <div class="col-lg-3"></div>
            <div class="col-lg-6 align-self-center">
                <div class="sign-in-from">
                    <h1 class="mb-0">{{ __('admin_panel') }}</h1>

                    @include('admin.blocks.notification')

                    <form class="mt-4" method="POST" action="{{ route('admin.login.handler') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->any() ? ' has-error' : '' }}">
                            <label for="exampleInputEmail1">{{ __('Login') }}</label>
                            <input style="background:#E7F0FE;" type="login" class="form-control mb-0" id="exampleInputEmail1" placeholder="" name="login" value="{{ old('login') }}">
                        </div>
                        <div class="form-group{{ $errors->any() ? ' has-error' : '' }}">
                            <label for="exampleInputPassword1">{{ __('Password') }}</label>
                            <input style="background:#E7F0FE;" type="password" class="form-control mb-0" id="exampleInputPassword1" placeholder="" name="password">
                        </div>
                        <div class="form-group{{ $errors->any() ? ' has-error' : '' }}">
                            <label>{{ __('Captcha') }}</label>
                            <div class="row">
                                <div class="col-lg-5">
                                    <?= captcha_img('flat') ?>
                                </div>
                                <div class="col-lg-7">
                                    <input style="background:#E7F0FE;" type="text" name="captcha" id="captcha" placeholder="{{ __('Code_from_captcha') }}" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="d-inline-block w-100">
                            <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                <input type="checkbox" class="custom-control-input" id="customCheck1" name="remember" checked>
                                <label class="custom-control-label" for="customCheck1">{{ __('remember_me') }}</label>
                            </div>
                            <button type="submit" class="btn btn-primary float-right" style="width:200px;">{{ __('Login') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Sign in END -->
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
<!-- Chart Custom JavaScript -->
<script src="/admin_assets/js/chart-custom.js"></script>
<!-- Custom JavaScript -->
<script src="/admin_assets/js/custom.js"></script>

<script>
    $(document).ready(function(){
        $('.bd-demo-access').modal('show');
    });
</script>
</body>
</html>