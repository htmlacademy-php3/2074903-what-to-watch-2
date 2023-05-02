<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testCanCreateNewUser(): void
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->create('avatar.jpeg');

        $parameters = [
            'name' => 'Example User',
            'email' => 'some@google.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'file' => $file,
        ];

        $this->postJson('/api/register', $parameters)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data'
            ]);

        $newUser = User::whereEmail($parameters['email'])->first();
        $avatar = $newUser->avatar;

        $this->assertNotEmpty($newUser);
        $this->assertNotEmpty($avatar);
    }

    public function testCanUpdateUser(): void
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->create('avatar.jpeg');

        $user = User::factory()
            ->create([
                'user_role_id' => UserRole::whereRole(User::ROLE_DEFAULT)->value('id'),
            ]);

        $userEmail = $user->email;
        $userId = $user->id;

        $parameters = [
            'name' => 'Example User',
            'email' => 'some@google.com',
            'file' => $file,
            '_method' => 'PATCH'
        ];

        $this->actingAs($user)
            ->postJson('/api/user', $parameters)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data'
            ]);

        $updatedUser = User::whereEmail($parameters['email'])->first();
        $avatar = $updatedUser->avatar;

        $this->assertNotEmpty($updatedUser);
        $this->assertEquals($userId, $updatedUser->id);
        $this->assertNotEquals($userEmail, $updatedUser->email);
        $this->assertNotEmpty($avatar);
    }
}
