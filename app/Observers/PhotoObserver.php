<?php

namespace App\Observers;

use App\Http\Services\FileService;
use App\Models\Photo;

class PhotoObserver
{
    /**
     * Handle the Photo "created" event.
     */
    public function created(Photo $photo): void
    {
        //
    }

    /**
     * Handle the Photo "updated" event.
     */
    public function updated(Photo $photo): void
    {
        //
    }

    /**
     * Handle the Photo "deleted" event.
     */
    public function deleted(Photo $photo): void
    {
        (new FileService())->delete($photo);
    }

    /**
     * Handle the Photo "restored" event.
     */
    public function restored(Photo $photo): void
    {
        //
    }

    /**
     * Handle the Photo "force deleted" event.
     */
    public function forceDeleted(Photo $photo): void
    {
        //
    }
}
