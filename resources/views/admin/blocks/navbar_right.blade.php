<nav class="navbar navbar-expand-lg navbar-light p-0">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="ri-menu-3-line"></i>
    </button>
    <div class="iq-menu-bt align-self-center">
        <div class="wrapper-menu">
            <div class="line-menu half start"></div>
            <div class="line-menu"></div>
            <div class="line-menu half end"></div>
        </div>
    </div>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto navbar-list">
            <li class="nav-item">
                <a href="#servertime" class="badge border border-info text-info" data-toggle="modal" data-target=".bd-servertime"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ now()->format('H:i') }}</a>
            </li>
            <li class="nav-item">
                <a class="search-toggle iq-waves-effect" href="#"><i class="ri-search-line"></i></a>
                <form action="{{ route('admin.clients.index') }}" class="search-box" method="GET">
                    <input type="text" class="text search-input" name="search" placeholder="{{ __('Search_by_login_or_email') }}" />
                </form>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="search-toggle iq-waves-effect">
                    <i class="la la-language"></i>
                </a>
                <div class="iq-sub-dropdown">
                    <div class="iq-card shadow-none m-0">
                        <div class="iq-card-body p-0 ">
                            <div class="bg-cobalt-blue p-3">
                                <h5 class="mb-0 text-white">{{ __('Change_language') }}</h5>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="list-group" style="margin-top:15px;">
                                        <a href="{{ route('language.set', ['code' => 'ru']) }}" class="list-group-item list-group-item-action {{ app()->getLocale() == 'ru' ? 'active' : '' }}">
                                            <div class="d-flex w-100 justify-content-between">
                                                <img src="/admin_assets/images/langs/ru.png">
                                                <h5 class="mb-1 {{ app()->getLocale() == 'ru' ? 'text-white' : '' }}">
                                                    {{ __('Russian') }}</h5>
                                            </div>
                                        </a>
                                        <a href="{{ route('language.set', ['code' => 'en']) }}" class="list-group-item list-group-item-action {{ app()->getLocale() == 'en' ? 'active' : '' }}">
                                            <div class="d-flex w-100 justify-content-between">
                                                <img src="/admin_assets/images/langs/en.png">
                                                <h5 class="mb-1 {{ app()->getLocale() == 'en' ? 'text-white' : '' }}">
                                                    {{ __('English') }}</h5>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
{{--            <li class="nav-item">--}}
{{--                <a href="#" class="search-toggle iq-waves-effect">--}}
{{--                    <i class="ri-notification-2-line"></i>--}}
{{--                    <span class="bg-danger dots"></span>--}}
{{--                </a>--}}
{{--                <div class="iq-sub-dropdown">--}}
{{--                    <div class="iq-card shadow-none m-0">--}}
{{--                        <div class="iq-card-body p-0 ">--}}
{{--                            <div class="bg-danger p-3">--}}
{{--                                <h5 class="mb-0 text-white">{{ __('Latest_notifications') }}<small class="badge  badge-light float-right pt-1">4</small></h5>--}}
{{--                            </div>--}}
{{--                            <a href="#" class="iq-sub-card" >--}}
{{--                                <div class="media align-items-center">--}}
{{--                                    <div class="media-body ml-3">--}}
{{--                                        <h6 class="mb-0 ">New Order Recieved</h6>--}}
{{--                                        <small class="float-right font-size-12">23 hrs ago</small>--}}
{{--                                        <p class="mb-0">Lorem is simply</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                            <a href="#" class="iq-sub-card" >--}}
{{--                                <div class="media align-items-center">--}}
{{--                                    <div class="">--}}
{{--                                        <img class="avatar-40 rounded" src="/admin_assets/images/user/01.jpg" alt="">--}}
{{--                                    </div>--}}
{{--                                    <div class="media-body ml-3">--}}
{{--                                        <h6 class="mb-0 ">Emma Watson Nik</h6>--}}
{{--                                        <small class="float-right font-size-12">Just Now</small>--}}
{{--                                        <p class="mb-0">95 MB</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                            <a href="#" class="iq-sub-card" >--}}
{{--                                <div class="media align-items-center">--}}
{{--                                    <div class="">--}}
{{--                                        <img class="avatar-40 rounded" src="/admin_assets/images/user/02.jpg" alt="">--}}
{{--                                    </div>--}}
{{--                                    <div class="media-body ml-3">--}}
{{--                                        <h6 class="mb-0 ">New customer is join</h6>--}}
{{--                                        <small class="float-right font-size-12">5 days ago</small>--}}
{{--                                        <p class="mb-0">Jond Nik</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                            <a href="#" class="iq-sub-card" >--}}
{{--                                <div class="media align-items-center">--}}
{{--                                    <div class="">--}}
{{--                                        <img class="avatar-40" src="/admin_assets/images/small/jpg.svg" alt="">--}}
{{--                                    </div>--}}
{{--                                    <div class="media-body ml-3">--}}
{{--                                        <h6 class="mb-0 ">Updates Available</h6>--}}
{{--                                        <small class="float-right font-size-12">Just Now</small>--}}
{{--                                        <p class="mb-0">120 MB</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </li>--}}
            <li class="nav-item iq-full-screen"><a href="#" class="iq-waves-effect" id="btnFullscreen"><i class="ri-fullscreen-line"></i></a></li>
        </ul>
    </div>
    <ul class="navbar-list">
        <li>
            <a href="#" class="search-toggle iq-waves-effect bg-primary text-white"><img src="/admin_assets/images/user/1.jpg" class="img-fluid rounded" alt="user"></a>
            <div class="iq-sub-dropdown iq-user-dropdown">
                <div class="iq-card shadow-none m-0">
                    <div class="iq-card-body p-0 ">
                        <div class="bg-primary p-3">
                            <h5 class="mb-0 text-white line-height">{{ __('Hello') }} {{ auth()->guard('admin')->user()->login }}</h5>
                        </div>
                        <a href="{{ route('customer.main') }}" target="_blank" class="iq-sub-card iq-bg-primary-hover">
                            <div class="media align-items-center">
                                <div class="rounded iq-card-icon iq-bg-primary">
                                    <i class="ri-home-2-line"></i>
                                </div>
                                <div class="media-body ml-3">
                                    <h6 class="mb-0 ">{{ __('Home') }}</h6>
                                    <p class="mb-0 font-size-12">{{ __('Go_to_main_website') }}</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('admin.dashboard') }}" target="_top" class="iq-sub-card iq-bg-primary-hover">
                            <div class="media align-items-center">
                                <div class="rounded iq-card-icon iq-bg-primary">
                                    <i class="ri-admin-line"></i>
                                </div>
                                <div class="media-body ml-3">
                                    <h6 class="mb-0 ">{{ __('Admin_panel') }}</h6>
                                    <p class="mb-0 font-size-12">{{ __('Go_to_admin_dashboard') }}</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('admin.choose_template', ['template' => 1]) }}" target="_top" class="iq-sub-card iq-bg-primary-hover">
                            <div class="media align-items-center">
                                <div class="rounded iq-card-icon iq-bg-primary">
                                    <i class="ri-font-color"></i>
                                </div>
                                <div class="media-body ml-3">
                                    <h6 class="mb-0 ">{{ __('Change_color_scheme') }}</h6>
                                </div>
                            </div>
                        </a>
                        <div class="d-inline-block w-100 text-center p-3">
                            <a class="iq-bg-danger iq-sign-btn" href="{{ route('admin.logout') }}" role="button">{{ __('Logout') }}<i class="ri-login-box-line ml-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</nav>