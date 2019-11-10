<?php

namespace Tests\Unit;

use App\User;
use App\Reply;
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
}
