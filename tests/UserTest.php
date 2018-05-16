<?php

use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class UserTest extends TestCase
{

    public $data = [];

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        Schema::connection('mongodb')->drop('users');
        Artisan::call('migrate');

        $this->data = [
            'name' => str_random(10),
            'email' => str_random(6) . '@mail.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

    }

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

    public function testUpdateUserNoPassword()
    {
        $user = User::first();

        $data = [
            'name' => str_random(12),
            'email' => str_random(6) . '@mail.com'
        ];

        $this->put('/users/'. $user->id, $data);
        $this->assertResponseOk();

        $response = (array) json_decode($this->response->content());

        $this->assertArrayHasKey('_id',$response);
        $this->assertArrayHasKey('name',$response);
        $this->assertArrayHasKey('email',$response);
        $this->assertArrayHasKey('roles',$response);

        $this->notSeeInDatabase('users',[
            'name' => $user->name,
            'email' => $user->email,
            '_id' => $user->id
        ]);

    }

    public function testUpdateUserWithPassword()
    {
        $user = \App\User::first();
        $data = [
            'name' => str_random(12),
            'email' => str_random(6) . '@mail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ];

        $this->put('/users/' . $user->id, $data);
        $this->assertResponseOk();

        $response = (array)json_decode($this->response->content());

        $this->assertArrayHasKey('_id',$response);
        $this->assertArrayHasKey('name',$response);
        $this->assertArrayHasKey('email',$response);
        $this->assertArrayHasKey('roles',$response);

        $this->notSeeInDatabase('users', [
            'name' => $user->name,
            'email' => $user->email,
            'id' => $user->id
        ]);

    }

    public function testDeleteUser()
    {
        $user = User::first();

        $this->delete('/users/'.$user->id);
        $this->assertResponseOk();

        $this->seeJsonEquals([
            'response' => 'user_removed'
        ]);
    }

}
