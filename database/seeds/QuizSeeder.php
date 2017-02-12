<?php

use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the quiz seed.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Quiz::class, 10)->create();
    }
}
