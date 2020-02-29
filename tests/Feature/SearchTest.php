<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
   use RefreshDatabase;

    /** @test */
    public function a_user_can_search_threads()
    {
        $this->withoutExceptionHandling();

        $search = 'foobar';

        create('App\Thread', [], 2);
        create('App\Thread', ['body' => "A thread with {$search} term"], 2);

        $results = $this->getJson("/threads/search?q={$search}")->json();

        $this->assertCount(2, $results['data']);
    }
}
