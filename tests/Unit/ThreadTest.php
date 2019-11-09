<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_replies()
    {
        $thread = factory(Thread::class)->create();
        $replies = factory(Reply::class, 3)->create(['thread_id' => $thread->id]);

        $this->assertInstanceOf(Collection::class, $thread->replies);
    }
}
