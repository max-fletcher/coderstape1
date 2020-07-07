<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomersTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     public function testOnly_logged_in_user_can_see_detailed_customer_list()
     {

         $response = $this->get('/customers/detailedlist')->assertRedirect('/login');

     }
}
