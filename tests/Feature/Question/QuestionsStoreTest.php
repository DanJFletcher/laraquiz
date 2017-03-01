<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Quiz;
use App\User;

class QuestionStoreTest extends TestCase
{
    /**
     * Test storing a question
     *
     * @return void
     */
    public function testStore()
    {
        // create authed user
        $user = factory(User::class)->create();

        // create a quiz for the question to belong to
        $quiz = factory(Quiz::class)->create();

        // create a fake question belonging to the new quiz
        $question = [
            'quiz_id' => $quiz->id,
            'text' => 'Test question',
            'answer' => 'A'
        ];

        $response = $this->actingAs($user)->post('question', $question);

        $response
            ->assertStatus(302)
            ->assertRedirect("quiz/{$quiz->id}");

        // 'Test question' should be in database
        $this->assertDatabaseHas('questions', [
            'text' => 'Test question'
        ]);
    }
}