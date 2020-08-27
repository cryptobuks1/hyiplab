<!-- cp navi wrapper Start -->
<nav class="cd-dropdown d-block d-sm-block d-md-block d-lg-none d-xl-none">
    <h2><a href="{{ route('customer.main') }}"> {{ config('app.name') }} </a></h2>
    <a href="#0" class="cd-close">{{ __('close') }}</a>
    <ul class="cd-dropdown-content">
        <li><a href="{{ route('customer.main') }}">{{ __('main') }}</a></li>
        <li><a href="{{ route('customer.about-us') }}">{{ __('about_us') }}</a></li>
        <li><a href="{{ route('customer.contact-us') }}">{{ __('contacts') }}</a></li>
        <li><a href="{{ route('customer.faq') }}">{{ __('FAQ') }}</a></li>
        <li><a href="{{ route('customer.investment') }}">{{ __('investments') }}</a></li>
    </ul>
    <!-- .cd-dropdown-content -->
</nav>