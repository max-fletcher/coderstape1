<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Company;

class AddAnotherCompanyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    // This command accepts a name and phone as an argument. Phone is an optional argument though
    protected $signature = 'contact:anothercompany';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add another new company';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask('Enter Company Name: ');
        $phone = $this->ask('Enter Company\'s Phone Number: ');

        if($this->confirm( 'Are you ready to insert these values: Name - "'.$name.'" with Phone - "'.$phone.'" ?' )){
          $company = Company::create([
            'name' => $name,
            'phone' => $phone,
          ]);
          // If user selects yes, then the new company is added
          return $this->info('Added: '. $company->name);
        }

        // If the user selects no, then dislay a message and function ends
        return $this->warn('No New Company Was Added');

/*
        $this->info('Added: '. $company->name);
        $this->info('This is an info string');
        $this->warn('This is a warning string');
        $this->error('This is an error message');
*/
    }
}
