<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function threads_are_accessible()
    {
        $response = $this->get('/threads');

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_browse_threads()
    {
        $thread = factory('App\Thread')->create();
        $response = $this->get('/threads');

        $response->assertSee($thread->title);
    }

    /** @test */
    public function a_user_can_browse_particular_thread()
    {
        $thread = factory('App\Thread')->create();
        $response = $this->get('/threads/'.$thread->id);

        $response->assertSee($thread->title);
        $response->assertSee($thread->body);
    }
}
