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

    /** @test */
    public function user_can_view_their_quizzes()
    {
        // Create user
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->call('GET', 'quiz');

        $response
            ->assertStatus(200)
            ->assertViewHas('quizzes');
    }

    /** @test */
    public function guest_can_not_view_quizzes()
    {
        $response = $this->get('quiz');

        $response
            ->assertStatus(302)

            // If not authed users should be redirected to /login
            ->assertRedirect('login');
    }

    /** @test */
    public function user_can_view_quizzes_page_when_there_are_no_quizzes()
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