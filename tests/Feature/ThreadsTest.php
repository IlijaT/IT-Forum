<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function a_user_can_view_all_threads()
    {

        $thread = factory('App\Thread')->create();

        $response = $this->get('/threads');

        $response->assertStatus(200);
        $response->assertSee($thread->title);
    }

    /** @test */
    public function a_user_can_see_a_single_thread()
    {
        $this->withoutExceptionHandling();

        $thread = factory('App\Thread')->create();

        $response = $this->get('/threads/' . $thread->id);

        $response->assertStatus(200);
        $response->assertSee($thread->title);
    }
}
