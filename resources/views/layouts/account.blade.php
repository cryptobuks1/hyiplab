<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="zxx">
<!--[endif]-->

<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="description" content="HyipLab" />
    <meta name="keywords" content="HyipLab" />
    <meta name="author" content="" />
    <meta name="MobileOptimized" content="320" />
    <!--Template style -->
    <link rel="stylesheet" type="text/css" href="/assets/css/animate.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/flaticon.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/owl.theme.default.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/nice-select.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/datatables.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/dropify.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/responsive.css" />
    <!--favicon-->
    <link rel="shortcut icon" type="image/png" href="/assets/images/favicon.ico" />

    @yield('css')
</head>

<body>

@include('account.blocks.change_language')
@yield('content')

<!--custom js files-->
<script src="/assets/js/jquery-3.3.1.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/modernizr.js"></script>
<script src="/assets/js/jquery.menu-aim.js"></script>
<script src="/assets/js/plugin.js"></script>
<script src="/assets/js/jquery.countTo.js"></script>
<script src="/assets/js/dropify.min.js"></script>
<script src="/assets/js/datatables.js"></script>
<script src="/assets/js/jquery.nice-select.min.js"></script>
<script src="/assets/js/jquery.inview.min.js"></script>
<script src="/assets/js/jquery.magnific-popup.js"></script>
<script src="/assets/js/owl.carousel.js"></script>
<script src="/assets/js/custom.js"></script>
@yield('js')
</body>

</html>