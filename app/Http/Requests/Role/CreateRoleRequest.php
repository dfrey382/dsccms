<?php

namespace Dsc\Http\Requests\Role;

use Dsc\Http\Requests\Request;

class CreateRoleRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|regex:/^[a-zA-Z0-9\-_\.]+$/|unique:roles,name'
        ];
    }
}
