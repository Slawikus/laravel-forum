<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_thread_has_replies()
    {
        $thread = factory(\App\Thread::class)->create();

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Collection::class,
            $thread->replies
        );
    }

        /** @test */
    public function a_thread_has_creator()
    {
        $thread = factory(\App\Thread::class)->create();

        $this->assertInstanceOf(\App\User::class, $thread->creator);
    }
}
