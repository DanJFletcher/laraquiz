<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Quiz;
use App\User;

class QuizIndexTest extends TestCase
{
    use DatabaseMigrations;

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
}