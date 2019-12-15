<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_user_cannot_participate_in_forum_threads()
    {

        $this->post('threads/some-chanel/1/replies', [])
            ->assertStatus(302)
            ->assertRedirect('/login');
    }



    /** @test */
    public function an_unauthorised_user_cannot_delete_reply()
    {
        $reply = create('App\Reply');
        $this->delete("/replies/{$reply->id}")->assertRedirect('/login');

        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }


    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => '']);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function authorised_user_can_delete_reply()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")
            ->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }

    /** @test */
    public function an_unauthorised_user_cannot_update_reply()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');
        $this->patch("/replies/{$reply->id}", ['body' => 'Updated reply'])
            ->assertStatus(302)
            ->assertRedirect('/login');

        $this->signIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id, 'body' => 'Updated reply']);
    }

    /** @test */
    public function authorised_user_can_update_reply()
    {

        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->patch("/replies/{$reply->id}", ['body' => 'Updated reply']);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => 'Updated reply']);
    }

    /** @test */
    public function replies_that_contain_spam_may_not_be_created()
    {


        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => 'Yahoo Customer Support']);

        $this->json('POST', $thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
    }

    /** @test */
    public function a_users_may_only_reply_once_in_a_minute()
    {

        $this->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => 'Helloo']);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(201);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(403);
    }
}
