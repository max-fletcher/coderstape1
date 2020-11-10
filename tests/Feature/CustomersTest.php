<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Customer;

class CustomersTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use  RefreshDatabase;

    protected function setUp(): void{

      parent::setUp();

  //setup method for performing something that is needed before any function is this class is executed
  // e.g if event fake was needed then it would go here
    }

    protected function tearDown(): void{

      parent::tearDown();

  //teardown method for performing something that is needed after any function is this class is executed

    }

     public function test_only_logged_in_users_can_see_detailed_customer_list()
     {
    // If a not logged in user tries to visit(get) the url customers/detailedlist and gets redirected to
    // the login page, assert "true"
         $response = $this->get('/customers/detailedlist')->assertRedirect('/login');

     }

     public function test_authenticated_users_can_see_detailed_customer_list()
     {  // Acting as a logged in user. Needs to import class "User" at top.
        $this->actingAs(factory(User::class)->create());

        // If the route customers/detailedlist can be visited(i.e get), assert "true"
        $response = $this->get('/customers/detailedlist')->assertOk();

     }

     public function test_a_customer_can_be_added_through_form(){

// Seems " Event::fake(); " is no longer needed
// Also, " withoutExceptionHandling() " interferes with intervention image btw

 // Acting as a logged in user. If the create method was empty, every field would have randomized data but
 // since we are passing an e-mail array, it will override that field only. We are doing this since only
 // admins (i.e users with email "admin@admin.test" are allowed to add customers via policies
 // Needs to import class "User" at top.
       $this->actingAs(factory(User::class)->create([
         'email' => 'admin@admin.test',
       ]));

      // testing a post route. It takes 2 parameters, a route and an array/collection as data. Currently,
      // the data we are sending is in a separate function for a user() and it contains some test data.
       $response = $this->post('/customers',$this->data());

      // If 1 customer row is found in database, assert "true". Needs to import class "Customer" at top.
       $this->assertCount(1, Customer::all());
     }

     public function test_a_name_is_required(){

// Seems " Event::fake(); " is no longer needed
// Also, " withoutExceptionHandling() " interferes with intervention image btw

 // Acting as a logged in user. If the create method was empty, every field would have randomized data but
 // since we are passing an e-mail array, it will override that field only. We are doing this since only
 // admins (i.e users with email "admin@admin.test" are allowed to add customers via policies
 // Needs to import class "User" at top.
       $this->actingAs(factory(User::class)->create([
         'email' => 'admin@admin.test',
       ]));

      // testing a post route. It takes 2 parameters, a route and an array/collection as data. Currently,
      // the data we are sending is in a separate function for a user() and it contains some test data.
      // This one is merging data array(in separate function) with name set to an empty string
       $response = $this->post('/customers', array_merge($this->data(),['name' => '']));

      // Generates an assert "true"
       $response->assertSessionHasErrors('name');
      // If 1 customer row is found in database, assert "true". Needs to import class "Customer" at top.
       $this->assertCount(0, Customer::all());
     }

     public function test_an_email_is_required(){

       $this->actingAs(factory(User::class)->create([
         'email' => 'admin@admin.test',
       ]));

      // testing a post route. It takes 2 parameters, a route and an array/collection as data. Currently,
      // the data we are sending is in a separate function for a user() and it contains some test data.
      // This one is merging data array(in separate function) with email set to an empty string
       $response = $this->post('/customers', array_merge($this->data(), ['email' => 'not an email']));

      // Generates an assert "true" if email field is not verified(has errors in session)
       $response->assertSessionHasErrors('email');
      // If 1 customer row is found in database, assert "true". Needs to import class "Customer" at top.
       $this->assertCount(0, Customer::all());
     }

     private function data(){
      return [
               'name' => 'someuser',
               'email' => 'someuser@user.com',
               'active' => '1',
               'company_id' => '1',
             ];
     }

}
