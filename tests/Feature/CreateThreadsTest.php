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
        $this->actingAs(create(\App\User::class));
        $thread = make(\App\Thread::class);
        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function unauthenticated_user_can_not_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads', []);
    }
}
