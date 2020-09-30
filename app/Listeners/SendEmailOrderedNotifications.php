<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Ordered;
use App\Mail\OrderedAdminNotification;
use App\Mail\OrderedPurchaserNotification;
use Mail;

class SendEmailOrderedNotifications implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Ordered $event)
    {
        $order = $event->order;
        $admin = env('APP_ADMIN_EMAIL');

        Mail::to($admin)->send(new OrderedAdminNotification($order));
        Mail::to($order->email)->send(new OrderedPurchaserNotification($order));
    }
}
