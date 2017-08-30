<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManageThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authenticated_user_can_create_threads()
    {
        $this->signIn();
        $thread = make(\App\Thread::class);
        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function guest_can_not_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads', []);
    }

    /** @test */
    public function it_requires_title()
    {
        $this->expectException('Illuminate\Validation\ValidationException');
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function it_requires_body()
    {
        $this->expectException('Illuminate\Validation\ValidationException');
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function it_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->expectException('Illuminate\Validation\ValidationException');

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');
        $this->publishThread(['channel_id' => 9999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function thread_can_be_deleted_along_with_associated_replies()
    {
        $this->signIn();
        $thread = create(\App\Thread::class);
        $reply = create(\App\Reply::class, ['thread_id' => $thread->id]);
        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    public function publishThread($overrides = [])
    {
        $this->signIn();
        $thread = make(\App\Thread::class, $overrides);
        return $this->post('/threads', $thread->toArray());
    }
}
