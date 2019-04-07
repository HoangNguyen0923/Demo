<?php

use Illuminate\Database\Seeder;
use App\User;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'John';
        $user->email = 'John@example.com';
        $user->password = Hash::make('123456');
        $user->save();
    }
}
