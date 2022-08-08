@extends('layouts.app')

@section('page-title', __('Users'))
@section('page-heading', __('Users'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Users')
    </li>
@stop

@section('content')

@include('partials.messages')

<style>
    svg.w-5 {
        width: 25px;
    }
</style>


<div class="card">
    <div class="card-body">

        <form action="" method="GET" id="users-form" class="pb-2 mb-3 border-bottom-light">
            <div class="row my-3 flex-md-row flex-column-reverse">
                <div class="col-md-2 mt-md-0 mt-2">
                    <div class="input-group custom-search-form">
                        <input type="text"
                               class="form-control input-solid"
                               name="search"
                               value="{{ Request::get('search') }}"
                               placeholder="@lang('Zoek gebruiker')">

                            <span class="input-group-append">
                                @if (Request::has('search') && Request::get('search') != '')
                                    <a href="{{ route('users.index') }}"
                                           class="btn btn-light d-flex align-items-center text-muted"
                                           role="button">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                                <button class="btn btn-light" type="submit" id="search-users-btn">
                                    <i class="fas fa-search text-muted"></i>
                                </button>
                            </span>
                    </div>
                </div>

                <div class="col-md-2 mt-2 mt-md-0">
                    {!!
                        Form::select(
                            'status',
                            $statuses,
                            Request::get('status'),
                            ['id' => 'status', 'class' => 'form-control input-solid']
                        )
                    !!}
                </div>

                <div class="col-md-1 mt-2 mt-md-0">
                <img class="star" id="starSwitchId" onclick="starSwitch(this)" data-star="0" width="32" src="assets/img/star0.png" />
                </div>

                <div class="col-md-1 mt-2 mt-md-0">
                     <!-- <a href="users/export/0?username=1&email=1&password=1" class="btn btn-primary btn-rounded">Exporteren</a>-->
                <!-- <img class="star" id="starSwitchId" onclick="starSwitch(this)" data-star="0" width="32" src="assets/img/star0.png" /> -->
                </div>

                <div class="col-md-6">
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-rounded float-right">
                        <i class="fas fa-plus mr-2"></i>
                        @lang('Nieuwe Gebruiker')
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive" id="users-table-wrapper">
            <table class="table table-borderless table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <!-- <th class="min-width-80">@lang('Gebruikersnaam')</th> -->
                    <th class="min-width-150">@lang('Volledige Naam')</th>
                    <th class="min-width-100">@lang('Emailadres')</th>
                    <th class="min-width-100">@lang('Telefoonnummer')</th>
                    <th class="min-width-80">@lang('Aangemaakt op')</th>
                    <!-- <th class="min-width-80">@lang('Status')</th> -->
                    <th class="text-center min-width-150">@lang('Actie')</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                        $starValue = 0;
                        if (isset($_GET['star'])) {
                            $starValue = $_GET['star'];
                        } 
                    ?>
                    @if (count($users))
                        @foreach ($users as $user)
                            @if ($starValue == 1)
                                @if ($user->star == 1)
                                    @include('user.partials.row')
                                @endif
                            @else
                                @include('user.partials.row')
                            @endif                            
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7"><em>@lang('No records found.')</em></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

{!! $users->render() !!}

@stop

@section('scripts')
    <script>
        $("#status").change(function () {
            $("#users-form").submit();
        });
    </script>
@stop
