<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Quiz;
use App\User;
use Session;

class QuizTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * Display a list of quizzes
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->call('GET', 'quiz');
        
        $response
            ->assertStatus(200)
            ->assertViewHas('quizzes');
    }

    /**
     * Store a quiz.
     *
     * @return void
     */
    public function testStore()
    {
        // Send a quiz to be stored in database
        $response = $this->call('POST', 'quiz', array(
            'user_id' => 1,
            'title' => 'Test Quiz',
            '_token' => csrf_token()
        ));

        // print($response);

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
    public function testShow()
    {
        $quiz = factory(Quiz::class)->create();

        $this->assertDatabaseHas('quizzes', ['id' => $quiz->id]);

        $response = $this->call('GET', 'quiz/'.$quiz->id, [
            '_token' => csrf_token()
        ]);

        $response
            ->assertStatus(200)
            ->assertViewHas('quiz');
    }

    /**
     * Remove a quiz from storage
     *
     * @return void
     */
    public function testDestroy()
    {   
        $quiz = factory(Quiz::class)->create();

        // dd($quiz);

        $this->assertDatabaseHas('quizzes', ['id' => $quiz->id]);

        $response = $this->delete('quiz/' . $quiz->id, [
            '_token' => csrf_token()
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect('quiz')
            ->assertSessionHas('message', 'Successfully deleted quiz!');
    }
}
