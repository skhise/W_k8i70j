<?php

namespace App\Observers;

use App\Models\Service;

class ServiceObserver
{
    /**
     * Handle the Service "created" event.
     */
    public function created(Service $service): void
    {
        //
    }

    /**
     * Handle the Service "updated" event.
     */
    public function updated(Service $service): void
    {
        //
        Service::where('services.id', $service->id)->update(["notification_flag" => 1]);
    }
    public function updating(Service $service): void
    {
        //
        Service::where('services.id', $service->id)->update(["notification_flag" => 1]);
    }

    /**
     * Handle the Service "deleted" event.
     */
    public function deleted(Service $service): void
    {
        //
    }

    /**
     * Handle the Service "restored" event.
     */
    public function restored(Service $service): void
    {
        //
    }

    /**
     * Handle the Service "force deleted" event.
     */
    public function forceDeleted(Service $service): void
    {
        //
    }
}
