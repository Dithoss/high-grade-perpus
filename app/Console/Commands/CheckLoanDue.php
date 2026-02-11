<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Notifications\Transaction\DueSoonNotification;
use App\Notifications\Transaction\DueTodayNotification;
use App\Notifications\Transaction\OverdueNotification;
use Illuminate\Console\Command;

class CheckLoanDue extends Command
{
    protected $signature = 'library:check-due';
    protected $description = 'Cek jatuh tempo peminjaman buku dan kirim notifikasi';

    public function handle()
    {
        $notificationsSent = [
            'due_soon' => 0,
            'due_today' => 0,
            'overdue' => 0,
        ];

        $transactions = Transaction::whereNull('returned_at')
            ->with(['user', 'items.book'])
            ->get();

        $this->info("📚 Memeriksa {$transactions->count()} transaksi aktif...\n");

        foreach ($transactions as $trx) {
            // Skip jika due_at null
            if (!$trx->due_at) {
                $this->warn("⚠ TRX {$trx->id} dilewati (due_at NULL)");
                continue;
            }

            // Hitung selisih hari
            $today = now()->startOfDay();
            $due   = $trx->due_at->startOfDay();
            $diff  = $today->diffInDays($due, false); // false = bisa negatif

            // Cek apakah sudah ada notifikasi hari ini untuk transaksi ini
            $notificationSentToday = $trx->user->notifications()
                ->whereDate('created_at', $today)
                ->where('data->transaction_id', $trx->id)
                ->exists();

            if ($notificationSentToday) {
                $this->line("ℹ TRX {$trx->id} - Notifikasi sudah dikirim hari ini");
                continue;
            }

            // Kirim notifikasi sesuai kondisi
            match (true) {
                $diff === 3 => $this->sendDueSoonNotification($trx, $notificationsSent),
                $diff === 0 => $this->sendDueTodayNotification($trx, $notificationsSent),
                $diff < 0   => $this->sendOverdueNotification($trx, $notificationsSent),
                default     => null,
            };

            // Update status jadi late jika terlambat
            if ($diff < 0 && $trx->status !== 'late') {
                $trx->update(['status' => 'late']);
                $this->warn("⚠ Status TRX {$trx->id} diubah menjadi 'late'");
            }
        }

        // Tampilkan ringkasan
        $this->newLine();
        $this->info("📊 Ringkasan Notifikasi:");
        $this->table(
            ['Tipe', 'Jumlah'],
            [
                ['Due Soon (3 hari)', $notificationsSent['due_soon']],
                ['Due Today', $notificationsSent['due_today']],
                ['Overdue', $notificationsSent['overdue']],
            ]
        );

        return Command::SUCCESS;
    }

    private function sendDueSoonNotification(Transaction $trx, array &$counter): void
    {
        $bookName = $trx->items->first()?->book?->name ?? 'Buku';
        
        $trx->user->notify(new DueSoonNotification($trx));
        $counter['due_soon']++;
        
        $this->line("✓ Notifikasi 'due_soon' → {$trx->user->name} untuk \"{$bookName}\"");
    }

    private function sendDueTodayNotification(Transaction $trx, array &$counter): void
    {
        $bookName = $trx->items->first()?->book?->name ?? 'Buku';
        
        $trx->user->notify(new DueTodayNotification($trx));
        $counter['due_today']++;
        
        $this->line("✓ Notifikasi 'due_today' → {$trx->user->name} untuk \"{$bookName}\"");
    }

    private function sendOverdueNotification(Transaction $trx, array &$counter): void
    {
        $bookName = $trx->items->first()?->book?->name ?? 'Buku';
        
        $trx->user->notify(new OverdueNotification($trx));
        $counter['overdue']++;
        
        $this->warn("⚠ Notifikasi 'overdue' → {$trx->user->name} untuk \"{$bookName}\"");
    }
}