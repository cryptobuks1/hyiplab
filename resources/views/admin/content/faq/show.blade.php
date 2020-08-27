@extends('admin.app')
@section('title', __('FAQ_details'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.content.faq.index') }}">{{ __('FAQ_list') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('FAQ_details') }}: {{ $faq->id }}</li>
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
                                <h4 class="card-title">{{ __('FAQ_details') }}: {{ $faq->id }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <form action="{{ route('admin.content.faq.update', ['id' => $faq->id]) }}" method="POST" target="_top">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="exampleInputText1">{{ __('ID') }}</label>
                                    <input type="text" class="form-control" id="exampleInputText1" value="{{ $faq->id }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="faqQuestion">{{ __('Question') }}</label>
                                    <input type="text" name="faq[question]" class="form-control" id="faqQuestion" placeholder="" value="{{ $faq->question }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="faqAnswer">{{ __('Answer') }}</label>
                                    <textarea class="form-control summernote" name="faq[answer]" placeholder="" id="faqAnswer" required>{{ $faq->answer }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="faqLanguageId">{{ __('Language') }}</label>
                                    <select class="form-control" id="faqLanguageId" name="faq[language_id]">
                                        @foreach(\App\Models\Language::all() as $language)
                                            <option value="{{ $language->id }}"{{ $faq->language_id == $language->id ? ' selected' : '' }}>{{ $language->code }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="faqCreatedAt">{{ __('Creation date') }}</label>
                                    <input type="datetime-local" class="form-control" name="faq[created_at]" id="faqCreatedAt" value="{{ \Carbon\Carbon::parse($faq->created_at)->format('Y-m-d\TH:i:s') }}">
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                <button type="button" class="btn iq-bg-danger" onClick="sureAndRedirect(this, '{{ route('admin.content.faq.destroy', ['id' => $faq->id]) }}')">
                                    {{ __('Delete_FAQ') }}</button>
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