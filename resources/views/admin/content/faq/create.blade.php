@extends('admin.app')
@section('title', __('Register_FAQ'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.content.faq.index') }}">{{ __('FAQ_list') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Register_FAQ') }}</li>
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
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">{{ __('Register_FAQ') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="tab-content" id="myTabContent-3">
                                @if(\App\Models\Language::count() > 0)
                                <form action="{{ route('admin.content.faq.store') }}" method="POST" target="_top">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="faqQuestion">{{ __('Question') }}</label>
                                                <input type="text" name="faq[question]" class="form-control" id="faqQuestion" placeholder="" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="faqAnswer">{{ __('Answer') }}</label>
                                                <textarea class="form-control summernote" name="faq[answer]" placeholder="" id="faqAnswer" required></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="faqLanguageId">{{ __('Language') }}</label>
                                                <select class="form-control" id="faqLanguageId" name="faq[language_id]">
                                                    @foreach(\App\Models\Language::all() as $language)
                                                        <option value="{{ $language->id }}">{{ $language->code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                                </form>
                                @else
                                    <div class="alert alert-danger" role="alert">
                                        <div class="iq-alert-icon">
                                            <i class="ri-information-line"></i>
                                        </div>
                                        <div class="iq-alert-text">{{ __('To_create_FAQ_register_languages_first') }}</div>
                                    </div>
                                @endif
                            </div>
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