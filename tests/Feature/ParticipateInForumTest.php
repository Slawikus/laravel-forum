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

        $this->post('/threads/1/replies', []);
    }

    /** @test */
    public function an_authenticated_user_can_participate_in_forum_threads()
    {
        $this->be($user = create(\App\User::class));
        $thread = create(\App\Thread::class);
        $reply = make(\App\Reply::class);

        $this->post('/threads/'.$thread->id.'/replies', $reply->toArray());
        $this->get($thread->path())->assertSee($reply->body);
    }
}
