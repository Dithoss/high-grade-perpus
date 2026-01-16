<?
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Transaction extends Model
{
    use HasFactory, Notifiable, HasUuids;

    protected $fillable = [
        'product_id',
        'qty',
        'price',
        'subtotal'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
