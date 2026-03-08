<?php

namespace App\Listeners;

use App\Events\ExpiringPartnershipsEvent;
use App\Mail\ExpiringPartnershipAlert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendExpiringPartnershipsAlerts
{
    public function handle(ExpiringPartnershipsEvent $event): void
    {
        foreach ($event->partners as $partner) {
            Mail::to(config('settings.secretary_email'))->queue(new ExpiringPartnershipAlert($partner));

            $partner->last_alert_sent_at = Carbon::now()->format('Y-m-d');
            $partner->save();
        }
    }
}
