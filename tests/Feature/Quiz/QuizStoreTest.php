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
}