<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Quiz;
use App\User;


class QuizStoreTest extends TestCase
{
    /**
     * Test store a quiz.
     *
     * @return void
     */
    public function testStore()
    {
        // Create user
        $user = factory(User::class)->create();

        // Send a quiz to be stored in database
        $response = $this->actingAs($user)->call('POST', 'quiz', array(
            'user_id' => $user->id,
            'title' => 'Test Quiz',
            '_token' => csrf_token()
        ));

        // 'Test Quiz' should be in database
        $this->assertDatabaseHas('quizzes', [
            'title' => 'Test Quiz'
        ]);
    }

    /**
     * Test store a quiz if not authed
     *
     * Auth Middleware should redirect to /login
     *
     * @return void
     */
    public function testStoreIfUserNotAuthed()
    {
        // Make sure a user exists
        $user = factory(User::class)->create();

        // Send a quiz to be stored in database
        $response = $this->call('POST', 'quiz', array(
            'user_id' => $user->id,
            'title' => 'Not Authed Quiz',
            '_token' => csrf_token()
        ));

        // Try to query for the attempted quiz
        $quiz = Quiz::where('title', 'Not Authed Quiz')->first();

        // Quiz should not be in database
        $this->assertTrue($quiz === null);

        $response
            ->assertStatus(302)
            ->assertRedirect('login');
    }
}