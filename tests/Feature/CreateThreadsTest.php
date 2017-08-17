<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authenticated_user_can_create_threads()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);
        $thread = factory(\App\Thread::class)->make();
        $this->post('/threads', $thread->toArray());

        $this->get('/threads')->assertSee($thread->title);
    }

    /** @test */
    public function unauthenticated_user_can_not_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads', []);
    }
}
