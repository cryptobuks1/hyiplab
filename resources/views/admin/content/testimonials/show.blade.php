@extends('admin.app')
@section('title', __('Testimonial_details'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.content.testimonials.index') }}">{{ __('Testimonials') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Testimonial_details') }}: {{ $testimonial->id }}</li>
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
                                <h4 class="card-title">{{ __('Testimonial_details') }}: {{ $testimonial->id }}</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <form action="{{ route('admin.content.testimonials.update', ['id' => $testimonial->id]) }}" method="POST" target="_top">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="exampleInputText1">{{ __('ID') }}</label>
                                    <input type="text" class="form-control" id="exampleInputText1" value="{{ $testimonial->id }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="testimonialName">{{ __('Name') }}</label>
                                    <input type="text" name="testimonial[name]" class="form-control" id="testimonialName" placeholder="" value="{{ $testimonial->name }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="testimonialEmail">{{ __('Email') }}</label>
                                    <input type="email" name="testimonial[email]" class="form-control" id="testimonialEmail" placeholder="" value="{{ $testimonial->email }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="testimonialTestimonial">{{ __('Testimonial_text') }}</label>
                                    <textarea class="form-control summernote" name="testimonial[testimonial]" placeholder="" id="testimonialTestimonial" required>{{ $testimonial->testimonial }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="testimonialLanguageId">{{ __('Language') }}</label>
                                    <select class="form-control" id="testimonialLanguageId" name="testimonial[language_id]">
                                        @foreach(\App\Models\Language::all() as $language)
                                            <option value="{{ $language->id }}"{{ $testimonial->language_id == $language->id ? ' selected' : '' }}>{{ $language->code }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="testimonialCreatedAt">{{ __('Date_creation') }}</label>
                                    <input type="datetime-local" class="form-control" name="testimonial[created_at]" id="testimonialCreatedAt" value="{{ \Carbon\Carbon::parse($testimonial->created_at)->format('Y-m-d\TH:i:s') }}">
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                <button type="button" class="btn iq-bg-danger" onClick="sureAndRedirect(this, '{{ route('admin.content.testimonials.destroy', ['id' => $testimonial->id]) }}')">{{ __('Delete_testimonial') }}</button>
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