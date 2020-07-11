<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class CustomersTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use  RefreshDatabase;

     public function testOnly_logged_in_users_can_see_detailed_customer_list()
     {

         $response = $this->get('/customers/detailedlist')->assertRedirect('/login');

     }

     public function testAuthenticated_users_can_see_detailed_customer_list()
     {
        $this->actingAs(factory(User::class)->create());

        $response = $this->get('/customers/detailedlist')->assertOk();

     }
}
