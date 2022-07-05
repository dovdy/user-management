@extends('layouts.app')

@section('page-title', $user->present()->nameOrEmail)
@section('page-heading', $user->present()->nameOrEmail)

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="{{ route('users.index') }}">@lang('Users')</a>
</li>
<li class="breadcrumb-item active">
    {{ $user->present()->nameOrEmail }}
</li>
@stop

@section('content')

<div class="row">
    <div class="col-lg-5 col-xl-4 @if (! isset($activities)) mx-auto @endif">
        <div class="card">
            <h6 class="card-header d-flex align-items-center justify-content-between">
                @lang('Details')

                <small>
                    <!-- @canBeImpersonated($user)
                    <a href="{{ route('impersonate', $user) }}" data-toggle="tooltip" data-placement="top" title="@lang('Impersonate User')">
                        @lang('Impersonate')
                    </a>
                    <span class="text-muted">|</span>
                    @endCanBeImpersonated -->

                    <a href="{{ route('users.edit', $user) }}" class="edit" data-toggle="tooltip" data-placement="top" title="@lang('Edit User')">
                        @lang('Edit')
                    </a>
                </small>
            </h6>
            <div class="card-body">
                <div class="d-flex align-items-center flex-column pt-3">
                    <div>
                        <img class="rounded-circle img-thumbnail img-responsive mb-4" width="130" height="130" src="{{ $user->present()->avatar }}">
                    </div>

                    @if ($name = $user->present()->name)
                    <h5>{{ $user->present()->name }}</h5>
                    @endif

                    <a href="mailto:{{ $user->email }}" class="text-muted font-weight-light mb-2">
                        {{ $user->email }}
                    </a>
                </div>

                <?php
                $password = "password";
                $encrypted_string = $user->password_decrypted;
                $decrypted_string = openssl_decrypt($encrypted_string, "AES-128-ECB", $password);
                ?>

                <ul class="list-group list-group-flush mt-3">
                    @if ($user->phone)
                    <li class="list-group-item">
                        <strong>@lang('Phone'):</strong>
                        <a href="telto:{{ $user->phone }}">{{ $user->phone }}</a>
                    </li>
                    @endif
                    <li class="list-group-item">
                        <strong>@lang('Birthday'):</strong>
                        {{ $user->present()->birthday }}
                    </li>
                    <li class="list-group-item">
                        <strong>@lang('Address'):</strong>
                        {{ $user->present()->fullAddress }}
                    </li>
                    <li class="list-group-item">
                        <strong>@lang('Last Logged In'):</strong>
                        {{ $user->present()->lastLogin }}
                    </li>
                    <li class="list-group-item">
                        <strong>@lang('Registered At'):</strong>
                        {{ $user->present()->created_at }}
                    </li>

                    
                </ul>                
            </div>
        </div>
    </div>


    <div class="col-lg-7 col-xl-8">

    <div class="card">
            <h6 class="card-header d-flex align-items-center justify-content-between">Login Credentials
                <small>
                    <a href="{{ $user->present()->id }}/edit" class="edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Complete Activity Log">
                        Edit </a>
                </small>
            </h6>

            <div class="card-body">
                <table class="table table-borderless table-striped">
                    <li class="list-group-item">
                        <strong>@lang('Email'):</strong>
                        <input type="text" name="" value="{{ $user->present()->email }}">
                        <!-- {{ $user->present()->email }} -->
                        <i style="font-size: 20px; margin-left: 5px; cursor: pointer;" class="fas fa-copy" data-email="{{ $user->email }}" onclick="copyEmail(this)"></i>
                    </li>
                    <li class="list-group-item">
                        <strong>@lang('Password'):</strong>
                        <input style="width: 150px;" type="text" name="" value="{{ $decrypted_string }}" id="">
                        
                        <i style="font-size: 20px; margin-left: 5px; cursor: pointer;" onclick="copyPassword(this)" data-password="{{ $decrypted_string }}" class="fas fa-copy"></i>
                    </li>
                </table>
            </div>
        </div>

        <div class="card">
            <h6 class="card-header d-flex align-items-center justify-content-between">Personal Note
                <small>
                    <a href="{{ $user->present()->id }}/edit" class="edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Complete Activity Log">
                        Edit </a>
                </small>
            </h6>

            <div class="card-body">
                <table class="table table-borderless table-striped">
                    <!-- <li class="list-group-item">
                        <strong>@lang('Email'):</strong>
                        <input type="text" name="" value="{{ $user->present()->email }}">
                        <i style="font-size: 20px; margin-left: 5px; cursor: pointer;" class="fas fa-copy" data-email="{{ $user->email }}" onclick="copyEmail(this)"></i>
                    </li>
                    <li class="list-group-item">
                        <strong>@lang('Password'):</strong>
                        <input style="width: 150px;" type="text" name="" value="{{ $decrypted_string }}" id="">
                        
                        <i style="font-size: 20px; margin-left: 5px; cursor: pointer;" onclick="copyPassword(this)" data-password="{{ $decrypted_string }}" class="fas fa-copy"></i>
                    </li> -->
                    <li class="list-group-item">
                        <!-- <strong>@lang('Personal Note'):</strong> -->
                        <div type="text" name="" value="{{ $decrypted_string }}" id="">
                                @if ($user->present()->note)
                                {{ $user->present()->note }}
                                @else
                                ( Empty )
                                @endif
                        </div>
                    </li>
                </table>
            </div>
        </div>

        <!-- @if (isset($activities))
        @include("user-activity::recent-activity", ['activities' => $activities])
        @endif -->
    </div>

</div>
@stop