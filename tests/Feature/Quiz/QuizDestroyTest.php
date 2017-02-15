<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Quiz;
use App\User;


class QuizDestroyTest extends TestCase
{
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