@extends('admin.app')
@section('title', __('News'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
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
                                <h4 class="card-title">@yield('title')</h4>
                            </div>
                            <input type="button" class="btn btn-primary" value="{{ __('create_news') }}" onClick="location.assign('{{ route('admin.content.news.create') }}')">
                        </div>
                        <div class="iq-card-body">
                            <div class="row justify-content-between">
                                <div class="col-sm-12 col-md-6">
                                    <div id="user_list_datatable_info" class="dataTables_filter">
                                        <form class="mr-3 position-relative" action="" method="GET" target="_top">
                                            <div class="form-group mb-0">
                                                <input type="search" name="search" class="form-control" id="exampleInputSearch" value="{{ request('search') }}" placeholder="{{ __('Search_by_news') }}" aria-controls="user-list-table">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @if($news->count() > 0)
                                <table class="table table-striped table-bordered mt-4">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('Title') }}</th>
                                        <th scope="col">{{ __('News_content_100_symbols') }}</th>
                                        <th scope="col">{{ __('Language') }}</th>
                                        <th scope="col">{{ __('Creation_date') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($news as $newsItem)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.content.news.show', ['id' => $newsItem->id]) }}" target="_blank">{{ $newsItem->subject }}</a>
                                            </td>
                                            <td>
                                                <textarea class="form-control" readonly>{!! substr($newsItem->content, 0, 100) !!}...</textarea>
                                            </td>
                                            <td>{!! $newsItem->language != null ? '<span class="badge badge-success">'.$newsItem->language->code.'</span>' : '<span class="badge badge-danger">'.__('no_language').'</span>' !!}</td>
                                            <td>{{ \Carbon\Carbon::parse($newsItem->created_at)->toDateTimeString() }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                {!! $news->appends(request()->input())->links() !!}
                            @else
                                <div class="alert alert-secondary" role="alert" style="margin-top:30px;">
                                    <div class="iq-alert-icon">
                                        <i class="ri-information-line"></i>
                                    </div>
                                    <div class="iq-alert-text">{{ __('No_news_found') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection