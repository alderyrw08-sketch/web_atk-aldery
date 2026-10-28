@extends('layouts.app')

@section('title', 'Tambah Barang | Sistem ATK')
@section('page-title', 'Master Data Barang')

@section('content')
<div class="p-4 sm:p-8 min-h-[calc(100vh-72px)] bg-surface flex flex-col justify-between">
    <div class="max-w-4xl mx-auto w-full">

        {{-- MODE TAMPILAN BAR --}}
        <div class="bg-surface-container-lowest border border-[#BAE6FD]/60 rounded-2xl px-5 py-3 mb-6 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3.5">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-[#E0F2FE] border border-[#BAE6FD] flex items-center justify-center shrink-0 text-[#0284C7]">
                    <span class="material-symbols-outlined text-[20px]">folder</span>
                </div>
                <div>
                    <h4 class="font-bold text-[13px] text-on-surface leading-tight">Mode Tampilan</h4>
                </div>
            </div>
            <div class="inline-flex items-center p-1 rounded-full bg-surface-container-low border border-outline-variant/30 shrink-0 gap-1">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-primary-container text-white text-[12px] font-bold shadow-sm shadow-primary-container/20">
                    <span class="material-symbols-outlined text-[16px]">add</span>
                    <span>Tambah Barang</span>
                </span>
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-slate-400 text-[12px] font-medium cursor-not-allowed" title="Pilih barang terlebih dahulu">
                    <span class="material-symbols-outlined text-[16px]">edit</span>
                    <span>Edit Barang</span>
                </span>
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-slate-400 text-[12px] font-medium cursor-not-allowed" title="Pilih barang terlebih dahulu">
                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                    <span>Detail Barang</span>
                </span>
            </div>
        </div>

        {{-- TOMBOL KEMBALI --}}
        <div class="mb-4 max-w-[640px] mx-auto">
            <a href="{{ route('barangs.index') }}" class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span>Kembali ke Daftar Barang</span>
            </a>
        </div>

        {{-- FORM CARD --}}
        <div class="max-w-[640px] mx-auto bg-surface-container-lowest rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.04)] border border-outline-variant/30 overflow-hidden relative">
            <div class="h-[3px] w-full bg-[#E5B93C]"></div>

            <div class="p-6 sm:p-7">
                <div class="flex items-center justify-between pb-5 mb-5 border-b border-surface-container">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#E0F2FE] text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[22px]">add_box</span>
                        </div>
                        <div>
                            <h3 class="text-[17px] font-bold text-on-surface">Formulir Tambah Master Barang</h3>
                        </div>
                    </div>
                </div>

                {{-- INFO ALERT --}}
                <div class="mb-6 px-4 py-3 bg-[#E0F2FE] border border-[#BAE6FD] rounded-xl flex items-center gap-3 text-[13px] text-[#0369A1]">
                    <span class="material-symbols-outlined text-[20px] text-primary shrink-0">info</span>
                    <p class="leading-relaxed font-medium">Stok awal otomatis 0. Tambahkan kuantitas stok melalui menu <a href="{{ route('stock-in.create') }}" class="font-bold underline hover:text-[#0c4a6e]">Barang Masuk</a>.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-5 p-3.5 bg-error-container text-on-error-container rounded-xl text-xs flex items-center gap-2">
                        <span class="material-symbols-outlined text-base text-error">error</span>
                        <div>Terdapat kesalahan pada input form. Mohon periksa kembali data Anda.</div>
                    </div>
                @endif

                <form action="{{ route('barangs.store') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- KODE BARANG --}}
                    <div>
                        <label for="code" class="block text-[13px] font-bold text-on-surface mb-1.5">Kode Barang <span class="text-error">*</span></label>
                        <div class="relative">
                            <input
                                type="text"
                                id="code"
                                name="code"
                                value="{{ old('code') }}"
                                class="w-full px-3.5 py-2.5 rounded-xl border @error('code') border-error bg-error-container/20 @else border-outline-variant/60 bg-surface-container-lowest @enderror text-on-surface text-[13px] font-semibold tracking-wide focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all pr-10"
                                placeholder="Contoh: ATK-005"
                                required
                            >
                            @error('code')
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-error">
                                    <span class="material-symbols-outlined text-[20px]">error</span>
                                </div>
                            @enderror
                        </div>
                        @error('code')
                            <p class="mt-1.5 text-[12px] font-semibold text-error flex items-center gap-1">
                                <span class="material-symbols-outlined text-[15px]">warning</span>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    {{-- NAMA BARANG --}}
                    <div>
                        <label for="name" class="block text-[13px] font-bold text-on-surface mb-1.5">Nama Barang <span class="text-error">*</span></label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border @error('name') border-error @else border-outline-variant/60 @enderror bg-surface-container-lowest text-on-surface text-[13px] font-medium placeholder-on-surface-variant/40 focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary/20 transition-all"
                            placeholder="Contoh: Kertas HVS Folio 70gr"
                            required
                        >
                        @error('name')
                            <p class="mt-1 text-[12px] font-semibold text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- KATEGORI --}}
                    <div>
                        <label for="category_id" class="block text-[13px] font-bold text-on-surface mb-1.5">Kategori <span class="text-error">*</span></label>
                        <div class="relative">
                            <select
                                id="category_id"
                                name="category_id"
                                class="w-full px-3.5 py-2.5 rounded-xl border @error('category_id') border-error @else border-outline-variant/60 @enderror bg-surface-container-lowest text-on-surface text-[13px] font-medium appearance-none focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary/20 transition-all pr-10 cursor-pointer"
                                required
                            >
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-on-surface-variant">
                                <span class="material-symbols-outlined text-[20px]">expand_more</span>
                            </div>
                        </div>
                        @error('category_id')
                            <p class="mt-1 text-[12px] font-semibold text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SATUAN --}}
                    <div>
                        <label for="unit_id" class="block text-[13px] font-bold text-on-surface mb-1.5">Satuan <span class="text-error">*</span></label>
                        <div class="relative">
                            <select
                                id="unit_id"
                                name="unit_id"
                                class="w-full px-3.5 py-2.5 rounded-xl border @error('unit_id') border-error @else border-outline-variant/60 @enderror bg-surface-container-lowest text-on-surface text-[13px] font-medium appearance-none focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary/20 transition-all pr-10 cursor-pointer"
                                required
                            >
                                <option value="">-- Pilih Satuan --</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-on-surface-variant">
                                <span class="material-symbols-outlined text-[20px]">expand_more</span>
                            </div>
                        </div>
                        @error('unit_id')
                            <p class="mt-1 text-[12px] font-semibold text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- STOK MINIMUM --}}
                    <div>
                        <label for="minimum_stock" class="block text-[13px] font-bold text-on-surface mb-1.5">Stok Minimum <span class="text-error">*</span></label>
                        <div class="relative">
                            <input
                                type="number"
                                id="minimum_stock"
                                name="minimum_stock"
                                value="{{ old('minimum_stock', 0) }}"
                                min="0"
                                class="w-full px-3.5 py-2.5 rounded-xl border @error('minimum_stock') border-error @else border-outline-variant/60 @enderror bg-surface-container-lowest text-on-surface text-[13px] font-semibold focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary/20 transition-all"
                                required
                            >
                        </div>
                        <p class="mt-1 text-[11px] font-medium text-on-surface-variant">Peringatan otomatis muncul jika sisa stok sama atau di bawah batas ini.</p>
                        @error('minimum_stock')
                            <p class="mt-1 text-[12px] font-semibold text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- LOKASI --}}
                    <div>
                        <label for="location" class="block text-[13px] font-bold text-on-surface mb-1.5">Lokasi</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-2.5 text-[18px] text-on-surface-variant pointer-events-none">warehouse</span>
                            <input
                                type="text"
                                id="location"
                                name="location"
                                value="{{ old('location') }}"
                                class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-outline-variant/60 bg-surface-container-lowest text-on-surface text-[13px] font-medium placeholder-on-surface-variant/40 focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary/20 transition-all"
                                placeholder="Contoh: Gudang A, Rak 1"
                            >
                        </div>
                        @error('location')
                            <p class="mt-1 text-[12px] font-semibold text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- DESKRIPSI --}}
                    <div>
                        <label for="description" class="block text-[13px] font-bold text-on-surface mb-1.5">Deskripsi</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant/60 bg-surface-container-lowest text-on-surface text-[13px] font-medium placeholder-on-surface-variant/40 focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary/20 transition-all resize-none"
                            placeholder="Keterangan spesifikasi fisik barang, warna, merek, atau peruntukan operasional..."
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-[12px] font-semibold text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ACTIONS --}}
                    <div class="pt-4 mt-5 border-t border-surface-container flex items-center justify-end gap-3">
                        <a href="{{ route('barangs.index') }}" class="inline-flex items-center justify-center min-w-[90px] px-5 py-2.5 rounded-full border border-outline-variant/60 text-on-surface hover:bg-surface-container font-semibold text-[13px] transition-colors">Batal</a>
                        <button type="submit" class="px-6 py-2.5 rounded-full bg-primary-container hover:bg-primary text-white font-bold text-[13px] flex items-center gap-2 shadow-sm shadow-primary-container/30 transition-all active:scale-[0.98]">
                            <span class="material-symbols-outlined text-[18px]">check</span>
                            <span>Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- CORPORATE FOOTER --}}
        <footer class="mt-8 text-center text-[12px] font-medium text-on-surface-variant">
            © 2026 Sistem Manajemen Persediaan &amp; ATK • PT Pupuk Sriwidjaja Palembang • Member of Pupuk Indonesia
        </footer>
    </div>
</div>
@endsection
