<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Quiz;
use App\User;


class QuizTest extends TestCase
{

    /**
     * Test index if authed
     *
     * Display a list of quizzes if user is authenticated
     *
     * @return void
     */
    public function testIndexIfAuthed()
    {
        // Create user
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->call('GET', 'quiz');
        
        $response
            ->assertStatus(200)
            ->assertViewHas('quizzes');
    }

    /**
     * Test index if not authed
     * 
     * Redirect to login if user is not authenticated
     *
     * @return void
     */
    public function testIndexIfNotAuthed()
    {
        $response = $this->get('quiz');

        $response
            ->assertStatus(302)

            // If not authed users should be redirected to /login
            ->assertRedirect('login');
    }

    /**
     * Test index no quizzes
     * 
     * Not sure
     *
     * @return void
     */
    public function testIndexIfNoQuizzes()
    {
        // Create authed user
        $user = factory(User::class)->create();

        // Clear DB of quizzes
        $quizzes = Quiz::all();
        $quizzes->each->delete();

        // we shouldn't see any quizzes in the database
        $this->assertTrue(count(Quiz::all()) === 0);

        // no quizzes in database but we should still
        // be able to reach the view
        $response = $this->actingAs($user)->get('quiz');

        $response
            ->assertStatus(200)

            // The view should still have a quizzes collection
            ->assertViewHas('quizzes');
    }

    /**
     * Store a quiz.
     *
     * @return void
     */
    public function testStore()
    {
        // Create user
        $user = factory(User::class)->create();

        // Send a quiz to be stored in database
        $response = $this->actingAs($user)->call('POST', 'quiz', array(
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
     * Show form for creating new quiz
     * 
     * @return void
     */
    public function testCreate() 
    {
        // Create user
        $user = factory(User::class)->create();

        // send req to create view as authed user
        $response = $this->actingAs($user)->get('quiz/create');

        $response
            ->assertStatus(200);
    }

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

    /**
     * Remove a quiz from storage
     *
     * @return void
     */
    public function testDestroy()
    {
         // Create user and quiz
        $user = factory(User::class)->create();
        $quiz = factory(Quiz::class)->create();

        // dd($quiz);

        $this->assertDatabaseHas('quizzes', ['id' => $quiz->id]);

        $response = $this->actingAs($user)->delete('quiz/' . $quiz->id);

        $response
            ->assertStatus(302)
            ->assertRedirect('quiz')
            ->assertSessionHas('message', 'Successfully deleted quiz!');
    }
}
