<?php

namespace App\Notifications\Transaction;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OverdueNotification extends Notification
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
        $daysOverdue = now()->diffInDays($this->transaction->due_at);
        
        return [
            'type' => 'overdue',
            'title' => 'Pengembalian Terlambat',
            'message' => "Buku \"{$bookName}\" terlambat {$daysOverdue} hari. Segera kembalikan!",
            'transaction_id' => $this->transaction->id,
            'book_name' => $bookName,
            'due_date' => $this->transaction->due_at?->format('d M Y'),
            'days_overdue' => $daysOverdue,
            'icon' => 'fa-exclamation-triangle',
            'icon_color' => 'red',
        ];
    }
}