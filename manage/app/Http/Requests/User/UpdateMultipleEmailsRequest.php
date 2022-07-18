<?php

namespace Vanguard\Http\Requests\User;

use Vanguard\Http\Requests\Request;
use Vanguard\User;

class UpdateMultipleEmailsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->getUserForUpdate();

        return [
            "emails"    => "email|min:3",
        ];
    }

    /**
     * @return \Illuminate\Routing\Route|object|string
     */
    protected function getUserForUpdate()
    {
        return $this->route('user');
    }
}
