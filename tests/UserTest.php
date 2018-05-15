<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;


class UserTest extends TestCase
{

    //
    //$hash = Hash::make('secret');
    //
    //$input = 'secret';
    //if(Hash::check($input, $hash)){
    //    // the input matches the secret
    //}

    /**
     * A basic test example.
     *
     * @param \Faker\Generator $faker
     * @return void
     */
    public function testUserCreate()
    {

        $data = [
            'name' => 'Name Example',
            'email' => 'tests@mail.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ];

        $this->post('/users', $data);

        echo $this->response->content() ;


        $this->assertResponseOk();

        $response = (array) json_decode( $this->response->content() );




        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('email', $response);

//        $this->seeInDatabase('users', [
//            'name' => $data['name'],
//            'email' => $data['email']
//        ]);

    }
}
