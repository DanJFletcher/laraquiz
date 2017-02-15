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
     * Test create if authed
     *
     * Show form for creating new quiz if user authed
     * 
     * @return void
     */
    public function testCreateUserIsAuthed() 
    {
        // Create user
        $user = factory(User::class)->create();

        // send req to create view as authed user
        $response = $this->actingAs($user)->get('quiz/create');

        $response
            ->assertStatus(200);
    }

        /**
        * Test create if not authed
        *
        * Return 302 and redirect to /login if user is not authed
        * 
        * @return void
        */
        public function testCreateUserNotAuthed() 
        {
            // send req to create view as authed user
            $response = $this->get('quiz/create');

            $response
                ->assertStatus(302)
                ->assertRedirect('login');
        }
}