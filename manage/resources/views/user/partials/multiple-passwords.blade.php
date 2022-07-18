<script>
    function addPassword() {
        var input_elem = "<div class='form-group'><input type='text' class='form-control input-solid' name='passwords[]' placeholder='Password' value=''></div>";
        document.getElementById('multiple_passwords_list').insertAdjacentHTML('beforeend', input_elem);
    }
</script>

<div class="form-group">
    <label>@lang('Extra Passwords')</label>
</div>

<div id="multiple_passwords_list">
    @foreach($user->present()->multiplePasswords($user->present()->id) as $key => $multiplePassword) 
    <div class="form-group">
        <input type="text"
            class="form-control input-solid"
            name="passwords[]"
            placeholder="@lang('Password')"
            value="{{ $edit ? $multiplePassword->password : '' }}">
    </div>
    @endforeach
</div>

<div class="btn btn-primary mt-2" id="" onclick="addPassword()">
    <i class="fa fa-refresh"></i>
    @lang('+ Add Password')
</div><br>

@if ($edit)
    <button type="submit" class="btn btn-primary mt-2" id="update-multiple-passwords-btn">
        <i class="fa fa-refresh"></i>
        @lang('Update Gegevens')
    </button>
@endif
