<?php

namespace App\Notifications\Transaction;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DueTodayNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Transaction $transaction
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $bookName = $this->transaction->items->first()?->book?->name ?? 'Buku';
        
        return [
            'type' => 'due_today',
            'title' => 'Pengembalian Jatuh Tempo Hari Ini',
            'message' => "Buku \"{$bookName}\" harus dikembalikan hari ini.",
            'transaction_id' => $this->transaction->id,
            'book_name' => $bookName,
            'due_date' => $this->transaction->due_at?->format('d M Y'),
            'icon' => 'fa-exclamation-circle',
            'icon_color' => 'orange',
        ];
    }
}