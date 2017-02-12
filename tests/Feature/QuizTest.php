<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Quiz;

class QuizTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    /**
     * Store a quiz.
     *
     * @return void
     */
    public function testStoreQuizRoute()
    {
        // Send a quiz to be stored in database
        $response = $this->call('POST', 'quiz', array(
            'user_id' => 1,
            'title' => 'Test Quiz',
            '_token' => csrf_token()
        ));

        print($response);

        // response should equal success
        // $this->assertTrue($response, 'success');

        // 'Test Quiz' should be in database
        $this->assertDatabaseHas('quizzes', [
            'title' => 'Test Quiz'
        ]);
    }

    /**
     * Show a quiz.
     *
     * @return void
     */
    public function testShowQuizRoute()
    {
        $quiz = factory(Quiz::class)->create();

        $response = $this->call('GET', '/quiz/', Array('id' => $quiz->id));

        $response
            ->assertStatus(200);
    }
}
