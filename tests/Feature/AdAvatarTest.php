<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AdAvatarTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function only_members_can_add_avatars() 
    
    {

        $this->json('POST', 'api/users/1/avatars')
            ->assertStatus(401);
    }

    /** @test */
    public function a_valid_avatar_must_be_provided() 
    
    {
        $this->signIn();

        $this->json('POST', 'api/users/'. auth()->id() .'/avatars', [
            'avatar' => 'not an image'
            ])
            ->assertStatus(422);
    }

    /** @test */
    public function a_user_may_add_an_avatar_to_their_profile() 
    
    {
        Storage::fake('public');

        $this->signIn();

        $this->json('POST', 'api/users/'. auth()->id() .'/avatars', [
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg')
            ]);
            
        $this->assertEquals('avatars/'. $file->hashName(), auth()->user()->avatar_path);

        Storage::disk('public')->assertExists('avatars/'. $file->hashName());            
    
    }
}
