@extends('admin.app')
@section('title', __('Mail'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Mail') }}</li>
    </ul>
@endsection

@section('content')
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            @include('admin.blocks.notification')

            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-body bg-light">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <h5 class="text-primary card-title"><i class="ri-pencil-fill"></i> {{ __('Create_a_newsletter') }}</h5>
                                </div>
                            </div>
                            <form class="email-form" action="{{ route('admin.settings.mail.send') }}" method="POST" target="_top">
                                {{ csrf_field() }}

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label" style="color:black; font-weight: bold;">{{ __('Recipients') }}:</label>
                                    <div class="col-sm-10">
                                        <select name="recipients" class="form-control bg-light" style="border:1px solid black;">
                                            <option value="special_users">{{ __('Users_tagged_for_tests') }}</option>
                                            <option value="all_users">{{ __('All_users') }}</option>
                                        </select>
                                        <p class="help-block">{{ __('The_test_label_can_be_set_in_the_user_settings') }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="subject" class="col-sm-2 col-form-label" style="color:black; font-weight: bold;">{{ __('Subject') }}:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="mail[subject]"  id="subject" class="form-control bg-light" style="border:1px solid black;">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="subject" class="col-sm-2 col-form-label" style="color:black; font-weight: bold;">{{ __('Message') }}:</label>
                                    <div class="col-md-10">
                                        <textarea class="summernote" name="mail[body]"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <div class="d-flex flex-grow-1 align-items-center">
                                        <div class="send-btn pl-3">
                                            <button type="submit" class="btn btn-primary">{{ __('Send') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/admin_assets/plugins/summernote/summernote-lite.css">
@endsection

@section('js')
    <script src="/admin_assets/plugins/summernote/summernote-lite.min.js"></script>

    <script>
        $('.summernote').summernote({
            height:300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
            ]
        });
    </script>
@endsection