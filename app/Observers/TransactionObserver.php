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
    public function generateUniqueSlug(Transaction $Book): string
    {
        $slug = Str::slug($Book->name);
        $slug .= '-' . date('YmdHis');
        return $slug;
    }
    public function creating(Transaction $Transaction)
    {
        if (empty($Transaction->receipt_number)) {
            $Transaction->receipt_number = $this->generateReceipt($Transaction);
        }
        if (empty($Transaction->slug)) {
            $Transaction->slug = $this->generateUniqueSlug($Transaction);
        }
    }
}
