<div class="col-md-3">
    <div class="card">
        <div class="card-body">
            <a href="{{ route('profile') }}" class="text-center no-decoration">
                <div class="icon my-3">
                    <i class="fas fa-user fa-2x"></i>
                </div>
                <p class="lead mb-0">@lang('Profiel bijwerken')</p>
            </a>
        </div>
    </div>
</div>

@if (config('session.driver') == 'database')
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('profile.sessions') }}" class="text-center  no-decoration">
                    <div class="icon my-3">
                        <i class="fa fa-list fa-2x"></i>
                    </div>
                    <p class="lead mb-0">@lang('Mijn Sessies')</p>
                </a>
            </div>
        </div>
    </div>
@endif

<div class="col-md-3">
    <div class="card">
        <div class="card-body">
            <a href="{{ route('profile.activity') }}" class="text-center no-decoration">
                <div class="icon my-3">
                    <i class="fas fa-server fa-2x"></i>
                </div>
                <p class="lead mb-0">@lang('Logboek')</p>
            </a>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card">
        <div class="card-body">
            <a href="{{ route('auth.logout') }}" class="text-center no-decoration">
                <div class="icon my-3">
                    <i class="fas fa-sign-out-alt fa-2x"></i>
                </div>
                <p class="lead mb-0">@lang('Uitloggen')</p>
            </a>
        </div>
    </div>
</div>
