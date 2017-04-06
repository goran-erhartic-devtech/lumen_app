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
//        $users = factory(App\User::class, 10)->create();
        User::create([
            'username' => 'goran',
            'password' => 'pass'
        ]);
    }
}
