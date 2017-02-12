<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(OptionSeeder::class);
        $this->call(QuizSeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(UserSeeder::class);
    }
}
