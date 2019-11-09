<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function a_user_can_browse_threads()
    {
        $this->withoutExceptionHandling();

        $threads = factory('App\Thread', 10)->create();

        $response = $this->get('/threads');

        $response->assertStatus(200);
        $response->assertViewHas('threads', $threads);
    }
}
