<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Quiz;
use App\User;


class QuizCreateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_create_a_quiz()
    {
        // Create user
        $user = factory(User::class)->create();

        // send req to create view as authed user
        $response = $this->actingAs($user)->get('quiz/create');

        $response
            ->assertStatus(200);
    }

    /** @test */
    public function guest_can_not_create_quiz()
    {
        // send req to create view as authed user
        $response = $this->get('quiz/create');

        $response
            ->assertStatus(302)
            ->assertRedirect('login');
    }
}