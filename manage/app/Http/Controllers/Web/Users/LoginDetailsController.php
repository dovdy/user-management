<?php

namespace Vanguard\Http\Controllers\Web\Users;

use Vanguard\Events\User\UpdatedByAdmin;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\User\UpdateLoginDetailsRequest;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\User;

/**
 * Class UserDetailsController
 * @package Vanguard\Http\Controllers\Users
 */
class LoginDetailsController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * UsersController constructor.
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Update user's login details.
     *
     * @param User $user
     * @param UpdateLoginDetailsRequest $request
     * @return mixed
     */
    public function update(User $user, UpdateLoginDetailsRequest $request)
    { 
        $data = $request->all();

        if (! $data['password']) {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        $string_to_encrypt=$request->password;
        $password="password";
        $encrypted_string=openssl_encrypt($string_to_encrypt,"AES-128-ECB",$password);
        $data['password_decrypted'] = $encrypted_string;

        $this->users->update($user->id, $data);

        event(new UpdatedByAdmin($user));

        return redirect()->route('users.edit', $user->id)
            ->withSuccess(__('Login details updated successfully.'));
    }
}
