<?php

namespace App\Http\Controllers;

use App\Services\UserAllService;
use App\Services\UserCreateService;
use App\Services\UserFindService;
use App\Validators\UserCreateTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsersController extends Controller
{

    use UserCreateTrait;


    /**
     * @var UserCreateService
     */
    private $createService;
    /**
     * @var UserFindService
     */
    private $userFindService;
    /**
     * @var UserAllService
     */
    private $userAllService;

    /**
     * UsersController constructor.
     * @param UserCreateService $createService
     * @param UserFindService $userFindService
     * @param UserAllService $userAllService
     */
    public function __construct(UserCreateService $createService,
                                UserFindService $userFindService,
                                UserAllService $userAllService)
    {

        $this->createService = $createService;
        $this->userFindService = $userFindService;
        $this->userAllService = $userAllService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {


        if (!$result = $this->userAllService->all()) {

            return response()->json(['error' => 'users_not_found'], 422);
        }

        return response()->json($result,200);


    }


    /**
     *
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|Response
     * @throws \Exception
     */
    public function store(Request $request)
    {

        $this->validateCreate($request);

        if (!$result = $this->createService->create($request)) {

            return response()->json(['error' => 'user_not_created'], 500);
        }

        return response()->json($result,200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return bool
     * @throws \Exception
     */
    public function show($id)
    {

        if (!$result = $this->userFindService->findBy($id)) {

            return response()->json(['error' => 'user_not_found'], 422);
        }

        return response()->json($result,200);

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
