@if (!$edit)
<script>
    window.addEventListener('load', function () {
        document.querySelector("#role_id").value = 2;
        document.querySelector("#gender").value = 'female';
        document.getElementsByName("country_id")[0].value = 56;
        document.querySelector("#password").type = 'text';
        document.querySelector("#password_confirmation").type = 'text';
    })
</script>
<style>
    .form_role {
        display: none;
    }
    .form_status {
        display: none;
    }
</style>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="form-group form_role">
            <label for="first_name">@lang('Role')</label>
            {!! Form::select('role_id', $roles, $edit ? $user->role->id : '',
            ['class' => 'form-control input-solid', 'id' => 'role_id', $profile ? 'disabled' : '']) !!}
        </div>
        <div class="form-group form_status">
            <label for="status">@lang('Status')</label>
            {!! Form::select('status', $statuses, $edit ? $user->status : '',
            ['class' => 'form-control input-solid', 'id' => 'status', $profile ? 'disabled' : '']) !!}
        </div>
        <div class="form-group">
            <label for="first_name">@lang('First Name')</label>
            <input type="text" class="form-control input-solid" id="first_name" name="first_name" placeholder="@lang('First Name')" value="{{ $edit ? $user->first_name : '' }}">
        </div>
        <div class="form-group">
            <label for="last_name">@lang('Last Name')</label>
            <input type="text" class="form-control input-solid" id="last_name" name="last_name" placeholder="@lang('Last Name')" value="{{ $edit ? $user->last_name : '' }}">
        </div>
        <div class="form-group">
            <label for="gender">@lang('Gender')</label>
            {!! Form::select('gender', ['gender' => '- Gender -', 'male' => 'Male', 'female' => 'Female'], $edit ? $user->gender : '', ['class' => 'form-control input-solid', 'id' => 'gender', 'name' => 'gender']) !!}
            <span id="gender-error" class="invalid-feedback">The Gender field is required.</span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="birthday">@lang('Date of Birth')</label>
            <div class="form-group">
                <input type="text" name="birthday" id='birthday' value="{{ $edit && $user->birthday ? $user->present()->birthday : '' }}" class="form-control input-solid" />
            </div>
        </div>
        <div class="form-group">
            <label for="phone">@lang('Phone')</label>
            <input type="text" class="form-control input-solid" id="phone" name="phone" placeholder="@lang('Phone')" value="{{ $edit ? $user->phone : '' }}">
        </div>
        <div class="form-group">
            <label for="address">@lang('Address')</label>
            <input type="text" class="form-control input-solid" id="address" name="address" placeholder="@lang('Address')" value="{{ $edit ? $user->address : '' }}">
        </div>
        <div class="form-group">
            <label for="address">@lang('Country')</label>
            {!! Form::select('country_id', $countries, $edit ? $user->country_id : '', ['class' => 'form-control input-solid']) !!}
        </div>
    </div>


    @if ($edit)
    <div class="col-md-12">
        <div class="form-group">
            <label for="note">Note</label>
            <textarea type="text" class="form-control input-solid" id="note" name="note" placeholder="note" aria-invalid="false" aria-describedby="note-error">{{ $user->note }}</textarea>
            <span id="note-error" class="invalid-feedback" style="display: inline;"></span>
        </div>
    </div>
    <div class="col-md-12 mt-2">
        <button type="submit" class="btn btn-primary" id="update-details-btn">
            <i class="fa fa-refresh"></i>
            @lang('Update Details')
        </button>
    </div>
    @endif
</div>