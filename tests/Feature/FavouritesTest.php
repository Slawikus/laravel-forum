<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavouritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_cannot_favourite_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('replies/1/favourites');

    }

    /** @test */
    public function an_authenticated_user_can_favourite_reply()
    {
        $this->signIn();
        $reply = factory('App\Reply')->create();
        $this->post('replies/'.$reply->id.'/favourites');
        $this->assertCount(1, $reply->favourites);
    }

    /** @test */
    public function an_authenticated_user_can_favourite_reply_only_once()
    {
        $this->signIn();
        $reply = factory('App\Reply')->create();
        $this->post('replies/'.$reply->id.'/favourites');
        $this->post('replies/'.$reply->id.'/favourites');
        $this->assertCount(1, $reply->favourites);
    }
}
