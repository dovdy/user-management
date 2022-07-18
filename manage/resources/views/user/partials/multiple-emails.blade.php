<script>
    function addEmail() {
        var input_elem = "<div class='form-group'><input type='email' class='form-control input-solid' name='emails[]' placeholder='Email' value=''></div>";
        document.getElementById('multiple_emails_list').insertAdjacentHTML('beforeend', input_elem);
    }
</script>

<div class="form-group">
    <label>@lang('Extra Emails')</label>
</div>

<div id="multiple_emails_list">
    @foreach($user->present()->multipleEmalis($user->present()->id) as $key => $multipleEmail) 
    <div class="form-group">
        <input type="email"
            class="form-control input-solid"
            name="emails[]"
            placeholder="@lang('Email')"
            value="{{ $edit ? $multipleEmail->email : '' }}">
    </div>
    @endforeach
</div>

<div class="btn btn-primary mt-2" id="" onclick="addEmail()">
    <i class="fas fa-plus mr-2"></i>
    @lang('Add Email')
</div><br>

@if ($edit)
    <button type="submit" class="btn btn-primary mt-2" id="update-multiple-emails-btn">
        <i class="fa fa-refresh"></i>
        @lang('Update Gegevens')
    </button>
@endif
