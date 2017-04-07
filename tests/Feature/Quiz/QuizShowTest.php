<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Quiz;
use App\User;


class QuizShowTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_view_a_quiz_if_it_exists()
    {
        // Create and store a new quiz
        $quiz = factory(Quiz::class)->create();

        // Create user
        $user = factory(User::class)->create();

        // Assert that the new quiz exists
        $this->assertDatabaseHas('quizzes', ['id' => $quiz->id]);

        // Call the show route
        $response = $this->actingAs($user)->call('GET', 'quiz/'.$quiz->id);

        // getData() returns all vars attached to the response.
        // grab the quiz
        $quiz = $response->original->getData()['quiz'];

        // Assert that the response has a Model instance
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $quiz);

        $response
            ->assertStatus(200)
            ->assertViewHas('quiz');
    }

    /** @test */
    public function send_404_if_quiz_does_not_exist()
    {
        // Create authed user
        $user = factory(User::class)->create();

        // Clear DB of quizzes
        $quizzes = Quiz::all();
        $quizzes->each->delete();

        // we shouldn't see any quizzes in the database
        $this->assertTrue(count(Quiz::all()) === 0);

        // Call the show route with id that shouldn't exist
        $response = $this->actingAs($user)->call('GET', 'quiz/1');

        $response
            ->assertStatus(404);
    }
}