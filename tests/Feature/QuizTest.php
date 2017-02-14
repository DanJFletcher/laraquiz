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
        // Create and store a new quiz
        $quiz = factory(Quiz::class)->create();

        // Assert that the new quiz exists
        $this->assertDatabaseHas('quizzes', ['id' => $quiz->id]);

        // Call the show route
        $response = $this->call('GET', 'quiz/'.$quiz->id);

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
     * Remove a quiz from storage
     *
     * @return void
     */
    public function testDestroy()
    {   
        $quiz = factory(Quiz::class)->create();

        // dd($quiz);

        $this->assertDatabaseHas('quizzes', ['id' => $quiz->id]);

        $response = $this->delete('quiz/' . $quiz->id);

        $response
            ->assertStatus(302)
            ->assertRedirect('quiz')
            ->assertSessionHas('message', 'Successfully deleted quiz!');
    }
}
