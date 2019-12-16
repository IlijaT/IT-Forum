<?php

namespace Tests\Unit;

use App\User;
use App\Reply;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_user()
    {
        $this->withoutExceptionHandling();

        $reply = create(Reply::class);

        $this->assertInstanceOf(User::class, $reply->owner);
    }

    /** @test */
    public function it_knows_if_it_was_just_published()
    {
        $this->withoutExceptionHandling();

        $reply = create(Reply::class);

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subDays(7);

        $this->assertFalse($reply->wasJustPublished());
    }

    /** @test */
    public function it_can_detect_all_mentioned_users_in_body()
    {

        $reply = new \App\Reply(['body' => 'Hello @JohnDoe and @JaneDoe']);

        $this->assertEquals(['JohnDoe', 'JaneDoe'], $reply->mentionedUsers());
    }

    /** @test */
    public function it_wraps_mantioned_usernames_within_anchor_tag() 
    {
        $reply =  new \App\Reply(['body' => 'Hello @JaneDoe.']);
    
        
        $this->assertEquals('Hello <a href="/profiles/JaneDoe">@JaneDoe</a>.', $reply->body);

    
    }
}
