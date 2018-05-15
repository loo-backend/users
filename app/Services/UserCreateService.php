<?php


namespace App\Services;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserCreateService
{
    public function create(Request $request)
    {

        $data = $request->all();

        $data['password'] = Hash::make($request->all()['password']);

        if (!$create = User::create($data) ) {
            return false;
        }

        return $create;

    }

}
