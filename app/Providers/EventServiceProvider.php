<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\NewCustomerHasRegisteredEvent;
use App\Listeners\WelcomeNewCustomerListener;
use App\Listeners\RegisterCustomerToNewsletter;
use App\Listeners\NotifyAdminViaSlack;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewCustomerHasRegisteredEvent::class => [
            WelcomeNewCustomerListener::class,
            RegisterCustomerToNewsletter::class,
            NotifyAdminViaSlack::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
