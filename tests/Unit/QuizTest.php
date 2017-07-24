<?php

namespace Tests\Unit;

use App\Quiz;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class QuizTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_get_formatted_created_at()
    {
        $quiz = factory(Quiz::class)->create();

        $this->assertTrue($quiz->formattedCreatedAt === 'Jul 24, 2017');
    }
}
