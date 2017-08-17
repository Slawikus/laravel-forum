<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadTest extends TestCase
{
    protected $thread;

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->thread = create(\App\Thread::class);
    }

    /** @test */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Collection::class,
            $this->thread->replies
        );
    }

    /** @test */
    public function a_thread_has_creator()
    {
        $this->assertInstanceOf(\App\User::class, $this->thread->creator);
    }

    /** @test */
    public function a_thread_can_add_reply()
    {
        $reply = make(\App\Reply::class, ['user_id' => 1]);

        $this->thread->addReply($reply);
        $this->assertCount(1, $this->thread->replies);
    }
}
