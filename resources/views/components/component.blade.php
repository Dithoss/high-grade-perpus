@props(['transaction'])

<div class="card-friendly p-6 hover:shadow-lg transition-shadow">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Transaction Info -->
        <div class="flex-1">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h3 class="text-lg font-bold text-gray-900">
                            {{ $transaction->receipt_number }}
                        </h3>
                        
                        <!-- Status Badge -->
                        @php
                            $statusConfig = [
                                'borrowed' => ['icon' => 'fa-book-reader', 'color' => 'amber', 'text' => 'Dipinjam'],
                                'returned' => ['icon' => 'fa-check-circle', 'color' => 'green', 'text' => 'Dikembalikan'],
                                'return_requested' => ['icon' => 'fa-clock', 'color' => 'blue', 'text' => 'Menunggu Konfirmasi'],
                                'damaged' => ['icon' => 'fa-tools', 'color' => 'orange', 'text' => 'Rusak'],
                                'lost' => ['icon' => 'fa-question-circle', 'color' => 'gray', 'text' => 'Hilang'],
                            ];
                            
                            $status = $transaction->status;
                            $isOverdue = $transaction->isOverdue() && $status == 'borrowed';
                            
                            if ($isOverdue) {
                                $config = ['icon' => 'fa-exclamation-triangle', 'color' => 'red', 'text' => 'Terlambat'];
                            } else {
                                $config = $statusConfig[$status] ?? ['icon' => 'fa-info-circle', 'color' => 'gray', 'text' => ucfirst($status)];
                            }
                        @endphp
                        
                        <span class="px-3 py-1 bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-700 rounded-full text-xs font-semibold">
                            <i class="fas {{ $config['icon'] }} mr-1"></i> {{ $config['text'] }}
                        </span>

                        @if($transaction->is_extended)
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                <i class="fas fa-clock mr-1"></i> Diperpanjang
                            </span>
                        @endif

                        @if($transaction->extension_requested_at && !$transaction->is_extended)
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">
                                <i class="fas fa-hourglass-half mr-1"></i> Menunggu Perpanjangan
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-500">
                        <i class="fas fa-calendar mr-1"></i>
                        Dipinjam: {{ \Carbon\Carbon::parse($transaction->borrowed_at)->format('d M Y') }}
                    </p>
                </div>
            </div>

            <!-- Books List -->
            <div class="space-y-2 mb-4">
                @foreach($transaction->items as $item)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                        @if($item->book->image)
                            <img 
                                src="{{ asset('storage/' . $item->book->image) }}" 
                                alt="{{ $item->book->name }}"
                                class="w-12 h-16 object-cover rounded"
                            >
                        @else
                            <div class="w-12 h-16 bg-gradient-to-br from-blue-500 to-blue-700 rounded flex items-center justify-center">
                                <i class="fas fa-book text-white"></i>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">{{ $item->book->name }}</h4>
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <span>
                                    <i class="fas fa-user mr-1"></i>{{ $item->book->author }}
                                </span>
                                <span>•</span>
                                <span>Jumlah: {{ $item->quantity }} buku</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Timeline -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-check text-blue-600"></i>
                    </div>
                    <div>
                        <div class="text-gray-500">Tanggal Pinjam</div>
                        <div class="font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($transaction->borrowed_at)->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-amber-600"></i>
                    </div>
                    <div>
                        <div class="text-gray-500">Jatuh Tempo</div>
                        <div class="font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($transaction->due_at)->format('d M Y') }}
                        </div>
                    </div>
                </div>

                @if($transaction->returned_at)
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        <div>
                            <div class="text-gray-500">Dikembalikan</div>
                            <div class="font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($transaction->returned_at)->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-hourglass-half text-gray-600"></i>
                        </div>
                        <div>
                            <div class="text-gray-500">Sisa Waktu</div>
                            <div class="font-semibold text-gray-900">
                                @php
                                    $daysLeft = \Carbon\Carbon::parse($transaction->due_at)->diffInDays(now(), false);
                                @endphp
                                @if($daysLeft < 0)
                                    <span class="text-green-600">{{ abs($daysLeft) }} hari lagi</span>
                                @elseif($daysLeft == 0)
                                    <span class="text-amber-600">Hari ini</span>
                                @else
                                    <span class="text-red-600">Terlambat {{ $daysLeft }} hari</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Fines -->
            @if($transaction->fines->count() > 0)
                <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                    <h4 class="font-semibold text-red-800 mb-2">
                        <i class="fas fa-exclamation-circle mr-2"></i>Denda
                    </h4>
                    @php
                        $totalFine = 0;
                    @endphp
                    @foreach($transaction->fines as $fine)
                        @php
                            $totalFine += $fine->amount;
                        @endphp
                        <div class="flex justify-between items-center text-sm mb-1">
                            <span class="text-red-700">
                                {{ $fine->type == 'late' ? 'Keterlambatan' : ($fine->type == 'lost' ? 'Hilang' : 'Rusak') }}
                                @if($fine->late_days > 0)
                                    ({{ $fine->late_days }} hari)
                                @endif
                            </span>
                            <span class="font-bold text-red-800">
                                Rp {{ number_format($fine->amount, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                    <div class="border-t border-red-200 mt-2 pt-2 flex justify-between items-center">
                        <span class="font-bold text-red-800">Total Denda:</span>
                        <span class="font-bold text-red-900 text-lg">
                            Rp {{ number_format($totalFine, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            @endif

            <!-- Inspection Note -->
            @if($transaction->inspection_note)
                <div class="mt-4 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                    <h4 class="font-semibold text-blue-800 mb-2">
                        <i class="fas fa-clipboard-check mr-2"></i>Catatan Inspeksi
                    </h4>
                    <p class="text-sm text-blue-700">{{ $transaction->inspection_note }}</p>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col gap-2 lg:w-40">
            <a 
                href="{{ route('transactions.show', $transaction->id) }}"
                class="btn-large bg-blue-600 text-white rounded-xl hover:bg-blue-700 text-center"
            >
                <i class="fas fa-eye mr-2"></i>Detail
            </a>

            @if($transaction->status == 'borrowed' && !$transaction->returned_at)
                <a 
                    href="{{ route('transactions.receipt', $transaction->id) }}"
                    class="btn-large bg-green-600 text-white rounded-xl hover:bg-green-700 text-center"
                    target="_blank"
                >
                    <i class="fas fa-receipt mr-2"></i>Bukti
                </a>
            @endif

            @if($transaction->returned_at)
                <button 
                    class="btn-large bg-gray-400 text-white rounded-xl cursor-not-allowed"
                    disabled
                >
                    <i class="fas fa-check mr-2"></i>Selesai
                </button>
            @endif
        </div>
    </div>
</div>