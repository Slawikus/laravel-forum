<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }

    /** @test */
    public function threads_are_accessible()
    {
        $response = $this->get('/threads');

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_browse_all_threads()
    {
        $response = $this->get('/threads');

        $response->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_browse_particular_thread()
    {
        $response = $this->get('/threads/'.$this->thread->id);

        $response->assertSee($this->thread->title);
        $response->assertSee($this->thread->body);
    }

    /** @test */
    public function a_user_can_read_replies_associated_with_thread()
    {
        $reply = create('App\Reply', ['thread_id' => $this->thread->id]);

        $response = $this->get('/threads/'.$this->thread->id);

        $response->assertSee($reply->body);
    }
}
