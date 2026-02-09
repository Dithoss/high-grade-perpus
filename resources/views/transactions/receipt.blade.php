<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Peminjaman - {{ $transaction->receipt_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-book-open text-3xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Perpustakaan Digital</h1>
                        <p class="text-blue-100">Bukti Peminjaman Buku</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-blue-100">Nomor Transaksi</div>
                    <div class="text-xl font-bold">{{ $transaction->receipt_number }}</div>
                </div>
            </div>
        </div>

        <!-- Transaction Details -->
        <div class="p-8">
            <!-- Peminjam Info -->
            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                    <i class="fas fa-user-circle text-blue-600 mr-2"></i>
                    Informasi Peminjam
                </h2>
                <div class="grid grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg">
                    <div>
                        <div class="text-sm text-gray-600">Nama</div>
                        <div class="font-semibold text-gray-900">{{ $transaction->user->name }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">Email</div>
                        <div class="font-semibold text-gray-900">{{ $transaction->user->email }}</div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                    <i class="fas fa-calendar text-blue-600 mr-2"></i>
                    Timeline Peminjaman
                </h2>
                <div class="grid grid-cols-3 gap-4">
                    <div class="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                        <div class="text-sm text-blue-700 font-medium">Tanggal Pinjam</div>
                        <div class="text-lg font-bold text-blue-900">
                            {{ \Carbon\Carbon::parse($transaction->borrowed_at)->format('d M Y') }}
                        </div>
                        <div class="text-xs text-blue-600 mt-1">
                            {{ \Carbon\Carbon::parse($transaction->borrowed_at)->format('H:i') }} WIB
                        </div>
                    </div>

                    <div class="p-4 bg-amber-50 rounded-lg border-l-4 border-amber-500">
                        <div class="text-sm text-amber-700 font-medium">Jatuh Tempo</div>
                        <div class="text-lg font-bold text-amber-900">
                            {{ \Carbon\Carbon::parse($transaction->due_at)->format('d M Y') }}
                        </div>
                        <div class="text-xs text-amber-600 mt-1">
                            @php
                                $daysLeft = \Carbon\Carbon::parse($transaction->due_at)->diffInDays(now(), false);
                            @endphp
                            @if($daysLeft < 0)
                                {{ abs($daysLeft) }} hari lagi
                            @elseif($daysLeft == 0)
                                Jatuh tempo hari ini
                            @else
                                Terlambat {{ $daysLeft }} hari
                            @endif
                        </div>
                    </div>

                    <div class="p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                        <div class="text-sm text-green-700 font-medium">Status</div>
                        <div class="text-lg font-bold text-green-900">
                            @if($transaction->status == 'borrowed')
                                Dipinjam
                            @elseif($transaction->status == 'returned')
                                Dikembalikan
                            @else
                                {{ ucfirst($transaction->status) }}
                            @endif
                        </div>
                        @if($transaction->is_extended)
                            <div class="text-xs text-green-600 mt-1">
                                <i class="fas fa-clock mr-1"></i>Diperpanjang
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Books List -->
            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                    <i class="fas fa-books text-blue-600 mr-2"></i>
                    Daftar Buku yang Dipinjam
                </h2>
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Judul Buku</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kategori</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($transaction->items as $index => $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            @if($item->book->image)
                                                <img 
                                                    src="{{ asset('storage/' . $item->book->image) }}" 
                                                    alt="{{ $item->book->name }}"
                                                    class="w-10 h-14 object-cover rounded"
                                                >
                                            @else
                                                <div class="w-10 h-14 bg-gradient-to-br from-blue-500 to-blue-700 rounded flex items-center justify-center">
                                                    <i class="fas fa-book text-white text-xs"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-semibold text-gray-900">{{ $item->book->name }}</div>
                                                <div class="text-xs text-gray-600">{{ $item->book->author }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">
                                            {{ $item->book->category->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="font-semibold text-gray-900">{{ $item->quantity }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Ketentuan -->
            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                    <i class="fas fa-clipboard-list text-blue-600 mr-2"></i>
                    Ketentuan Peminjaman
                </h2>
                <div class="p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded-lg">
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-yellow-600 mt-0.5"></i>
                            <span>Buku harus dikembalikan paling lambat pada tanggal jatuh tempo</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-yellow-600 mt-0.5"></i>
                            <span>Keterlambatan pengembalian dikenakan denda Rp 5.000 per hari per buku</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-yellow-600 mt-0.5"></i>
                            <span>Buku yang rusak atau hilang akan dikenakan denda sesuai harga buku</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-yellow-600 mt-0.5"></i>
                            <span>Perpanjangan peminjaman dapat dilakukan maksimal 1 kali (7 hari)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-yellow-600 mt-0.5"></i>
                            <span>Harap menjaga kebersihan dan keutuhan buku selama peminjaman</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t border-gray-200 pt-6 mt-6">
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <div class="text-sm text-gray-600 mb-4">Petugas Perpustakaan</div>
                        <div class="border-t border-gray-300 pt-2 mt-12">
                            <div class="text-sm text-gray-700">(_____________________)</div>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600 mb-4">Peminjam</div>
                        <div class="border-t border-gray-300 pt-2 mt-12">
                            <div class="text-sm text-gray-700">{{ $transaction->user->name }}</div>
                        </div>
                    </div>
                </div>

                <div class="text-center text-xs text-gray-500 mt-8">
                    <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
                    <p class="mt-1">Dokumen ini sah sebagai bukti peminjaman buku</p>
                </div>
            </div>
        </div>

        <!-- Print Button -->
        <div class="p-4 bg-gray-50 border-t border-gray-200 no-print">
            <div class="flex gap-3 justify-center">
                <button 
                    onclick="window.print()"
                    class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-semibold"
                >
                    <i class="fas fa-print mr-2"></i>
                    Cetak Bukti
                </button>
                <button 
                    onclick="window.close()"
                    class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 font-semibold"
                >
                    <i class="fas fa-times mr-2"></i>
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>