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
}