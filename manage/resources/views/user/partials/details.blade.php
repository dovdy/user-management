<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="first_name">@lang('Role')</label>
            {!! Form::select('role_id', $roles, $edit ? $user->role->id : '',
            ['class' => 'form-control input-solid', 'id' => 'role_id', $profile ? 'disabled' : '']) !!}
        </div>
        <div class="form-group">
            <label for="status">@lang('Status')</label>
            {!! Form::select('status', $statuses, $edit ? $user->status : '',
            ['class' => 'form-control input-solid', 'id' => 'status', $profile ? 'disabled' : '']) !!}
        </div>
        <div class="form-group">
            <label for="first_name">@lang('Voornaam')</label>
            <input type="text" class="form-control input-solid" id="first_name" name="first_name" placeholder="@lang('Voornaam')" value="{{ $edit ? $user->first_name : '' }}">
        </div>
        <div class="form-group">
            <label for="last_name">@lang('Achternaam')</label>
            <input type="text" class="form-control input-solid" id="last_name" name="last_name" placeholder="@lang('Achternaam')" value="{{ $edit ? $user->last_name : '' }}">
        </div>
        <div class="form-group">
            <label for="gender">@lang('Gender')</label>
            {!! Form::select('gender', ['gender' => '- Gender -', 'male' => 'Man', 'female' => 'vrouw'], $edit ? $user->gender : '', ['class' => 'form-control input-solid', 'id' => 'gender', 'name' => 'gender']) !!}
            <span id="gender-error" class="invalid-feedback">Gender is verplicht.</span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="birthday">@lang('Geboortedatum')</label>
            <div class="form-group">
                <input type="text" name="birthday" id='birthday' value="{{ $edit && $user->birthday ? $user->present()->birthday : '' }}" class="form-control input-solid" />
            </div>
        </div>
        <div class="form-group">
            <label for="phone">@lang('Telefoonnummer')</label>
            <input type="text" class="form-control input-solid" id="phone" name="phone" placeholder="@lang('Phone')" value="{{ $edit ? $user->phone : '' }}">
        </div>

        <div class="form-group">
            <label for="address">@lang('Land')</label>
            {!! Form::select('country_id', $countries, $edit ? $user->country_id : '', ['class' => 'form-control input-solid']) !!}
        </div>
    </div>


    @if ($edit)
    <div class="col-md-12">
        <div class="form-group">
            <label for="note">Nota</label>
            <textarea type="text" class="form-control input-solid" id="note" name="note" placeholder="note" aria-invalid="false" aria-describedby="note-error">{{ $user->note }}</textarea>
            <span id="note-error" class="invalid-feedback" style="display: inline;"></span>
        </div>
    </div>
    <div class="col-md-12 mt-2">
        <button type="submit" class="btn btn-primary" id="update-details-btn">
            <i class="fa fa-refresh"></i>
            @lang('Update Gegevens')
        </button>
    </div>
    @endif
</div>