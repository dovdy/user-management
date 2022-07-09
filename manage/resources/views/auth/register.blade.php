@extends('layouts.auth')

@section('page-title', __('Registreren'))

@if (setting('registration.captcha.enabled'))
<script src='https://www.google.com/recaptcha/api.js'></script>
@endif

@section('content')

<style>
    .enter_contest {
        display: none;
    }

    .iti {
        display: block !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@16.0.2/build/js/intlTelInput.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@16.0.2/build/css/intlTelInput.css">
<script src="assets/js/custom.js"></script>
<script>

</script>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const enter_contest = urlParams.get('enter_contest')
        if (enter_contest == "true" || true) {
            step(1);
        }
        document.querySelector("#gender").value = 'female';
    });

    var current_step = 0;

    function step(step_number) {
        const step1 = document.querySelectorAll('.step1');
        const step2 = document.querySelectorAll('.step2');
        const step3 = document.querySelectorAll('.step3');
        switch (step_number) {
            case 1:
                step3.forEach(step3 => {
                    step3.style.display = 'none';
                });
                step2.forEach(step2 => {
                    step2.style.display = 'none';
                });
                step1.forEach(step1 => {
                    step1.style.display = 'block';
                });
                current_step = 1;
                break;
            case 2:
                var is_required = false;
                if (document.querySelector("#first_name").value == '' || document.querySelector("#first_name").value == null) {
                    document.querySelector("#first_name").classList.add('is-invalid');
                    is_required = true;
                }
                if (document.querySelector("#last_name").value == '' || document.querySelector("#last_name").value == null) {
                    document.querySelector("#last_name").classList.add('is-invalid');
                    is_required = true;
                }
                if (!underAgeValidate(document.querySelector("#birthday").value)) {
                    document.querySelector("#birthday-error").innerHTML = 'Je moet ten minste 13 jaar oud zijn om te registreren';
                    document.querySelector("#birthday-error").style.display = 'block';
                    document.querySelector("#birthday").classList.add('is-invalid');
                    is_required = true;
                }
                if (document.querySelector("#gender").value == 'gender') {
                    document.querySelector("#gender").classList.add('is-invalid');
                    is_required = true;
                }
                if (document.querySelector("#phone").value.length <= 3) {
                    document.querySelector("#phone-error").innerHTML = 'Telefoonnummer is onjuist.';
                    document.querySelector("#phone-error").style.display = 'block';
                    document.querySelector("#phone").classList.add('is-invalid');
                    is_required = true;
                }
                if (!is_required) {
                    step3.forEach(step3 => {
                        step3.style.display = 'none';
                    });
                    step1.forEach(step1 => {
                        step1.style.display = 'none';
                    });
                    step2.forEach(step2 => {
                        step2.style.display = 'block';
                    });
                    current_step = 2;
                }
                break;
            case 3:
                step1.forEach(step1 => {
                    step1.style.display = 'none';
                });
                step2.forEach(step2 => {
                    step2.style.display = 'none';
                });
                step3.forEach(step3 => {
                    step3.style.display = 'block';
                });
                current_step = 3;
                break;
            default:
                step1.forEach(step1 => {
                    step1.style.display = 'block';
                });
                step2.forEach(step2 => {
                    step2.style.display = 'none';
                });
                step3.forEach(step3 => {
                    step3.style.display = 'none';
                });
                current_step = 1;
                break;
        }

    }

    function next_step() {
        step(current_step + 1)
    }

    function previous_step() {
        step(current_step - 1)
    }
</script>

<style>
    body {
        margin: 20px;
    }

    input {
        width: 250px;
        padding: 10px;
        border-radius: 2px;
        border: 1px solid #ccc;
    }

    input::placeholder {
        color: #BBB;
    }
</style>

<div class="col-md-8 col-lg-6 col-xl-5 mx-auto my-10p">
    <div class="card mt-5">
        <div class="card-body">
            <h5 class="card-title text-center mt-4">
			 <img src="{{ url('assets/img/logo.png') }}" alt="{{ setting('app_name') }}" height="50"><br><br>
               				   <input type="hidden" value="<?= csrf_token() ?>" name="_token">
                    <div class="form-group step1"><br><b>Account aanmaken (1/3)</b></div>
							   <input type="hidden" value="<?= csrf_token() ?>" name="_token">
                    <div class="form-group step2"><br><b>Account aanmaken (2/3)</b></div>
							   <input type="hidden" value="<?= csrf_token() ?>" name="_token">
                    <div class="form-group step3"><br><b>Account aanmaken (3/3)</b></div>
			   
            </h5>

            <div class="p-4">
                <!-- @include('auth.social.buttons') -->

                @include('partials/messages')

                <form role="form" action="<?= url('register') ?>" method="post" id="registration-form" autocomplete="off" class="mt-3">
                   
				   <input type="hidden" value="<?= csrf_token() ?>" name="_token">
                    <div class="form-group step3">
					<p style = "font-size:12px">Emailadres: </p>
                        <input onkeyup="username_password()" type="email" name="email" id="email" class="form-control input-solid" placeholder="@lang('Emailadres')" value="{{ old('email') }}">
                    </div>
                    <div class="form-group" style="display: none;">
                        <input type="text" name="username" id="username" class="form-control input-solid" placeholder="@lang('Username')" value="{{ old('username') }}">
                    </div>
                    <div class="form-group step3">
						<p style = "font-size:12px">Wachtwoord: </p>
                        <input type="password" name="password" id="password" class="form-control input-solid" placeholder="@lang('Wachtwoord')">
                    </div>
                    <div class="form-group step3">
					<p style = "font-size:12px">Bevestig wachtwoord: </p>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-solid" placeholder="@lang('Bevestig Wachtwoord')">
                    </div>
                    <div class="form-group step1 enter_contest">
					 <p style = "font-size:12px">Voornaam: </p>
                        <input onkeypress="keypressing(this)" type="text" name="first_name" id="first_name" class="form-control input-solid" placeholder="@lang('Voornaam')" aria-describedby="first_name-error" aria-invalid="false">
                        <span id="first_name-error" class="invalid-feedback">Wat is je voornaam?</span>
                    </div>
                    <div class="form-group step1 enter_contest">
					<p style = "font-size:12px">Achternaam: </p>
                        <input onkeypress="keypressing(this)" type="text" name="last_name" id="last_name" class="form-control input-solid" placeholder="@lang('Achternaam')" aria-describedby="last_name-error" aria-invalid="false">
                        <span id="last_name-error" class="invalid-feedback">Wat is je achternaam?</span>
                    </div>
                    <div class="form-group step1 enter_contest">
					<p style = "font-size:12px">Telefoonnummer: </p>
                        <input onkeypress="keypressing(this)" type="tel" name="phone" id="phone" class="form-control input-solid" placeholder="@lang('Telefoonnummer')" aria-describedby="phone-error" aria-invalid="false">
                        <span id="phone-error" class="invalid-feedback">Telefoonnummer is onjuist.</span>
                    </div>
                    <div class="form-group step1 enter_contest">
					<p style = "font-size:12px">Geboortedatum: </p>
                        <input onchange="keypressing(this)" type="date" name="birthday" id="birthday" class="form-control input-solid" placeholder="@lang('Geboortedatum')" aria-describedby="birthday-error" aria-invalid="false">
                        <span id="birthday-error" class="invalid-feedback">Je moet ten minste 13 jaar oud zijn om te registreren.</span>
                    </div>
                    <div class="form-group step1 enter_contest">
					<p style = "font-size:12px">Gender: </p>
                        <select onchange="keypressing(this)" name="gender" id="gender" class="form-control input-solid" aria-describedby="gender-error" aria-invalid="false">
                            <option value="male">Man</option>
                            <option value="female">Vrouw</option>
                        </select>
                        <span id="gender-error" class="invalid-feedback">Ben je een man of vrouw?</span>
                    </div>
                    <label class="font-weight-normal step2 enter_contest">@lang('Hoeveel mensen hebben volgens jou meegedaan aan deze wedstrijd?')</label>
                    <div class="form-group step2 enter_contest">
                        <input onkeypress="keypressing(this)" type="number" name="" id="" class="form-control input-solid" placeholder="@lang('00000')">
                    </div>

                    @if (setting('tos'))
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="tos" id="tos" value="1" />
                        <label class="custom-control-label font-weight-normal" for="tos">
                            @lang('I accept')
                            <a href="#tos-modal" data-toggle="modal">@lang('Terms of Service')</a>
                        </label>
                    </div>
                    @endif

                    {{-- Only display captcha if it is enabled --}}
                    @if (setting('registration.captcha.enabled'))
                    <div class="form-group my-4">
                        {!! app('captcha')->display() !!}
                    </div>
                    @endif
                    {{-- end captcha --}}

                    <div class="form-group mt-4 step3">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" id="btn-login">
                            @lang('Account aanmaken')
                        </button>
                    </div>
                    <div class="mt-4 step1 step2 enter_contest" onclick="next_step()">
                        <dev class="btn btn-primary btn-lg btn-block">
                            @lang('Volgende')
                        </dev>
                    </div>
                    <div class="mt-4 step2 step3 enter_contest" onclick="previous_step()">
                        <dev class="btn btn-primary btn-lg btn-block">
                            @lang('Teruggaan')
                        </dev>
                    </div>


                </form>
            </div>
        </div>
    </div>

    <!-- <div class="text-center text-muted">
        @if (setting('reg_enabled'))
        @lang('Already have an account?')
        <a class="font-weight-bold" href="">@lang('Login')</a>
        @endif
    </div> -->

</div>

@if (setting('tos'))
<div class="modal fade" id="tos-modal" tabindex="-1" role="dialog" aria-labelledby="tos-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tos-label">@lang('Terms of Service')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('auth.tos')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    @lang('Sluit')
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@stop

@section('scripts')
{!! JsValidator::formRequest('Vanguard\Http\Requests\Auth\RegisterRequest', '#registration-form') !!}
@stop