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

    /**
     * Show a quiz if quizzes exist
     *
     * @return void
     */
    public function testShowIfQuizzesExist()
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

    /**
     * Show quiz if quizzes don't exist
     *
     * Should return 404 not found if there are no quizzes in database
     *
     * @return void
     */
    public function testShowQuizIfQuizzesDontExist()
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