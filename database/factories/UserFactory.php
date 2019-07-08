<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Dsc\User::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'password' => bcrypt(Str::random(10)),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'avatar' => null,
        'address' => $faker->address,
        'country_id' => function () use ($faker) {
            return $faker->randomElement(Dsc\Country::pluck('id')->toArray());
        },
        'role_id' => function () {
            return factory(\Dsc\Role::class)->create()->id;
        },
        'status' => Dsc\Support\Enum\UserStatus::ACTIVE,
        'birthday' => $faker->date()
    ];
});
