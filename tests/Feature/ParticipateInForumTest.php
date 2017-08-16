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
        $this->be($user = factory(\App\User::class)->create());
        $thread = factory(\App\Thread::class)->create();
        $reply = factory(\App\Reply::class)->make();

        $this->post('/threads/'.$thread->id.'/replies', $reply->toArray());
        $this->get($thread->path())->assertSee($reply->body);
    }
}
