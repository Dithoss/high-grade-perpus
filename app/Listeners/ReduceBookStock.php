<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReduceBookStock
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
   public function handle(TransactionCreated $event): void
    {
        $event->transaction->load('items.book');

        foreach ($event->transaction->items as $item) {
            $item->book->decrement('stock', $item->quantity);
        }
    }
}
