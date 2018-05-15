<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Illuminate\Support\Facades\Hash;


//$data['roles'] =    [[
//        'name' => 'CLIENT_ADMIN',
//        'permissions' => [
//            'ALL'
//        ],
//    ],
//        [
//            'name' => 'CLIENT_STAFF',
//            'permissions' => [
//                'CREATE',
//                'READ',
//                'UPDATE',
//            ]
//        ]
//    ];



$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,

    ];
});
