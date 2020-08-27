@extends('admin.app')
@section('title', __('Language_details'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.settings.languages.index') }}">{{ __('Languages') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Language_details') }}: {{ $language->code }}</li>
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
                                <h4 class="card-title">{{ __('Language_details') }}: {{ $language->code }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <form action="{{ route('admin.settings.languages.update', ['id' => $language->id]) }}" method="POST" target="_top">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="exampleInputText1">{{ __('ID') }}</label>
                                    <input type="text" class="form-control" id="exampleInputText1" value="{{ $language->id }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputText2">{{ __('Code') }}</label>
                                    <input type="text" class="form-control" id="exampleInputText2" value="{{ $language->code }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="languageDefault">{{ __('Is_main_language') }}</label>
                                    <select class="form-control" name="language[default]" id="languageDefault">
                                        <option value="0">{{ __('no') }}</option>
                                        <option value="1"{{ $language->default == 1 ? ' selected' : '' }}>{{ __('yes') }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="languageCreatedAt">{{ __('Creation_date') }}</label>
                                    <input type="datetime-local" class="form-control" name="language[created_at]" id="languageCreatedAt" value="{{ \Carbon\Carbon::parse($language->created_at)->format('Y-m-d\TH:i:s') }}">
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                <button type="button" class="btn iq-bg-danger" onClick="sureAndRedirect(this, '{{ route('admin.settings.languages.destroy', ['id' => $language->id]) }}')">
                                    {{ __('Delete_language') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection