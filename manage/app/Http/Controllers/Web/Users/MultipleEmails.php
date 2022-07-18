<?php

namespace Vanguard\Http\Controllers\Web\Users;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Vanguard\Events\User\UpdatedByAdmin;
use Vanguard\Http\Controllers\Api\ApiController;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Services\Upload\UserAvatarManager;
use Vanguard\User;
use Vanguard\Http\Requests\User\UpdateMultipleEmailsRequest;
use DB;

/**
 * Class StarController
 */
class MultipleEmails extends ApiController
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

        $currunt_data = DB::table('emails')
            ->where('user_id', $user->id)
            ->get();
            
        $emails_index_count = 0;

        foreach ($currunt_data as $key => $value) {
            if ($data['emails'][$emails_index_count] == null) {
                $this->deleteEmail($value->id);
            } else {
                DB::table('emails')
                ->where('id', $value->id)
                ->where('user_id', $user->id)
                ->update(['email' => $data['emails'][$emails_index_count]]);
            }
            $emails_index_count++;
        }

        foreach ($data['emails'] as $key => $value) {
            if ($value != null) {
                if ($key >= $emails_index_count ) {
                    $this->addEmail($user->id, $value);
                }   
            }
        }

        return redirect()->route('users.edit', $user->id)
            ->withSuccess(__('Extra Emails updated successfully.'));
    }

    function addEmail($_userId, $_email) {
        return DB::table('emails')->insert([
            'user_id' => $_userId,
            'email' => $_email
        ]);
    }

    function deleteEmail($id) {
        return DB::table('emails')
            ->where('id', $id)
            ->delete();
    }

}
