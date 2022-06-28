<?php

namespace Vanguard\Http\Controllers\Web\Users;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Vanguard\Events\User\UpdatedByAdmin;
use Vanguard\Http\Controllers\Api\ApiController;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Services\Upload\UserAvatarManager;
use Vanguard\User;

/**
 * Class StarController
 */
class StarController extends ApiController
{
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function update(User $user, Request $request, $userId, $value)
    {
        if ($value == 1 || $value == 0) {
            $this->users->update($userId, ['star' => $value]);
            $result = array("status"=>"success");
        } else {
            $result = array("status"=>"error");
        }
        return json_encode($result);
    }
}
