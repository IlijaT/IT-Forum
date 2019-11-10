<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_create_new__forum_thread()
    {

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray())
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_new__forum_thread()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(create('App\User'));

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());


        $this->get($thread->path())
            ->assertSee($thread->title);
    }
}
