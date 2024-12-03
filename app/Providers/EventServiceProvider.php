<?php

namespace App\Providers;

use App\Events\CartReminder;
use App\Events\OrderReminder;
use App\Events\TestNotification;
use App\Listeners\NotificationListenerTest;
use App\Listeners\SendCartReminderEmail;
use App\Listeners\SendEmailListener;
use App\Listeners\SendOrderReminderEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $subscribe = [
        SendEmailListener::class,
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
