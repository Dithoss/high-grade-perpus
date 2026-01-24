<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fine;
use App\Services\TripayService;
use Illuminate\Http\Request;
class TripayCallbackController extends Controller
{
    public function pay(Request $request, Fine $fine)
    {
        $request->validate([
            'method' => 'required|in:cash,tripay'
        ]);

        if ($request->payment_method === 'cash') {
            $fine->update([
                'payment_method' => 'cash'
            ]);

            return back()->with('success', 'Silakan bayar di perpustakaan.');
        }

        // TRIPAY
        $tripay = app(TripayService::class)->createTransaction($fine);

        $fine->update([
            'payment_method' => 'tripay',
            'payment_reference' => $tripay['reference'],
        ]);

        return redirect($tripay['checkout_url']);
    }
}