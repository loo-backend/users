<?php

use App\User;
use Illuminate\Support\Facades\Schema;


class UserTest extends TestCase
{

    public $data = [];

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        Schema::connection('mongodb')->drop('users');

        $this->data = [
            'name' => str_random(10),
            'email' => str_random(6) . '@mail.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];


    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCreate()
    {

        $this->post('/users', $this->data);


        $this->assertResponseOk();

        $response = (array) json_decode( $this->response->content() );

        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('email', $response);
        $this->assertArrayHasKey('roles', $response);

        $this->seeInDatabase('users', [
            'name' => $this->data['name'],
            'email' => $this->data['email']
        ]);

    }

    public function testShowUser()
    {
        $user = User::first();

        $this->get('/users/'. $user->id);

        $this->assertResponseOk();
        $response = (array) json_decode($this->response->content());
        $this->assertArrayHasKey('_id',$response);
        $this->assertArrayHasKey('name',$response);
        $this->assertArrayHasKey('email',$response);
        $this->assertArrayHasKey('roles',$response);

        $this->seeJsonStructure([
            '_id',
            'name',
            'email',
            'roles' => [
                '*' => [
                    'name', 'permissions'
                ]
            ]
        ]);

    }

    public function testAllUsers()
    {

        $this->get('/users');
        $this->assertResponseOk();

        $this->seeJsonStructure([
            '*' => [

                '_id',
                'name',
                'email',
                'roles' => [
                    '*' => [
                            'name', 'permissions'
                        ]
                ]

            ]
        ]);


    }

}
