<?php

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
        factory(App\User::class, 10)->create();

        // create default login user for user testing
        $user = new App\User;
        $user->name = "Dan";
        $user->email = 'test@test.com';
        $user->password = bcrypt('123456');
        $user->remember_token = str_random(10);
        $user->save();
    }
}
