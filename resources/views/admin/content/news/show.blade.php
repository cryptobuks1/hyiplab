@extends('admin.app')
@section('title', __('News_details'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.content.news.index') }}">{{ __('News') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('News_details') }}: {{ $news->subject }}</li>
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
                                <h4 class="card-title">{{ __('News_details') }}: {{ $news->subject }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <form action="{{ route('admin.content.news.update', ['id' => $news->id]) }}" method="POST" target="_top">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="exampleInputText1">{{ __('ID') }}</label>
                                    <input type="text" class="form-control" id="exampleInputText1" value="{{ $news->id }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputText2">{{ __('Title') }}</label>
                                    <input type="text" class="form-control" id="exampleInputText2" name="news[subject]" value="{{ $news->subject }}">
                                </div>

                                <div class="form-group">
                                    <label for="newsContent">{{ __('news_content') }}</label>
                                    <textarea class="form-control summernote" name="news[content]" placeholder="" id="newsContent" required>{{ $news->content }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="newsLanguageId">{{ __('news_language') }}</label>
                                    <select class="form-control" name="news[language_id]" id="newsLanguageId">
                                        @foreach(\App\Models\Language::all() as $language)
                                            <option value="{{ $language->id }}"{{ $news->language_id == $language->id ? ' selected' : '' }}>{{ $language->code }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="newsCreatedAt">{{ __('Creation_date') }}</label>
                                    <input type="datetime-local" class="form-control" name="news[created_at]" id="newsCreatedAt" value="{{ \Carbon\Carbon::parse($news->created_at)->format('Y-m-d\TH:i:s') }}">
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                <button type="button" class="btn iq-bg-danger" onClick="sureAndRedirect(this, '{{ route('admin.content.news.destroy', ['id' => $news->id]) }}')">
                                    {{ __('Delete_news') }}</button>
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