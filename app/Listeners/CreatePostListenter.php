<?php

namespace App\Listeners;

use App\Events\CreatePostEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatePostListenter
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CreatePostEvent  $event
     * @return void
     */
    public function handle(CreatePostEvent $event)
    {
        //
    }
}
