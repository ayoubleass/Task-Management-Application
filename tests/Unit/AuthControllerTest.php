<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * 
     *
    */ 
    protected $user;
  
    /**
     * Set up the test environment.
     * This method runs before every single test method.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'name' => 'Jane',
            'password' => Hash::make('123456789'),
            'email' => 'jane@example.com'
        ]);
    }

    /**
     * As the namse suggest this method tests if 
     * the register methid  is correctly handling the validation of the email
     */
    public function test_register_email_validation()
    {

        $response = $this->postJson('/api/register', [
                'name'=>'John',
                'email'=> $this->user->email,
                'password'=>'password123',
                'password_confirmation'=>'password123'
        ]);
        $response->assertStatus(422)->assertJsonStructure(['success','errors'=>['email']]);
    }


    public function test_register_password_validation() {
         $response = $this->postJson('/api/register', [
            'name'=>'Jane',
            'email'=>'jane@example.com',
            'password'=> '123',
            'password_confirmation'=>'123'
        ]);
        $response->assertStatus(422)->assertJsonStructure(['success','errors'=>['password']]);
    }


    public function test_register_succes() {
        $response = $this->postJson("/api/register", [
            'name'=>'John',
            'email'=>'john@example.com',
            'password'=>'password123',
            'password_confirmation'=>'password123'
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'user' => ['id', 'name', 'email'],
                    'token'
                ]);
    }


    public function test_login_succes() {
    
        $response = $this->postJson("/api/login", [
            'email' => $this->user->email,
            'password' => '123456789',
        ]);
        

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'user' => ['id', 'name', 'email'],
                    'token'
                ]);
    }


    public function test_login_failed() {

        $response = $this->postJson("/api/login", [
            'email' => $this->user->email,
            'password' => '123456784',
        ]);
        

        $response->assertStatus(401)
                ->assertJson(['message' => 'Invalid credentials']);
    }

}
