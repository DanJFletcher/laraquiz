<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use databaseMigrations;

    /**
     * Test login success.
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        $user = factory(User::class)->create([
            'email' => 'dan@laravel.com',
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertPathIs('/quiz')
                    ->click('.dropdown-toggle')
                    ->click('.dropdown-menu a');
        });

        $this->refreshApplication();
    }

    /**
     * Test login wrong credentials.
     *
     * @return void
     */
    public function testLoginWrongEmail()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', 'notAnemail@mail.com')
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertPathIs('/login')
                    ->assertSee(
                        'These credentials do not match our records.'
                        );
        });
    }

    /**
     * Login should fail with wrong password.
     *
     * @return void
     */
    public function testLoginWrongPassword()
    {
        $user = factory(User::class)->create([
            'email' => 'dan@laravel.com',
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'fails')
                    ->press('Login')
                    ->assertPathIs('/login')
                    ->assertSee(
                        'These credentials do not match our records.'
                        );
        });
    }
}
