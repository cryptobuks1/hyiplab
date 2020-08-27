@extends('admin.app')
@section('title', __('create_news'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.content.news.index') }}">{{ __('News') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('create_news') }}</li>
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
                                <h4 class="card-title">{{ __('create_news') }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="tab-content" id="myTabContent-3">
                                @if(\App\Models\Language::count() > 0)
                                <form action="{{ route('admin.content.news.store') }}" method="POST" target="_top">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="newsSubject">{{ __('title') }}</label>
                                                <input type="text" name="news[subject]" class="form-control" id="newsSubject" placeholder="" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="newsContent">{{ __('news_content') }}</label>
                                                <textarea class="form-control summernote" name="news[content]" placeholder="" id="newsContent" required></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="newsLanguageId">{{ __('news_language') }}</label>
                                                <select class="form-control" id="newsLanguageId" name="news[language_id]">
                                                    @foreach(\App\Models\Language::all() as $language)
                                                        <option value="{{ $language->id }}">{{ $language->code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">{{ __('create') }}</button>
                                </form>
                                @else
                                    <div class="alert alert-danger" role="alert">
                                        <div class="iq-alert-icon">
                                            <i class="ri-information-line"></i>
                                        </div>
                                        <div class="iq-alert-text">{{ __('To_create_news_please_register_language_first') }}</div>
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