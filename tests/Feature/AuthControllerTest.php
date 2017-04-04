<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthControllerTest extends TestCase
{
  use DatabaseTransactions;

  public function testLogin()
  {
    //Sets
    $data = [
        'username' => 'emtudo',
        'password' => 'emtudo123'
    ];

    $user = $data;
    $user['password'] = bcrypt($user['password']);
    $user['email'] = 'teste@teste.com';

    factory(User::class)->create($user);

    $response = $this->post('auth/login', $data);

    //Asserts
    $response->assertStatus(200);
    /**$response->assertJson([
      'username' => 'emtudo',
    ]);**/
  }

  public function testLoginWithEmail()
  {
    //Sets
    $data = [
        'username' => 'teste@teste.com',
        'password' => 'emtudo123'
    ];

    $user = [
      'username' => 'emtudo',
      'password' => bcrypt($data['password']),
      'email' => 'teste@teste.com'
    ];

    factory(User::class)->create($user);

    $response = $this->post('auth/login', $data);

    //Asserts
    $response->assertStatus(200);
    /**$response->assertJson([
      'username' => 'emtudo',
    ]);**/
  }

  public function testCantLogin()
  {
    //Sets
    $data = [
        'username' => uniqid(),
        'password' => 'teste'
    ];

    $response = $this->post('auth/login', $data);

    //Asserts
    $response->assertStatus(401);


  }

}
