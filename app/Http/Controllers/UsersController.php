<?php

namespace App\Http\Controllers;

use App\Services\UserCreateService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     *
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param UserCreateService $service
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function store(Request $request, UserCreateService $service)
    {



        $this->validate($request,[
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|confirmed|max:255'
        ]);


        if (!$result = $service->create($request)) {

            return new Response(['error' => 'user_not_created'], 500);
        }

        return new Response($result,200);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
