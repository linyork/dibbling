<?php

namespace Tests\Feature;

use Illuminate\Foundation\Auth\User;
use Tests\TestCase;

class RouteTest extends TestCase
{
    public function testHome()
    {
        $response = $this->get('/');
        $response->assertStatus(302)
            ->assertLocation( 'dibbling');
    }

    public function testPlayer()
    {
        $response = $this->get('player');
        $response->assertStatus(200)
            ->assertSee('Interface')
            ->assertSee('廣播系統')
            ->assertSee('v2.0');
    }

    public function testDibblingWithoutAuth()
    {
        $response = $this->get('dibbling');
        $response->assertStatus(302);
    }

//    public function testDibblingWithNormalAuth()
//    {
//        $user = User::factory()->create();
//        $response = $this->actingAs($user)
//            ->withSession(['banned' => false])
//            ->get('dibbling');
//        $response->assertStatus(200);
//    }
}
