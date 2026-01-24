<?php

namespace App\Services;

use App\Models\Fine;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TripayService
{
    protected string $apiKey;
    protected string $privateKey;
    protected string $merchantCode;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey       = config('tripay.api_key');
        $this->privateKey   = config('tripay.private_key');
        $this->merchantCode = config('tripay.merchant_code');
        $this->baseUrl      = config('tripay.base_url');
    }

    /**
     * Create Tripay transaction
     */
    public function createTransaction(Fine $fine): array
    {
        $merchantRef = 'FINE-' . $fine->id;

        $signature = hash_hmac(
            'sha256',
            $this->merchantCode . $merchantRef . $fine->amount,
            $this->privateKey
        );

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->baseUrl . '/transaction/create', [
            'method'         => 'QRIS', // atau VA jika mau
            'merchant_ref'   => $merchantRef,
            'amount'         => $fine->amount,
            'customer_name'  => $fine->transaction->user->name,
            'customer_email' => $fine->transaction->user->email,
            'order_items' => [
                [
                    'name'     => 'Denda ' . strtoupper($fine->type),
                    'price'    => $fine->amount,
                    'quantity' => 1,
                ]
            ],
            'callback_url' => config('tripay.callback_url'),
            'signature'    => $signature,
        ]);

        if (!$response->successful()) {
            throw new \Exception('Gagal membuat transaksi Tripay');
        }

        return $response->json()['data'];
    }
}
