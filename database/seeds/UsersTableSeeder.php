<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::create([
            'first_name'=>'super',
            'last_name'=>'admin',
            'email'=>'super_admin@dev.com',
            'password'=>bcrypt(123456789),
        ]);
        $user->attachRole('super_admin');
    }
}
