<?php
namespace Tests\Feature; use App\Models\User; use Illuminate\Foundation\Testing\RefreshDatabase; use Tests\TestCase;
class AuthTest extends TestCase { use RefreshDatabase; public function test_login_benar(): void {$u=User::factory()->create(['password'=>'password123']);$this->post('/login',['email'=>$u->email,'password'=>'password123'])->assertRedirect('/dashboard');$this->assertAuthenticated();} public function test_login_salah(): void {$u=User::factory()->create();$this->post('/login',['email'=>$u->email,'password'=>'salah'])->assertSessionHasErrors('email');$this->assertGuest();} }
