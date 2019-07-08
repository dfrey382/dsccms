<?php

use Dsc\Role;
use Dsc\Support\Enum\UserStatus;
use Dsc\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('name', 'Admin')->first();

        User::create([
            'first_name' => 'Fredrick',
            'email' => 'fredrickboaz@gmail.com',
            'username' => 'admin',
            'password' => '123456789',
            'avatar' => null,
            'country_id' => null,
            'role_id' => $admin->id,
            'status' => UserStatus::ACTIVE
        ]);
    }
}
