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
    use DatabaseMigrations;

    /** @test */
    public function user_can_delete_a_quiz()
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