<?php

namespace App\Validators;

use Illuminate\Http\Request;

/**
 * Trait UserCreateTrait
 * @package App\Validators
 */
trait UserCreateTrait
{

    /**
     * Validate data
     *
     * @param Request $request
     */
    public function validateCreate(Request $request)
    {

        $this->validate($request,[
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6|max:255'
        ]);

    }
}
