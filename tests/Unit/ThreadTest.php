<?php

namespace Tests\Unit;

use App\Notifications\ThreadWasUpdated;
use App\User;
use App\Reply;
use App\Thread;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;

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
    public function it_has_a_path()
    {
        $thread = create('App\Thread');
        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->slug}", $thread->path());
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
    public function it_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        Notification::fake();

        $this->signIn();

        $this->thread->subscribe();

        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => factory('App\User')->create()
        ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    /** @test */
    public function it_belongs_to_a_channel()
    {
        $this->withoutExceptionHandling();
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    /** @test */
    public function a_thread_can_be_subscribed_to()
    {
        $thread = create('App\Thread');
        $thread->subscribe($userId = 1);
        $this->assertEquals(1, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    /** @test */
    public function a_thread_can_be_unsubscribed_from()
    {
        $thread = create('App\Thread');
        $thread->subscribe($userId = 1);
        $thread->unsubscribe($userId);
        $this->assertCount(0, $thread->subscriptions);
    }

    /** @test */
    public function it_knows_if_authenticated_user_is_subscribed_to_it()
    {
        $thread = create('App\Thread');
        $this->signIn();
        $this->assertFalse($thread->isSubscribedTo);
        $thread->subscribe();
        $this->assertTrue($thread->isSubscribedTo);
    }

    /** @test */
    public function a_thread_can_check_if_authenticated_user_has_read_all_replies()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $user = auth()->user();

        $this->assertTrue($thread->hasUpdatesFor($user));

        $user->read($thread);
        //cache()->forever($user->visitedThreadCacheKey($thread), Carbon::now());

        $this->assertFalse($thread->hasUpdatesFor($user));
    }

    /** @test */
    public function a_thread_can_be_locked() 
    {
        
        $this->assertFalse($this->thread->locked);

        $this->thread->lock();

        $this->assertTrue($this->thread->locked);

    
    }
}
