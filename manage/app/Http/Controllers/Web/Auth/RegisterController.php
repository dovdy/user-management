<?php

namespace Vanguard\Http\Controllers\Web\Auth;

use Illuminate\Auth\Events\Registered;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\Auth\RegisterRequest;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Support\Enum\UserStatus;

class RegisterController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * Create a new authentication controller instance.
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->middleware('registration')->only('show', 'register');

        $this->users = $users;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('auth.register', [
            'socialProviders' => config('auth.social.providers')
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param RegisterRequest $request
     * @param RoleRepository $roles
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request, RoleRepository $roles)
    {

        $string_to_encrypt=$request->password;
        $password="password";
        $encrypted_string=openssl_encrypt($string_to_encrypt,"AES-128-ECB",$password);

        $user = $this->users->create(
            array_merge($request->validFormData(), ['role_id' => $roles->findByName('User')->id, 'password_decrypted' => $encrypted_string ])
        );

        // echo $request->password;

        event(new Registered($user));

        $message = setting('reg_email_confirmation')
            ? __('Your account is created successfully! Please confirm your email.')
            : __('Your account is created successfully!');

        \Auth::login($user);

        return redirect('../../?status=success')->with('success', $message);
    }
}
