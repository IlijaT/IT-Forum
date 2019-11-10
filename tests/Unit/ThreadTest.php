<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }

    /** @test */
    public function it_has_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }


    /** @test */
    public function it_has_replies()
    {
        factory(Reply::class, 3)->create(['thread_id' => $this->thread->id]);

        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test */
    public function it_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function it_belongs_to_a_channel()
    {
        $this->withoutExceptionHandling();

        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel', $thread->channel);
    }
}
