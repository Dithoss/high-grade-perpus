<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'invoice_number',
        'total_price',
        'paid_amount',
        'change_amount',
        'cashier_id'
    ];

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
