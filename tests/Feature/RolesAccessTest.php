<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RolesAccessTest extends TestCase
{
//    /** @test */
//    public function user_must_login_to_access_to_admin_dashboard()
//    {
//        $this->get(route('admin.dashboard'))
//            ->assertRedirect('login');
//    }
//
//    /** @test */
//    public function admin_can_access_to_admin_dashboard()
//    {
//        //Having
//        $adminUser = factory(User::class)->create();
//
//        $adminUser->assignRole('admin');
//
//        $this->actingAs($adminUser);
//
//        //When
//        $response = $this->get(route('admin.dashboard'));
//
//        //Then
//        $response->assertOk();
//    }
//
//    /** @test */
//    public function users_cannot_access_to_admin_dashboard()
//    {
//        //Having
//        $user = factory(User::class)->create();
//
//        $user->assignRole('user');
//
//        $this->actingAs($user);
//
//        //When
//        $response = $this->get(route('payment'));
//
//        //Then
//        $response->assertForbidden();
//    }
//
//    /** @test */
//    public function user_can_access_to_home()
//    {
//        //Having
//        $user = factory(User::class)->create();
//
//        $user->assignRole('user');
//
//        $this->actingAs($user);
//
//        //When
//        $response = $this->get(route('admin.dashboard'));
//
//        //Then
//        $response->assertOk();
//    }
//
//    /** @test */
//    public function admin_can_access_to_home()
//    {
//        //Having
//        $adminUser = factory(User::class)->create();
//
//        $adminUser->assignRole('admin');
//
//        $this->actingAs($adminUser);
//
//        //When
//        $response = $this->get(route('payment'));
//
//        //Then
//        $response->assertOk();
//    }
}