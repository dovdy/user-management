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
                @lang('Persoon Gegevens')

                <small>
                    <!-- @canBeImpersonated($user)
                    <a href="{{ route('impersonate', $user) }}" data-toggle="tooltip" data-placement="top" title="@lang('Impersonate User')">
                        @lang('Impersonate')
                    </a>
                    <span class="text-muted">|</span>
                    @endCanBeImpersonated -->

                    <a href="{{ route('users.edit', $user) }}" class="edit" data-toggle="tooltip" data-placement="top" title="@lang('Edit User')">
                        @lang('Bewerk')
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
                        <strong>@lang('Telefoonnummer'):</strong>
                        <a href="telto:{{ $user->phone }}">{{ $user->phone }}</a>						
                    </li>
                    @endif
                    <li class="list-group-item">
                        <strong>@lang('Geboortedatum'):</strong>
                        {{ $user->present()->birthday }}
                    </li>
                    <li class="list-group-item">
                        <strong>@lang('Aangemaakt'):</strong>
                        {{ $user->present()->created_at }}
                    </li>

                    
                </ul>                
            </div>
        </div>
    </div>


    <div class="col-lg-7 col-xl-8">

    <div class="card">
            <h6 class="card-header d-flex align-items-center justify-content-between">Primair Login Gegevens
                <small>
                    <a href="{{ $user->present()->id }}/edit" class="edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Complete Activity Log">
                        Edit </a>
                </small>
            </h6>

            <div class="card-body">
                <table class="table table-borderless table-striped">
				
				
				
                    <li class="list-group-item">
                        <i class="fa fa-envelope"> </i> <strong>@lang('Email'):<br></strong>
                        <input style="width: 205px;" type="text" name="" value="{{ $user->present()->email }}">						
						<button data-email="{{ $user->email }}" onclick="copyEmail(this)" type="submit" class="btn-sm btn-primary" id="update-details-btn">
						<i class="fa fa-copy"></i> </button>
					</li>
					
					
                    <li class="list-group-item">
                        <i class="fa fa-lock"> </i> <strong>@lang('Wachtwoord'):<br></strong>
                        <input style="width: 205px;" type="text" name="" value="{{ $decrypted_string }}" id="">
						<button onclick="copyPassword(this)" data-password="{{ $decrypted_string }}" type="submit" class="btn-sm btn-primary" id="update-details-btn">
						<i class="fa fa-copy"></i> </button>
					</li>
					
					
					
					

                </table>
            </div>
        </div>

        <div class="card">
            <h6 class="card-header d-flex align-items-center justify-content-between">Nota's
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
                                ( Leeg )
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