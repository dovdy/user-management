@extends('layouts.app')

@section('page-title', __('Users Export'))
@section('page-heading', __('Users'))

@section('breadcrumbs')
    <li class="breadcrumb-item text-muted">
        @lang('Users')
    </li>
    <li class="breadcrumb-item active">
        @lang('Export')
    </li>
@stop

@section('content')

@include('partials.messages')

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="auth">
        <div class="row">
            <div class="col-md-6">
                @include('user.partials.export-options')
            </div>
        </div>
    </div>
</div>

@stop