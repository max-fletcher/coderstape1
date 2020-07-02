<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Company;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('contact:company-clean', function () {
  // Finds companies that have no customers
  Company::whereDoesntHave('customer')->get()
  // For each of the companies, run a closuer (we a have a list of empty companies
  // from the last line). Inside the closure, delete each of the company that is empty. Same as foreach but
  // for collection objects
  ->each(function($company){
    $company->delete();
    $this->warn('Deleted Company: ' . $company->name);
  });
})->describe('Clean Up Unused Companies');
