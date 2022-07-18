<?php

namespace Vanguard\Http\Controllers\Web\Users;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Vanguard\Events\User\UpdatedByAdmin;
use Vanguard\Http\Controllers\Api\ApiController;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Services\Upload\UserAvatarManager;
use Vanguard\User;
use Vanguard\Http\Requests\User\UpdateMultiplePasswordsRequest;
use DB;

/**
 * Class StarController
 */
class MultiplePasswords extends ApiController
{
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function update(User $user, Request $request)
    {
        $data = $request->all();

        $currunt_data = DB::table('passwords')
            ->where('user_id', $user->id)
            ->get();
            
        $passwords_index_count = 0;

        foreach ($currunt_data as $key => $value) {
            if ($data['passwords'][$passwords_index_count] == null) {
                $this->deletePassword($value->id);
            } else {
                DB::table('passwords')
                ->where('id', $value->id)
                ->where('user_id', $user->id)
                ->update(['password' => $data['passwords'][$passwords_index_count]]);
            }
            $passwords_index_count++;
        }

        foreach ($data['passwords'] as $key => $value) {
            if ($value != null) {
                if ($key >= $passwords_index_count ) {
                    $this->addPassword($user->id, $value);
                }   
            }
        }

        return redirect()->route('users.edit', $user->id)
            ->withSuccess(__('Extra Passwords updated successfully.'));
    }

    function addPassword($_userId, $_password) {
        return DB::table('passwords')->insert([
            'user_id' => $_userId,
            'password' => $_password
        ]);
    }

    function deletePassword($id) {
        return DB::table('passwords')
            ->where('id', $id)
            ->delete();
    }

}
