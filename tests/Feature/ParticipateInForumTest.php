<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_user_can_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads/some-channel/1/replies', []);
    }

    /** @test */
    public function an_authenticated_user_can_participate_in_forum_threads()
    {
        $this->signIn();
        $thread = create(\App\Thread::class);
        $reply = make(\App\Reply::class);

        $this->post($thread->path().'/replies', $reply->toArray());
        $this->get($thread->path())->assertSee($reply->body);
    }

    /** @test */
    public function guests_cannot_delete_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $reply = create(\App\Reply::class);

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');
    }

    /** @test */
    public function unauthorized_users_cannot_delete_replies()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $reply = create(\App\Reply::class);

        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_replies()
    {
        $user = create(\App\User::class);
        $reply = create(\App\Reply::class, ['user_id' => $user->id]);

        $this->signIn($user)
            ->delete("/replies/{$reply->id}")
            ->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
}
