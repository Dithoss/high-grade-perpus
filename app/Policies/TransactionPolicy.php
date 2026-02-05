<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TransactionPolicy
{
   public function create(User $user): bool
    {
        return !$this->hasActiveFine($user);
    }

    protected function hasActiveFine(User $user): bool
    {
        return $user->transactions()
            ->whereHas('fine', function ($q) {
                $q->whereIn('status', ['unpaid', 'pending_confirmation']);
            })
            ->exists();
    }
 public function extend(User $user, Transaction $transaction): bool
    {
        if ($transaction->user_id !== $user->id) {
            return false;
        }

        if ($transaction->status !== 'borrowed') {
            return false;
        }

        if ($transaction->is_extended) {
            return false;
        }

        if ($transaction->extension_requested_at !== null && $transaction->extension_approved_at === null) {
            return false;
        }

        if (now()->gt($transaction->due_at)) {
            return false;
        }

        return true;
    }


    public function approveExtension(User $user, Transaction $transaction): bool
    {
        if (!$user->hasRole('admin')) {
            return false;
        }

        if ($transaction->extension_requested_at === null) {
            return false;
        }

        if ($transaction->extension_approved_at !== null) {
            return false;
        }

        return true;
    }

}
