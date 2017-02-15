<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Quiz;
use App\User;


class QuizEditTest extends TestCase
{
    /**
     * Show the form for editing a quiz
     *
     * @return void
     */
    public function testEdit()
    {
         // Create user and quiz
        $user = factory(User::class)->create();
        $quiz = factory(Quiz::class)->create();

        // send req to create view as authed user
        $response = $this->actingAs($user)->get('quiz/' . $quiz->id .'/edit');

        $response
            ->assertStatus(200)
            ->assertViewHas('quiz');
    }
}