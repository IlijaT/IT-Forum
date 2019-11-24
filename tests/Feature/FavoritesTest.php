<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoritesTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_favorite_anything()
    {
        $this->post("/replies/1/favorites")
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {

        $this->signIn();

        $reply = create('App\Reply');

        $this->post("/replies/{$reply->id}/favorites");

        $this->assertCount(1, $reply->favorites);
    }



    /** @test */
    public function an_authenticated_user_can_unfavorite_any_reply()
    {

        $this->withoutExceptionHandling();

        $this->signIn();

        $reply = create('App\Reply');

        $reply->favorite();

        $this->assertCount(1, $reply->favorites);

        $this->delete("/replies/{$reply->id}/favorites");

        $this->assertCount(0, $reply->fresh()->favorites);
    }

    /** @test */
    public function an_authenticated_user_may_favorite_a_reply_only_once()
    {

        $this->withoutExceptionHandling();

        $this->signIn();

        $reply = create('App\Reply');

        try {
            $this->post("/replies/{$reply->id}/favorites");
            $this->post("/replies/{$reply->id}/favorites");
        } catch (\Exception $e) {
            $this->fail('Did not expect to be able to favorite same reply twice!');
        }



        $this->assertCount(1, $reply->fresh()->favorites);
    }
}
