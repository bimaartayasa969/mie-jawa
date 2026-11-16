@props(['type' => null, 'message' => null])

@php
    $alertType = $type;
    $alertMessage = $message;

    if (! $alertMessage) {
        if (session('sukses')) {
            $alertType = 'success';
            $alertMessage = session('sukses');
        } elseif (session('success')) {
            $alertType = 'success';
            $alertMessage = session('success');
        } elseif (session('gagal')) {
            $alertType = 'error';
            $alertMessage = session('gagal');
        } elseif (session('error')) {
            $alertType = 'error';
            $alertMessage = session('error');
        } elseif (session('status')) {
            $alertType = 'info';
            $alertMessage = session('status');
        } elseif (session('warning')) {
            $alertType = 'warning';
            $alertMessage = session('warning');
        }
    }

    $styles = [
        'success' => [
            'bg' => 'bg-emerald-50 border-emerald-200 text-emerald-900',
            'icon_color' => 'text-emerald-600',
            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'title' => 'Berhasil'
        ],
        'error' => [
            'bg' => 'bg-red-50 border-red-200 text-red-900',
            'icon_color' => 'text-[#B3281A]',
            'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'title' => 'Galat'
        ],
        'warning' => [
            'bg' => 'bg-amber-50 border-amber-200 text-amber-900',
            'icon_color' => 'text-amber-600',
            'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
            'title' => 'Peringatan'
        ],
        'info' => [
            'bg' => 'bg-sky-50 border-sky-200 text-sky-900',
            'icon_color' => 'text-sky-600',
            'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'title' => 'Informasi'
        ]
    ][$alertType ?? 'info'] ?? [
        'bg' => 'bg-sky-50 border-sky-200 text-sky-900',
        'icon_color' => 'text-sky-600',
        'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'title' => 'Informasi'
    ];
@endphp

@if ($alertMessage)
    <div x-data="{ open: true }" x-show="open" class="mb-6 p-4 rounded-2xl border {{ $styles['bg'] }} shadow-xs flex items-start justify-between gap-3 transition">
        <div class="flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 mt-0.5 {{ $styles['icon_color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $styles['icon'] }}" />
            </svg>
            <div>
                <p class="text-xs sm:text-sm font-semibold">{{ $styles['title'] }}</p>
                <p class="text-xs sm:text-sm mt-0.5 leading-relaxed">{{ $alertMessage }}</p>
            </div>
        </div>
        <button type="button" @click="open = false" onclick="this.closest('.flex.items-start.justify-between').style.display='none'" class="text-gray-400 hover:text-gray-700 min-h-[44px] min-w-[44px] flex items-center justify-center -mr-2 -mt-2 cursor-pointer" aria-label="Tutup notifikasi">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 p-4 rounded-2xl border bg-red-50 border-red-200 text-red-900 shadow-xs flex items-start gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 mt-0.5 text-[#B3281A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div class="flex-1">
            <p class="text-xs sm:text-sm font-bold text-[#B3281A]">Terdapat kesalahan pada input Anda:</p>
            <ul class="list-disc list-inside text-xs mt-1 space-y-0.5">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

