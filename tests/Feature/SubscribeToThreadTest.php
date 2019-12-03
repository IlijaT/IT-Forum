<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscribeToThreadTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_user_can_subscribe_to_thread()
    {

        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread');

        $this->post($thread->path() . '/subscriptions');
        $this->assertCount(1, $thread->subscriptions);
    }

    /** @test */
    public function a_user_can_unsubscribe_from_thread()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread');

        $thread->subscribe();

        $this->assertCount(1, $thread->subscriptions);

        $this->delete($thread->path() . '/subscriptions');

        $this->assertCount(0, $thread->fresh()->subscriptions);
    }
}
