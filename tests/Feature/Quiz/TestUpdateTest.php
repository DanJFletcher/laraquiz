<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Quiz;
use App\User;


class QuizUpdateTest extends TestCase
{
    /**
     * Update the quiz in storage
     *
     * @return void
     */
    public function testUpdate()
    {
        // Create user and quiz
        $user = factory(User::class)->create();
        $quiz = factory(Quiz::class)->create();

        // Send a quiz to be stored in database
        $response = $this->actingAs($user)->call('PUT', 'quiz/'.$quiz->id,
            array(
                'title' => 'Update Quiz',
                '_token' => csrf_token()
            ));

        $response
            ->assertStatus(302)
            ->assertRedirect('quiz');
            
        $this->assertDatabaseHas('quizzes', ['title' => 'Update Quiz']);
    }
}