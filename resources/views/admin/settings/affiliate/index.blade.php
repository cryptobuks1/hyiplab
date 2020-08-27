@extends('admin.app')
@section('title', __('Affiliate_program'))

@section('breadcrumbs')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Affiliate_program') }}</li>
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
                                <h4 class="card-title">{{ __('Affiliate_program') }}</h4>
                            </div>
                            <input type="button" class="btn btn-primary" value="{{ __('create_level') }}" onClick="location.assign('{{ route('admin.settings.affiliate.create') }}')">
                        </div>
                        <div class="iq-card-body">
                            <ul class="nav nav-tabs justify-content-center" id="myTab-2" role="tablist">
                                @foreach($levels as $level)
                                    <li class="nav-item">
                                        <a class="nav-link{{ $loop->index == 0 ? ' active' : '' }}" id="home-tab-justify" data-toggle="tab" href="#{{ $level->id }}" role="tab" aria-controls="home" aria-selected="true">{{ __('level') }} {{ $level->level }}</a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content" id="myTabContent-3">
                                @foreach($levels as $level)
                                    <div class="tab-pane fade show {{ $loop->index == 0 ? ' active' : '' }}" id="{{ $level->id }}" role="tabpanel" aria-labelledby="home-tab-justify">
                                        <div class="col-lg-12">
                                            <form action="{{ route('admin.settings.affiliate.update', ['id' => $level->id]) }}" method="POST" target="_top">
                                                {{ csrf_field() }}

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputText1">{{ __('ID') }}</label>
                                                            <input type="text" class="form-control" id="exampleInputText1" value="{{ $level->id }}" readonly>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exampleInputText2">{{ __('Level') }}</label>
                                                            <input type="number" step="1" class="form-control" id="exampleInputText2" name="level[level]" value="{{ $level->level }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exampleInputText3">{{ __('Percent') }}</label>
                                                            <input type="number" step="1" class="form-control" id="exampleInputText3" name="level[percent]" value="{{ $level->percent }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>{{ __('When_replenishing') }}</label>
                                                            <select class="form-control" name="level[on_load]">
                                                                <option value="0">{{ __('no') }}</option>
                                                                <option value="1"{{ $level->on_load == 1 ? ' selected' : '' }}>
                                                                    {{ __('yes') }}</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>{{ __('When_earning_on_a_deposit') }}</label>
                                                            <select class="form-control" name="level[on_profit]">
                                                                <option value="0">{{ __('no') }}</option>
                                                                <option value="1"{{ $level->on_profit == 1 ? ' selected' : '' }}>
                                                                    {{ __('yes') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">

                                                    </div>
                                                </div>

                                                <hr>

                                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                <button type="button" class="btn iq-bg-danger" onClick="sureAndRedirect(this, '{{ route('admin.settings.affiliate.destroy', ['id' => $level->id]) }}')">
                                                    {{ __('Delete_level }}</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection