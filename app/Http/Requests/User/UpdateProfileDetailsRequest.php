<?php

namespace Dsc\Http\Requests\User;

use Dsc\Http\Requests\Request;
use Dsc\User;

class UpdateProfileDetailsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'birthday' => 'nullable|date',
        ];
    }
}
