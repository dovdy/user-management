@extends('layouts.app')

@section('page-title', __('Gebruiker bijwerken'))
@section('page-heading', $user->present()->nameOrEmail)

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('users.index') }}">@lang('Users')</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('users.show', $user->id) }}">
            {{ $user->present()->nameOrEmail }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        @lang('Edit')
    </li>
@stop

@section('content')

@include('partials.messages')

<div class="row">
    
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('user.update.avatar', $user->id) }}"
                      method="POST"
                      id="avatar-form"
                      enctype="multipart/form-data">
                    @csrf
                    @include('user.partials.avatar', ['updateUrl' => route('user.update.avatar.external', $user->id)])
                </form>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="nav-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active"
                           id="details-tab"
                           data-toggle="tab"
                           href="#details"
                           role="tab"
                           aria-controls="home"
                           aria-selected="true">
                            @lang('Persoon Gegevens')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           id="authentication-tab"
                           data-toggle="tab"
                           href="#login-details"
                           role="tab"
                           aria-controls="home"
                           aria-selected="true">
                            @lang('Primair Login Gegevens')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           id="emails-tab"
                           data-toggle="tab"
                           href="#emails"
                           role="tab"
                           aria-controls="home"
                           aria-selected="true">
                            @lang('Extra Emails')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           id="passwords-tab"
                           data-toggle="tab"
                           href="#passwords"
                           role="tab"
                           aria-controls="home"
                           aria-selected="true">
                            @lang('Extra Passwords')
                        </a>
                    </li>
                    @if (setting('2fa.enabled'))
                        <li class="nav-item">
                            <a class="nav-link"
                               id="authentication-tab"
                               data-toggle="tab"
                               href="#2fa"
                               role="tab"
                               aria-controls="home"
                               aria-selected="true">
                                @lang('Two-Factor Authentication')
                            </a>
                        </li>
                    @endif
                </ul>

                <div class="tab-content mt-4" id="nav-tabContent">
                    <div class="tab-pane fade show active px-2"
                         id="details"
                         role="tabpanel"
                         aria-labelledby="nav-home-tab">
                        <form action="{{ route('users.update.details', $user) }}" method="POST" id="details-form">
                            @csrf
                            @method('PUT')
                            @include('user.partials.details', ['profile' => false])
                        </form>
                    </div>

                    <div class="tab-pane fade px-2"
                         id="login-details"
                         role="tabpanel"
                         aria-labelledby="nav-profile-tab">
                        <form action="{{ route('users.update.login-details', $user) }}"
                              method="POST"
                              id="login-details-form">
                            @csrf
                            @method('PUT')
                            @include('user.partials.auth')
                        </form>
                    </div>

                    <div class="tab-pane fade px-2"
                         id="emails"
                         role="tabpanel"
                         aria-labelledby="nav-profile-tab">
                        <form action="{{ route('users.update.multiple-emails', $user) }}"
                              method="POST"
                              id="multiple-emails-form">
                            @csrf
                            @method('PUT')
                            @include('user.partials.multiple-emails')
                        </form>
                    </div>

                    <div class="tab-pane fade px-2"
                         id="passwords"
                         role="tabpanel"
                         aria-labelledby="nav-profile-tab">
                        <form action="{{ route('users.update.multiple-passwords', $user) }}"
                              method="POST"
                              id="multiple-passwords-form">
                            @csrf
                            @method('PUT')
                            @include('user.partials.multiple-passwords')
                        </form>
                    </div>

                    @if (setting('2fa.enabled'))
                        <div class="tab-pane fade px-2" id="2fa" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <?php $route = Authy::isEnabled($user) ? 'disable' : 'enable'; ?>

                            <form action="{{ route("two-factor.{$route}") }}" method="POST" id="two-factor-form">
                                @csrf
                                <input type="hidden" name="user" value="{{ $user->id }}">
                                @include('user.partials.two-factor')
                            </form>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
    {!! HTML::script('assets/js/as/btn.js') !!}
    {!! HTML::script('assets/js/as/profile.js') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\User\UpdateDetailsRequest', '#details-form') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\User\UpdateLoginDetailsRequest', '#login-details-form') !!}

    {!! JsValidator::formRequest('Vanguard\Http\Requests\User\UpdateMultipleEmailsRequest', '#multiple-emails-form') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\User\UpdateMultiplePasswordsRequest', '#multiple-passwords-form') !!}

    @if (setting('2fa.enabled'))
        {!! JsValidator::formRequest('Vanguard\Http\Requests\TwoFactor\EnableTwoFactorRequest', '#two-factor-form') !!}
    @endif
@stop
