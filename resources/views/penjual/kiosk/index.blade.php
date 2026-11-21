<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-amber-400 text-primary-950">Kelola Kios</span>
                    <span class="text-xs text-slate-500">Kantin Resmi SMECONE</span>
                </div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                    @if($kiosk)
                        {{ $kiosk->name }}
                    @else
                        Manajemen Kios Penjual
                    @endif
                </h2>
            </div>
            @if($kiosk)
                <div class="flex items-center gap-2.5">
                    <a href="{{ route('kiosk.show', $kiosk) }}" target="_blank"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 px-3.5 py-2 rounded-xl shadow-xs transition-colors">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span>Lihat di Halaman Siswa</span>
                    </a>
                    <a href="{{ route('penjual.menus.create') }}"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-primary-800 hover:bg-primary-900 px-4 py-2 rounded-xl shadow-xs transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>+ Tambah Menu Baru</span>
                    </a>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm font-semibold">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-3 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-sm font-semibold">
                    <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($kiosk)
                {{-- Penjual HAS a Kiosk --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- Left Column: Kiosk Information & Profile Form --}}
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
                            <div class="p-5 border-b border-slate-100 bg-gradient-to-r from-amber-50/60 to-orange-50/60">
                                <span class="text-[10px] font-black uppercase tracking-wider text-amber-800 bg-amber-100 px-2.5 py-0.5 rounded-full">
                                    {{ $kiosk->kantin->name }}
                                </span>
                                <h3 class="text-lg font-extrabold text-slate-900 mt-2">{{ $kiosk->name }}</h3>
                                <p class="text-xs text-slate-500 mt-0.5">Penjual: {{ auth()->user()->name }} ({{ auth()->user()->email }})</p>
                            </div>

                            <form method="POST" action="{{ route('penjual.kiosk.updateDetails') }}" enctype="multipart/form-data" class="p-5 space-y-4">
                                @csrf
                                @method('PUT')

                                {{-- Preview Foto Kios --}}
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Foto Kios</label>
                                    <div class="relative w-full h-36 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 flex items-center justify-center group mb-2">
                                        @if($kiosk->image)
                                            <img src="{{ asset('storage/' . $kiosk->image) }}" alt="{{ $kiosk->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="text-center text-slate-400 p-4">
                                                <svg class="w-8 h-8 mx-auto mb-1 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span class="text-[11px] font-semibold">Belum ada foto kios</span>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" id="image" name="image" accept="image/*"
                                        class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary-50 file:text-primary-800 hover:file:bg-primary-100 cursor-pointer">
                                    <x-input-error :messages="$errors->get('image')" class="mt-1.5 text-xs" />
                                </div>

                                {{-- Deskripsi Kios --}}
                                <div>
                                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Deskripsi Kios</label>
                                    <textarea id="description" name="description" rows="4" required
                                        placeholder="Ceritakan tentang sajian khas dan keunggulan kios Anda..."
                                        class="w-full text-xs rounded-xl border-slate-200 focus:border-primary-800 focus:ring-primary-800/20 p-3 leading-relaxed">{{ old('description', $kiosk->description) }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-1 text-xs" />
                                </div>

                                <button type="submit"
                                    class="w-full py-2.5 px-4 bg-primary-800 hover:bg-primary-900 text-white text-xs font-bold rounded-xl shadow-xs transition-colors active:scale-98">
                                    Simpan Perubahan Kios
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Right Column: Menu List & Actions --}}
                    <div class="lg:col-span-2 space-y-4">
                        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
                            <div class="p-5 border-b border-slate-100 flex items-center justify-between gap-4">
                                <div>
                                    <h3 class="text-base font-extrabold text-slate-900">Daftar Menu Kios</h3>
                                    <p class="text-xs text-slate-500 mt-0.5">Total {{ $kiosk->menus->count() }} menu terdaftar di sistem</p>
                                </div>
                                <a href="{{ route('penjual.menus.create') }}"
                                    class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-primary-800 hover:bg-primary-900 px-3.5 py-2 rounded-xl shadow-xs transition-all active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                    <span>Tambah Menu</span>
                                </a>
                            </div>

                            @if($kiosk->menus->count() > 0)
                                <div class="divide-y divide-slate-100">
                                    @foreach($kiosk->menus as $menu)
                                        <div class="p-4 sm:p-5 flex items-center justify-between gap-4 hover:bg-slate-50/60 transition-colors">
                                            <div class="flex items-center gap-3.5 min-w-0">
                                                <div class="w-14 h-14 rounded-2xl bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-200/80">
                                                    @if($menu->image)
                                                        <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="min-w-0">
                                                    <h4 class="text-sm font-extrabold text-slate-900 truncate">{{ $menu->name }}</h4>
                                                    <p class="text-xs text-slate-500 truncate max-w-xs sm:max-w-md mt-0.5">{{ $menu->description }}</p>
                                                    <span class="inline-block mt-1 text-xs font-black text-primary-800 bg-primary-50 px-2 py-0.5 rounded-lg border border-primary-200">
                                                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2 flex-shrink-0">
                                                <a href="{{ route('penjual.menus.edit', $menu) }}"
                                                    class="p-2 text-slate-600 hover:text-primary-800 hover:bg-primary-50 rounded-xl border border-slate-200 transition-colors"
                                                    title="Edit Menu">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form method="POST" action="{{ route('penjual.menus.destroy', $menu) }}"
                                                    onsubmit="return confirm('Hapus menu \'{{ addslashes($menu->name) }}\'?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl border border-slate-200 transition-colors cursor-pointer"
                                                        title="Hapus Menu">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12 px-4">
                                    <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-3 text-slate-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Menu</h4>
                                    <p class="text-xs text-slate-500 max-w-xs mx-auto mb-4">Tambahkan sajian makanan atau minuman pertama Anda agar siswa bisa memesan.</p>
                                    <a href="{{ route('penjual.menus.create') }}" class="btn-primary text-xs py-2 px-4 inline-flex items-center gap-2">
                                        <span>+ Tambah Menu Pertama</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            @elseif($pendingApplication)
                {{-- Penjual HAS a Pending Application --}}
                <div class="bg-white rounded-3xl border border-amber-200 p-8 text-center max-w-xl mx-auto shadow-xs">
                    <div class="w-14 h-14 bg-amber-100 text-amber-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-slate-900 mb-2">Pengajuan Kios Sedang Diproses</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Permohonan kepemilikan kios <strong>{{ $pendingApplication->kiosk->name ?? 'Kios' }}</strong> di <strong>{{ $pendingApplication->kiosk->kantin->name ?? 'Kantin' }}</strong> sedang ditinjau oleh Administrator SMECONE.
                    </p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                        Status: Menunggu Persetujuan Admin
                    </span>
                </div>

            @else
                {{-- Penjual DOES NOT have a Kiosk --}}
                <div class="bg-white rounded-3xl border border-slate-200 p-8 max-w-2xl mx-auto shadow-xs">
                    <div class="text-center mb-6">
                        <div class="w-14 h-14 bg-primary-50 text-primary-800 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-extrabold text-slate-900 mb-1">Ajukan Kepemilikan Kios</h3>
                        <p class="text-xs text-slate-500">Pilih kios yang masih kosong untuk mulai berjualan hidangan Anda di E-Kantin SMECONE.</p>
                    </div>

                    <form method="POST" action="{{ route('penjual.kiosk.apply') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="kiosk_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Pilih Kios Tersedia</label>
                            <select id="kiosk_id" name="kiosk_id" class="w-full text-xs rounded-xl border-slate-200 focus:border-primary-800 focus:ring-primary-800/20 p-3" required>
                                <option value="">-- Pilih Kios --</option>
                                @forelse($availableKiosks as $availKiosk)
                                    <option value="{{ $availKiosk->id }}">
                                        {{ $availKiosk->name }} (Lokasi: {{ $availKiosk->kantin->name }})
                                    </option>
                                @empty
                                    <option value="" disabled>Saat ini tidak ada kios yang kosong.</option>
                                @endforelse
                            </select>
                            <x-input-error :messages="$errors->get('kiosk_id')" class="mt-1 text-xs" />
                        </div>

                        <div>
                            <label for="reason" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Pesan / Alasan Pengajuan (Opsional)</label>
                            <textarea id="reason" name="reason" rows="3" placeholder="Cth: Saya warga sekolah yang ingin berjualan makanan berat..."
                                class="w-full text-xs rounded-xl border-slate-200 focus:border-primary-800 focus:ring-primary-800/20 p-3"></textarea>
                            <x-input-error :messages="$errors->get('reason')" class="mt-1 text-xs" />
                        </div>

                        <button type="submit" :disabled="{{ $availableKiosks->isEmpty() ? 'true' : 'false' }}"
                            class="w-full py-3 bg-primary-800 hover:bg-primary-900 disabled:bg-slate-300 text-white text-xs font-bold rounded-xl shadow-xs transition-colors active:scale-98">
                            Kirim Pengajuan Kepemilikan Kios
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
