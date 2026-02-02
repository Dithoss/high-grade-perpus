<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Algorithm extends Model
{
    protected $table = 'algorithms';

    protected $fillable = [
        'user_id',
        'book_id',
        'action',    
        'created_at',
    ];

    public $timestamps = false;

    protected $keyType = 'string';
}
