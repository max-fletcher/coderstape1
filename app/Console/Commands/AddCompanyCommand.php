<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Company;

class AddCompanyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    // This command accepts a name and phone as an argument. Phone is an optional argument though
    protected $signature = 'contact:company {name} {phone?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new company';

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
      // create a new company. Any argument passed can be accessed using $this->argument() method. It works
      // like a bag (e.g request and session) so you need to say $this->argument('name'). If session has a
      // phone number, then set it, but if not, set default value as N/A.
      // Side note: If you used {phone=N/A} in signature, you wouldn't need to say
      // 'phone' => $this->argument('phone') ?? 'N/A'. Just 'phone' => $this->argument('phone') will do
        $company = Company::create([
          'name' => $this->argument('name'),
          'phone' => $this->argument('phone') ?? 'N/A',
        ]);

        $this->info('Added: '. $company->name);
        $this->info('This is an info string');
        $this->warn('This is a warning string');
        $this->error('This is an error message');
    }
}
