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
    use DatabaseMigrations;

    /** @test */
    public function user_can_update_a_quiz_title()
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

    /** @test */
    public function passing_null_as_quiz_title_should_return_with_error()
    {
        // Create user and quiz
        $user = factory(User::class)->create();
        $quiz = factory(Quiz::class)->create();

        // Send a quiz to be stored in database
        $response = $this->actingAs($user)->call('PUT', 'quiz/'.$quiz->id,
            array(
                '_token' => csrf_token()
            ));

        $response
            ->assertStatus(302)
            ->assertSessionHas(['errors']);
    }
}