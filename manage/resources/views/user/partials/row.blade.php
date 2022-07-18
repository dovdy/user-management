<tr>
    <td style="width: 32px;">
        <a>
            <?php
            if ($user->present()->star == 1) {
                $star = 'assets/img/star1.png';
            } elseif ($user->present()->star == 0) {
                $star = 'assets/img/star0.png';
            }
            ?>
            <img class="star" onclick="star(this)" data-star="{{ $user->present()->star }}" data-user-id="{{ $user->present()->id }}" class="rounded-circle img-responsive" width="40" src="{{ $star }}" alt="{{ $user->present()->name }}">
        </a>
    </td>
    <td style="width: 40px;">
        <a href="{{ route('users.show', $user) }}">
            <img class="rounded-circle img-responsive" width="40" src="{{ $user->present()->avatar }}" alt="{{ $user->present()->name }}">
        </a>
    </td>
    <!-- <td class="align-middle">
        <a href="{{ route('users.show', $user) }}">
            {{ $user->username ?: __('N/A') }}
        </a>
    </td> -->
    <td class="align-middle">{{ $user->first_name . ' ' . $user->last_name }}</td>
    <td class="align-middle"><a href="{{ route('users.show', $user) }}">{{ $user->email }}</a></td>
    <td class="align-middle">{{ $user->phone }}</td>
    <td class="align-middle">{{ $user->created_at->format(config('app.date_format')) }}</td>
    <!-- <td class="align-middle">
        <span class="badge badge-lg badge-{{ $user->present()->labelClass }}">
            {{ trans("app.status.{$user->status}") }}
        </span>
    </td> -->
    <td class="text-center align-middle">
        <div class="dropdown show d-inline-block">
            <a class="btn btn-icon" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-h"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                <a href="{{ route('users.show', $user) }}" class="dropdown-item text-gray-500">
                    <i class="fas fa-eye mr-2"></i>
                    @lang('Bekijk Gebruiker')
                </a>

                <?php
                $password = "password";
                $encrypted_string = $user->password_decrypted;
                $decrypted_string = openssl_decrypt($encrypted_string, "AES-128-ECB", $password);
                ?>

                <a href="" id="email_span" href="{{ route('users.show', $user) }}" class="dropdown-item text-gray-500" onclick="copyEmail(this)" data-email="{{ $user->email }}" data-toggle="modal" data-placement="top" data data-dismiss="modal" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-envelope mr-2"></i>
                    @lang('Kopiëer Emailadres')
                </a>

                <a href="" id="password_span" href="{{ route('users.show', $user) }}" class="dropdown-item text-gray-500" onclick="copyPassword(this)" data-password="{{ $decrypted_string }}" data-toggle="modal" data-placement="top" data data-dismiss="modal" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-key mr-2"></i>
                    @lang('Kopiëer Wachtwoord')
                </a>


                @canBeImpersonated($user)
                <!-- <a href="{{ route('impersonate', $user) }}" class="dropdown-item text-gray-500 impersonate">
                        <i class="fas fa-user-secret mr-2"></i>
                        @lang('Impersonate')
                    </a> -->
                @endCanBeImpersonated

                @if (config('session.driver') == 'database')
              <!--   <a href="{{ route('user.sessions', $user) }}" class="dropdown-item text-gray-500">
                    <i class="fas fa-list mr-2"></i>
                    @lang('User Sessions')
                </a>-->
                @endif
            </div>
        </div>

        <!-- <input type="text" value="Hello World" id="myInput"> -->

        <script>
            function copyPassword(element) {
                var copyText = element.attributes['data-password'].value;
                navigator.clipboard.writeText(copyText);
                swal("Gelukt!", "Wachtwoord is kopiëerd!", "success");
            }
            function copyEmail(element) {
                var copyText = element.attributes['data-email'].value;
                navigator.clipboard.writeText(copyText);
                swal("Gelukt!", "Emailadres is kopiëerd!", "success");
            }
        </script>

        <script>
            function star(element) {

                var ajax_url = 'http://127.0.0.1/pruthuvi/manage/public/users/32/0';


                // console.log(element);
                if (element.attributes['data-star'].value == 1 || element.attributes['data-star'].value == '1') {
                    element.src = 'assets/img/star0.png';
                    element.attributes['data-star'].value = 0;
                    ajax_url = 'http://127.0.0.1/pruthuvi/manage/public/users/' + element.attributes['data-user-id'].value + '/0';
                    doStarAjax(ajax_url);
                    swal("Gelukt!", "Gebruiker is verwijderd uit favorieten.", "success");
                    // alert(0);
                } else if (element.attributes['data-star'].value == 0 || element.attributes['data-star'].value == '0') {
                    element.src = 'assets/img/star1.png';
                    element.attributes['data-star'].value = 1;
                    ajax_url = 'http://127.0.0.1/pruthuvi/manage/public/users/' + element.attributes['data-user-id'].value + '/1';
                    doStarAjax(ajax_url);
                    swal("Gelukt!", "Gebruiker is toegevoegd aan favorieten", "success");
                    // alert(1);
                }
            }

            function doStarAjax(url) {
                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": url,
                    "method": "GET",
                    "headers": {
                        "authorization": "Bearer 840c236e-42f0-4064-9d41-8426a12591d0",
                        "content-type": "application/json",
                        "cache-control": "no-cache",
                        "postman-token": "bd8d1db6-7b37-d9d4-bf28-67fff611b7cb"
                    }
                }

                $.ajax(settings).done(function(response) {
                    // console.log(url);
                    // console.log(response);
                    return response;
                });
            }

            function starSwitch(element) {
                var starValue = element.attributes['data-star'].value;
                var url = new URL(window.location.href);
                var search_params = url.searchParams;
                if (starValue == 1) {
                    search_params.set('star', 0);
                } else if (starValue == 0) {
                    search_params.set('star', 1);
                    search_params.set('page', 1);
                }    
                // search_params.set('star', starValue);
                url.search = search_params.toString();
                var new_url = url.toString();
                window.location.href = new_url;
            }

            // function addStar(element) {
            //     swal("Success!", "Password has been copied to clipboard!", "success");
            // }

            // function removeStar(element) {
            //     swal("Success!", "Password has been copied to clipboard!", "success");

            // }

            document.addEventListener("DOMContentLoaded", function(event) {
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                const starValue = urlParams.get('star');

                if (starValue && starValue == 1) {
                    document.querySelector('#starSwitchId').src = 'assets/img/star1.png';
                    document.querySelector('#starSwitchId').attributes['data-star'].value = '1';
                } else {
                    document.querySelector('#starSwitchId').src = 'assets/img/star0.png';
                    document.querySelector('#starSwitchId').attributes['data-star'].value = '0';
                }
            });
        </script>

        <a href="{{ route('users.edit', $user) }}" class="btn btn-icon edit" title="@lang('Edit User')" data-toggle="tooltip" data-placement="top">
            <i class="fas fa-edit"></i>
        </a>

        <a href="{{ route('users.destroy', $user) }}" class="btn btn-icon" title="@lang('Delete User')" data-toggle="tooltip" data-placement="top" data-method="DELETE" data-confirm-title="@lang('Bevestig')" data-confirm-text="@lang('Weet je zeker dat je wilt verwijderen?')" data-confirm-delete="@lang('Ja, verwijder.')">
            <i class="fas fa-trash"></i>
        </a>
    </td>
</tr>