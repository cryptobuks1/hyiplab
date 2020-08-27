@extends('admin.app')
@section('title', __('Website_translations'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Website_translations') }}</li>
    </ul>
@endsection

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            @include('admin.blocks.notification')

            <div class="row">
                <div class="col-sm-6">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{ __('Create_new_translation') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="row justify-content-between">
                                <div class="col-lg-12">
                                    <div id="user_list_datatable_info" class="dataTables_filter">
                                        <form action="{{ route('admin.settings.translations.store') }}" method="POST" target="_top">
                                            {{ csrf_field() }}

                                            <div class="form-group">
                                                <label>{{ __('Key') }}</label>
                                                <input type="text" class="form-control" name="language[key]" value="" placeholder="">
                                            </div>

                                            @foreach($languages as $language)
                                                <div class="form-group">
                                                    <label>{{ strtoupper($language) }}:</label>
                                                    <input type="text" class="form-control" name="language[{{ $language }}]" value="" placeholder="">
                                                </div>
                                            @endforeach

                                            <div class="form-group">
                                                <input type="submit" class="btn btn-outline-success" value="{{ __('create') }}">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{ __('Search') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="row justify-content-between">
                                <div class="col-lg-6">
                                    <div id="user_list_datatable_info" class="dataTables_filter">
                                        <form class="mr-3 position-relative" action="" method="GET" target="_top">
                                            <div class="form-group mb-0">
                                                <input type="search" name="search" class="form-control" id="exampleInputSearch" value="{{ request('search') }}" placeholder="{{ __('Search_by_keyword') }}" aria-controls="user-list-table">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            @if(count($defaultTranslations) > 0)
                <div class="row">
                    @foreach($defaultTranslations as $key => $translate)
                        <div class="col-lg-6">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <form action="{{ route('admin.settings.translations.update', ['key' => $key]) }}" method="POST" target="_top">
                                        {{ csrf_field() }}

                                        <div class="form-group">
                                            <label>{{ __('Key') }}</label>
                                            <input type="text" class="form-control" name="language[{{ $key }}][key]" value="{{ $key }}" placeholder="{{ $key }}">
                                        </div>

                                        @foreach($languages as $language)
                                        <div class="form-group">
                                            <label>{{ strtoupper($language) }}:</label>
                                            <input type="text" class="form-control" name="language[{{ $key }}][{{ $language }}]" value="{{ $allTranslations[$language][$key] ?? '' }}" placeholder="{{ $allTranslations[$language][$key] ?? '' }}">
                                        </div>
                                        @endforeach

                                        <div class="form-group">
                                            <input type="submit" class="btn btn-outline-primary" value="{{ __('save') }}">
                                            <input type="submit" class="btn btn-outline-danger sure" name="destroy" value="{{ __('delete') }}">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-lg-12">
                        <a href="{{ route('admin.settings.translations.index', ['page' => isset($_GET['page']) && $_GET['page'] > 1 ? $_GET['page'] - 1 : 1]) }}" class="btn btn-primary">{{ __('previous_page') }}</a>
                        <a href="{{ route('admin.settings.translations.index', ['page' => isset($_GET['page']) && $_GET['page'] >= 1 ? $_GET['page'] + 1 : 2]) }}" class="btn btn-primary">{{ __('next_page') }}</a>
                    </div>
                </div>
            @else
                <div class="alert alert-secondary" role="alert" style="margin-top:30px;">
                    <div class="iq-alert-icon">
                        <i class="ri-information-line"></i>
                    </div>
                    <div class="iq-alert-text">{{ __('Translations_not_found') }}</div>
                </div>
            @endif
            </div>
        </div>
    </div>
@endsection