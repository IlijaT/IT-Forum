<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LockThreadTest extends TestCase
{
   use RefreshDatabase;

    /** @test */
    public function non_administrators_cannot_lock_threads() 
    {

        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread))
            ->assertStatus(403);

        $this->assertFalse(!! $thread->fresh()->locked);
    
    }

    /** @test */
    public function administrators_can_lock_threads() 
    {

        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread))
            ->assertStatus(200);

        $this->assertTrue(!! $thread->fresh()->locked, 'FAiled asserting that thread is locked!');
    
    }
    

   /** @test */
   public function once_locked_a_thread_cannot_receive_replies() 
   {
        $this->signIn();

        $thread = create('App\Thread');

        $thread->lock();

        $this->post($thread->path() . '/replies', [
            'body' => 'Foobar',
            'user_id' => auth()->id()
            ])
            ->assertStatus(422);
   
   }
}
