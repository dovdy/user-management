<div class="card">
    <h6 class="card-header">Export Settings</h6>
    <div class="card-body">
        <!-- <form method="GET" action="http://127.0.0.1/pruthuvi/manage/public/users/export/0" accept-charset="UTF-8" id="auth-general-settings-form"><input name="_token" type="hidden" value="fPK0pNVLa7BOPifIm1VSbST6lpvp069vSDRJqZdL"> -->
        <div class="form-group mb-4">
            <div class="d-flex align-items-center">
                 <div class="switch" id="switch-all_users-name" onclick="checking('switch-all_users-name')" style="border: 2px solid #00000021; border-radius: 18px">
                     <!-- <input type="hidden" value="0" name="all_users"> -->
                     <input class="switch" id="switch-all_users" checked="checked" name="all_users" type="checkbox" value="1">
                     <label for="switch-all_users"></label>
                 </div>
                <div class="ml-3 d-flex flex-column">
                    <label class="mb-0">Iedereen</label>
                </div>
            </div>
        </div>
        <div class="form-group my-4">
            <div class="d-flex align-items-center">
                <div class="switch" id="switch-favorites-name" onclick="checking('switch-favorites-name')" style="border: 2px solid #00000021; border-radius: 18px">
                    <!-- <input type="hidden" value="0" name="favorites"> -->
                    <input class="switch" id="switch-favorites" name="favorites" type="checkbox" value="1">
                    <label for="switch-favorites"></label>
                </div>
                <div class="ml-3 d-flex flex-column">
                    <label class="mb-0">Favorieten</label>
                </div>
            </div>
        </div>
        <a href="users/doexport/0?star=0" id="doExport" class="btn btn-primary">Export</a>
        <!-- </form> -->
        <!-- <a href="users/doexport/0?username=1&email=1&password=1">asdas</a> -->
    </div>
</div>

<script>
    function checking(element) {
        if (element == "switch-favorites-name") {
            document.querySelector("#switch-all_users").checked = false;
            document.querySelector("#switch-favorites").checked = true;
            document.querySelector("#doExport").href = 'users/doexport/1?star=1';
        } else if (element == "switch-all_users-name") {
            document.querySelector("#switch-favorites").checked = false;
            document.querySelector("#switch-all_users").checked = true;
            document.querySelector("#doExport").href = 'users/doexport/0?star=0';
        }
    }
</script>