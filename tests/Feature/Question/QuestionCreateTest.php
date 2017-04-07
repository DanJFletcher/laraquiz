<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Quiz;
use App\User;

class QuestionCreateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_view_create_test_page()
    {
        // Create authed user
        $user = factory(User::class)->create();

        // Create quiz to add question to
        $quiz = factory(\App\Quiz::class)->create();

        $response = $this->actingAs($user)->get("question/create?id={$quiz->id}");

        $data = $response->getOriginalContent()->getData();

        $response
            ->assertStatus(200)

            // The view should have an id
            ->assertViewHas('id');

            // And it should match the current quiz id
            $this->assertTrue($data['id'] == $quiz->id);
    }
}