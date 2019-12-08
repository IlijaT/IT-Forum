<?php

namespace Tests\Unit;

use App\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{

    /** @test */
    public function it_detects_a_spam()
    {
        $spam = new Spam;

        $this->assertFalse($spam->detect('Innocent reply'));
    }
}
