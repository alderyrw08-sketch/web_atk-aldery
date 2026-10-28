@extends('layouts.app')

@section('title', 'Detail Barang | Sistem ATK')
@section('page-title', 'Master Data Barang')

@section('content')
@php
    $stockStatus = $barang->stock <= 0 ? 'Habis' : ($barang->stock <= $barang->minimum_stock ? 'Menipis' : 'Aman');
@endphp

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
                @can('barang.create')
                    <a href="{{ route('barangs.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-on-surface-variant hover:text-primary transition-colors text-[12px] font-medium">
                        <span class="material-symbols-outlined text-[16px]">add</span>
                        <span>Tambah Barang</span>
                    </a>
                @endcan
                @can('barang.update')
                    <a href="{{ route('barangs.edit', $barang) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-on-surface-variant hover:text-primary transition-colors text-[12px] font-medium">
                        <span class="material-symbols-outlined text-[16px]">edit</span>
                        <span>Edit Barang</span>
                    </a>
                @endcan
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-primary-container text-white text-[12px] font-bold shadow-sm shadow-primary-container/20">
                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                    <span>Detail Barang</span>
                </span>
            </div>
        </div>

        {{-- TOMBOL KEMBALI --}}
        <div class="mb-4 max-w-[620px] mx-auto">
            <a href="{{ route('barangs.index') }}" class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span>Kembali ke Daftar Barang</span>
            </a>
        </div>

        {{-- DETAIL CARD --}}
        <div class="max-w-[620px] mx-auto bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6 sm:p-7 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-[#E5B93C]"></div>

            <div class="flex items-center justify-between pb-4 border-b border-surface-container">
                <div>
                    <h3 class="text-[17px] font-bold text-on-surface tracking-tight">Informasi Detail Master Barang</h3>
                </div>
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $barang->status ? 'bg-tertiary-fixed text-on-tertiary-fixed' : 'bg-surface-container-high text-on-surface-variant' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $barang->status ? 'bg-tertiary' : 'bg-on-surface-variant' }}"></span>
                    <span class="leading-none">{{ $barang->status ? 'Aktif' : 'Nonaktif' }}</span>
                </div>
            </div>

            <div class="flex flex-col gap-3 mt-4">
                {{-- KODE BARANG --}}
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Kode Barang</label>
                    <div class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs font-semibold text-on-surface flex items-center justify-between">
                        <span class="font-mono font-bold text-primary">{{ $barang->code }}</span>
                        <span class="text-[11px] font-semibold text-on-surface-variant">ID Internal PUSRI</span>
                    </div>
                </div>

                {{-- NAMA BARANG --}}
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Nama Barang</label>
                    <div class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs font-semibold text-on-surface">
                        {{ $barang->name }}
                    </div>
                </div>

                {{-- KATEGORI --}}
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Kategori</label>
                    <div class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs font-semibold text-on-surface">
                        {{ $barang->category->name ?? '-' }}
                    </div>
                </div>

                {{-- SATUAN --}}
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Satuan</label>
                    <div class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs font-semibold text-on-surface">
                        {{ $barang->unit->name ?? '-' }}
                    </div>
                </div>

                {{-- STOK SAAT INI --}}
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Stok Saat Ini</label>
                    <div class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs font-bold text-on-surface flex items-center justify-between">
                        <span class="text-xs font-bold text-on-surface">{{ number_format($barang->stock) }} {{ $barang->unit->name ?? '' }}</span>
                        <span class="text-[11px] font-bold text-tertiary bg-tertiary-fixed px-2 py-0.5 rounded-md">Fisik Terverifikasi</span>
                    </div>
                </div>

                {{-- STOK MINIMUM --}}
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Stok Minimum</label>
                    <div class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs font-medium text-on-surface flex items-center justify-between">
                        <span class="text-xs font-bold text-on-surface">{{ number_format($barang->minimum_stock) }} {{ $barang->unit->name ?? '' }}</span>
                        <span class="text-[11px] font-medium text-on-surface-variant">Ambang Batas Peringatan</span>
                    </div>
                </div>

                {{-- STATUS STOK --}}
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Status Stok</label>
                    <div class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-1.5 flex items-center">
                        @if ($stockStatus === 'Aman')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-tertiary-fixed text-on-tertiary-fixed text-xs font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                <span class="material-symbols-outlined text-sm text-tertiary">check_circle</span>
                                <span class="leading-none">Aman</span>
                            </span>
                        @elseif ($stockStatus === 'Menipis')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-xs font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                <span class="material-symbols-outlined text-sm text-amber-600">warning</span>
                                <span class="leading-none">Menipis</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-error-container text-on-error-container text-xs font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                <span class="material-symbols-outlined text-sm text-error">error</span>
                                <span class="leading-none">Habis</span>
                            </span>
                        @endif
                    </div>
                </div>

                {{-- LOKASI --}}
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Lokasi</label>
                    <div class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs font-semibold text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-base">location_on</span>
                        <span class="font-medium text-on-surface">{{ $barang->location ?: '-' }}</span>
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Deskripsi</label>
                    <div class="w-full min-h-[64px] bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs font-medium text-on-surface-variant">
                        {{ $barang->description ?: '-' }}
                    </div>
                </div>

                {{-- STATUS BARANG --}}
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Status</label>
                    <div class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-1.5 flex items-center">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold {{ $barang->status ? 'bg-tertiary-fixed text-on-tertiary-fixed' : 'bg-surface-container-high text-on-surface-variant' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $barang->status ? 'bg-tertiary' : 'bg-on-surface-variant' }}"></span>
                            <span class="material-symbols-outlined text-sm {{ $barang->status ? 'text-tertiary' : 'text-on-surface-variant' }}">{{ $barang->status ? 'verified' : 'cancel' }}</span>
                            <span class="leading-none">{{ $barang->status ? 'Aktif' : 'Nonaktif' }}</span>
                        </span>
                    </div>
                </div>

                {{-- DIBUAT --}}
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Dibuat</label>
                    <div class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs font-medium text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-on-surface-variant text-base">schedule</span>
                        <span class="font-mono font-medium text-on-surface">{{ $barang->created_at?->format('d-m-Y H:i') ?? '-' }} WIB</span>
                    </div>
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="mt-6 pt-4 border-t border-surface-container flex items-center justify-between">
                <a href="{{ route('barangs.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-full border border-outline-variant/60 bg-surface-container-low text-on-surface font-semibold text-xs hover:bg-surface-container transition-colors shadow-sm">
                    Kembali
                </a>
                @can('barang.update')
                    <a href="{{ route('barangs.edit', $barang) }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-primary-container text-white font-bold text-xs hover:bg-primary transition-all shadow-sm">
                        <span class="material-symbols-outlined text-base">edit</span>
                        <span>Edit Barang</span>
                    </a>
                @endcan
            </div>
        </div>

        {{-- CORPORATE FOOTER --}}
        <footer class="mt-8 text-center text-[12px] font-medium text-on-surface-variant">
            © 2026 Sistem Manajemen Persediaan &amp; ATK • PT Pupuk Sriwidjaja Palembang • Member of Pupuk Indonesia
        </footer>
    </div>
</div>
@endsection
