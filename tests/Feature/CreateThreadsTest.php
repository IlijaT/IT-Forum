<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_create_new__forum_thread()
    {

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray())
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_new__forum_thread()
    {

        $this->signIn();

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());

        $thread = Thread::first();

        $this->get($thread->path())
            ->assertSee($thread->title);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => ''])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => ''])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = [])
    {
        $this->signIn();
        $thread = make('App\Thread', $overrides);
        return $this->post('/threads', $thread->toArray());
    }
}
