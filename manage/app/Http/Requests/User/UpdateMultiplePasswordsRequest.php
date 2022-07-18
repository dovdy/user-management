<?php

namespace Vanguard\Http\Requests\User;

use Vanguard\Http\Requests\Request;
use Vanguard\User;

class UpdateMultiplePasswordsRequest extends Request
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
            'passwords' => 'min:6,',
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
