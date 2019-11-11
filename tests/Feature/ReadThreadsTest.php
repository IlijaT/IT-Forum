<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }


    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->withoutExceptionHandling();

        $this->get('/threads')
            ->assertStatus(200)
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_see_a_single_thread()
    {

        $this->get($this->thread->path())
            ->assertStatus(200)
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_associated_with_a_thread()
    {

        $reply = create(Reply::class, ['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {

        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->withoutExceptionHandling();

        $this->signIn(create('App\User', ['name' => 'JohnDoe']));

        $johnsThread = create('App\Thread', ['user_id' => auth()->id()]);
        $otherThread = create('App\Thread');

        $this->get('/threads?by=JohnDoe')
            ->assertSee($johnsThread->title)
            ->assertDontSee($otherThread->title);
    }
}
