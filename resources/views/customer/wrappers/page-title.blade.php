<!-- inner header wrapper start -->
<div class="page_title_section">

    <div class="page_header">
        <div class="container">
            <div class="row">

                <div class="col-lg-9 col-md-9 col-12 col-sm-8">

                    <h1>@yield('title')</h1>
                </div>
                <div class="col-lg-3 col-md-3 col-12 col-sm-4">
                    <div class="sub_title_section">
                        <ul class="sub_title">
                            <li> <a href="{{ route('customer.main') }}"> {{ __('Main') }} </a>&nbsp; / &nbsp; </li>
                            <li>@yield('title')</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- inner header wrapper end -->