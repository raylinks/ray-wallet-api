<?php

namespace Tests\Unit;

use Tests\TestCase;
class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }


    


    public function testRegistration()
    {
        $payload =[
            'firstname' => 'ade'

        ];
        $response = $this->postJson('/api/register/user', ['name' => 'Sally']);
       // $response = $this->json('POST', '//api/register/user', ['name' => 'Sally']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }
}
