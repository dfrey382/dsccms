<?php

namespace Dsc\Http\Requests\User;

use Dsc\Http\Requests\Request;
use Dsc\User;

class CreateUserRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'email' => 'required|email|unique:users,email',
            'username' => 'nullable|unique:users,username',
            'password' => 'required|min:6|confirmed',
            'birthday' => 'nullable|date',
            'role_id' => 'required|exists:roles,id',
        ];

        if ($this->get('country_id')) {
            $rules += ['country_id' => 'exists:countries,id'];
        }

        return $rules;
    }
}
