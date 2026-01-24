<?php

namespace App\Http\Controllers;

use App\Contracts\Interface\FineInterface;
use App\Models\Fine;
use App\Services\TripayService;
use Illuminate\Http\Request;

class FineController extends Controller
{
    public function __construct(
        protected FineInterface $fineRepository
    ) {}

    public function index()
    {
        $fines = $this->fineRepository->getByUser(auth()->id());

        return view('fines.index', compact('fines'));
    }

    public function adminIndex(Request $request)
    {
        $fines = $this->fineRepository->getAll(
            $request->only(['status', 'type'])
        );

        return view('fines.admin.index', compact('fines'));
    }

    public function markPaid(Fine $fine)
    {
        if ($fine->status === 'paid') {
            return back()->with('info', 'Denda sudah lunas.');
        }

        $this->fineRepository->markAsPaid($fine);

        return back()->with('success', 'Denda berhasil ditandai lunas.');
    }

    public function pay(Request $request, Fine $fine)
    {
        if ($fine->transaction->user_id !== auth()->id()) {
            return back()->with('error', 'Anda tidak memiliki akses untuk membayar denda ini.');
        }

        if ($fine->status === 'paid') {
            return back()->with('info', 'Denda sudah lunas.');
        }

        if ($fine->status === 'pending_confirmation') {
            return back()->with('info', 'Pembayaran Anda sedang menunggu konfirmasi admin.');
        }

        $request->validate([
            'payment_method' => 'required|in:cash,tripay'
        ]);

        if ($request->payment_method === 'cash') {
            $fine->update([
                'payment_method' => 'cash',
                'status' => 'pending_confirmation',
                'payment_requested_at' => now(),
            ]);

            return back()->with('success', 'Permintaan pembayaran offline berhasil. Silakan bayar di perpustakaan dan menunggu konfirmasi admin.');
        }

        try {
            $tripayService = app(TripayService::class);
            $tripayResponse = $tripayService->createTransaction($fine);

            $fine->update([
                'payment_method' => 'tripay',
                'payment_reference' => $tripayResponse['reference'] ?? null,
            ]);

            if (isset($tripayResponse['checkout_url'])) {
                return redirect($tripayResponse['checkout_url']);
            }

            return back()->with('error', 'Gagal membuat transaksi pembayaran. Silakan coba lagi.');
            
        } catch (\Exception $e) {
            \Log::error('Tripay Payment Error: ' . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function confirmPayment(Fine $fine)
    {
        if ($fine->status !== 'pending_confirmation') {
            return back()->with('error', 'Denda ini tidak dalam status menunggu konfirmasi.');
        }

        if ($fine->payment_method !== 'cash') {
            return back()->with('error', 'Hanya pembayaran offline yang dapat dikonfirmasi.');
        }

        $this->fineRepository->markAsPaid($fine);

        return back()->with('success', 'Pembayaran offline berhasil dikonfirmasi.');
    }


    public function rejectPayment(Request $request, Fine $fine)
    {
        if ($fine->status !== 'pending_confirmation') {
            return back()->with('error', 'Denda ini tidak dalam status menunggu konfirmasi.');
        }

        $request->validate([
            'rejection_note' => 'nullable|string|max:500'
        ]);

        $fine->update([
            'status' => 'unpaid',
            'payment_method' => null,
            'payment_requested_at' => null,
            'rejection_note' => $request->rejection_note,
            'rejected_at' => now(),
        ]);

        return back()->with('success', 'Pembayaran offline ditolak. User dapat mengajukan kembali.');
    }
}