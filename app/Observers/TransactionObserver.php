<?php

namespace App\Observers;

use App\Models\Transaction;
use Illuminate\Support\Str;

class TransactionObserver
{
    private function generateReceipt(Transaction $Transaction): string
    {
        $date = now()->format('Ymd'); // integer
        $random = Str::upper(Str::random(6)); // string

        return "TRX-{$date}-{$random}";
    }
    public function creating(Transaction $Transaction)
    {
        if (empty($Transaction->receipt_number)) {
            $Transaction->receipt_number = $this->generateReceipt($Transaction);
        }
    }
}
