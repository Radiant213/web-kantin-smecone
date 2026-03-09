<div>
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-4 text-sm font-medium text-green-600 bg-green-50 p-3 rounded-xl border border-green-100">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 text-sm font-medium text-red-600 bg-red-50 p-3 rounded-xl border border-red-100">
            {{ session('error') }}
        </div>
    @endif

    @if($kiosk)
        {{-- Penjual HAS a Kiosk --}}
        <div class="space-y-6">
            {{-- Edit Kiosk Details Form --}}
            <form method="POST" action="{{ route('penjual.kiosk.updateDetails') }}" enctype="multipart/form-data" class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                @csrf
                @method('PUT')
                <h3 class="text-md font-semibold text-gray-800 mb-3">Informasi Kios: {{ $kiosk->name }}</h3>
                <p class="text-xs text-gray-500 mb-4">Lokasi: {{ $kiosk->kantin->name }}</p>

                <div class="mb-4">
                    <x-input-label for="description" :value="__('Deskripsi Kios')" />
                    <textarea id="description" name="description" class="input-field mt-1 block w-full resize-y" rows="3" required>{{ old('description', $kiosk->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="kiosk_image" :value="__('Foto Kios (Opsional)')" />
                    <input type="file" id="kiosk_image" name="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition-colors" accept="image/*">
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Simpan Profil Kios') }}</x-primary-button>
                </div>
            </form>

            {{-- Manage Menus --}}
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-md font-semibold text-gray-800">Daftar Menu</h3>
                    <a href="{{ route('penjual.menus.create') }}" class="text-sm bg-primary-500 hover:bg-primary-600 text-white px-3 py-1.5 rounded-lg transition-colors font-medium">+ Tambah Menu</a>
                </div>
                
                @if($kiosk->menus->count() > 0)
                    <div class="overflow-hidden rounded-xl border border-gray-100">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Menu</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach($kiosk->menus as $menu)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                @if($menu->image)
                                                    <img src="{{ Storage::url($menu->image) }}" class="w-10 h-10 rounded-lg object-cover" alt="{{ $menu->name }}">
                                                @else
                                                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $menu->name }}</div>
                                                    <div class="text-xs text-gray-500 truncate max-w-[150px]">{{ $menu->description }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $menu->formatted_price }}</td>
                                        <td class="px-4 py-3 text-right text-sm font-medium">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('penjual.menus.edit', $menu) }}" class="text-primary-600 hover:text-primary-900 border border-primary-200 px-2 py-1 rounded-md">Edit</a>
                                                <form method="POST" action="{{ route('penjual.menus.destroy', $menu) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 border border-red-200 px-2 py-1 rounded-md">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-6 bg-gray-50 rounded-xl border border-gray-100 border-dashed">
                        <p class="text-sm text-gray-500">Belum ada menu di kios ini.</p>
                    </div>
                @endif
            </div>
        </div>

    @elseif($pendingApplication)
        {{-- Penjual has a pending application --}}
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 text-center">
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Pengajuan Sedang Diproses</h3>
            <p class="text-sm text-gray-600 mb-3">Mohon tunggu, permohonan kepemilikan kios <strong>{{ $pendingApplication->kiosk->name }}</strong> sedang ditinjau oleh Administrator.</p>
        </div>

    @else
        {{-- Penjual DOES NOT have a Kiosk and no pending application --}}
        <div>
            <p class="text-sm text-gray-600 mb-4">Anda mendaftar sebagai Penjual tetapi belum memiliki kios untuk dikelola. Silakan ajukan kepemilikan pada kios yang tersedia di bawah ini:</p>
            
            <form method="POST" action="{{ route('penjual.kiosk.apply') }}" class="mt-6 space-y-6">
                @csrf
                <div>
                    <x-input-label for="kiosk_id" :value="__('Pilih Kios Tersedia')" />
                    <select id="kiosk_id" name="kiosk_id" class="input-field mt-1 block w-full" required>
                        <option value="">-- Pilih Kios --</option>
                        @forelse($availableKiosks as $availKiosk)
                            <option value="{{ $availKiosk->id }}">{{ $availKiosk->name }} (Lokasi: {{ $availKiosk->kantin->name }})</option>
                        @empty
                            <option value="" disabled>Saat ini tidak ada kios yang kosong.</option>
                        @endforelse
                    </select>
                    <x-input-error :messages="$errors->get('kiosk_id')" class="mt-2" />
                </div>
                
                <div>
                    <x-input-label for="reason" :value="__('Pesan Singkat (Opsional)')" />
                    <textarea id="reason" name="reason" class="input-field mt-1 block w-full" rows="2" placeholder="Cth: Saya warga sekolah yang ingin berjualan nasi uduk..."></textarea>
                    <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4 border-t border-gray-100 pt-4 mt-6">
                    <x-primary-button :disabled="$availableKiosks->isEmpty()">
                        {{ __('Ajukan Kepemilikan') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    @endif
</div>