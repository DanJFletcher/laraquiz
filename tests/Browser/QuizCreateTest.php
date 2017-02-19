<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuizCreateTest extends DuskTestCase
{
    use databaseMigrations;

    /**
     * Should create a quiz
     *
     * @return void
     */
    public function testQuizCreate()
    {
        $user = factory(User::class)->create();

        $this->browse(function ($browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/quiz/create')
                    ->type('title', 'Test Quiz')
                    ->press('Create the Quiz!')
                    ->assertPathIs('/quiz')
                    ->assertSee('Successfully created quiz!');
        });
    }
}
