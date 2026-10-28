@extends('layouts.app')

@section('title', 'Tambah Barang | Sistem ATK')
@section('page-title', 'Master Data Barang')

@section('content')

<style>
    .atk-create-page,
    .atk-create-page * {
        box-sizing: border-box;
    }

    /* HEADER KHUSUS HALAMAN TAMBAH BARANG */

    .atk-custom-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        min-height: 72px;
        padding: 12px 32px;
        background: #fff;
        border-bottom: 1px solid #E2E8F0;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .atk-header-title {
        margin: 0 0 6px;
        color: #0F172A;
        font-size: 20px;
        font-weight: 800;
    }

    .atk-breadcrumb {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        color: #94A3B8;
        font-size: 12px;
    }

    .atk-breadcrumb strong {
        color: #0284C7;
        font-weight: 700;
    }

    .atk-header-right {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .atk-header-date {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 12px;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        color: #475569;
        font-size: 12px;
        white-space: nowrap;
    }

    .atk-header-date .material-symbols-outlined {
        font-size: 17px;
    }

    .atk-header-notification {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        background: #fff;
        color: #475569;
        cursor: pointer;
    }

    .atk-header-profile {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .atk-header-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #E0F2FE;
        color: #0284C7;
    }

    .atk-header-profile strong,
    .atk-header-profile small {
        display: block;
    }

    .atk-header-profile strong {
        color: #0F172A;
        font-size: 12px;
    }

    .atk-header-profile small {
        margin-top: 3px;
        color: #94A3B8;
        font-size: 11px;
    }

    /* HALAMAN */

    .atk-create-page {
        min-height: 100%;
        padding: 32px;
        background: #F4FAFF;
        color: #0F172A;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        font-size: 13px;
    }

    .atk-create-page .material-symbols-outlined {
        font-family: 'Material Symbols Outlined';
        font-weight: normal;
        font-style: normal;
        line-height: 1;
        letter-spacing: normal;
        text-transform: none;
        display: inline-block;
        white-space: nowrap;
        direction: ltr;
        font-feature-settings: 'liga';
        -webkit-font-smoothing: antialiased;
        vertical-align: middle;
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }

    .atk-create-page .filled {
        font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }

    /* MODE TAMPILAN */

    .atk-create-mode {
        width: 100%;
        max-width: 960px;
        margin: 0 auto 24px;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        background: #fff;
        border: 1px solid rgba(186, 230, 253, .6);
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, .05);
    }

    .atk-create-mode-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .atk-create-mode-heading > .material-symbols-outlined {
        color: #0284C7;
        font-size: 20px;
    }

    .atk-create-mode-heading h4 {
        margin: 0;
        color: #0F172A;
        font-size: 13px;
        font-weight: 700;
    }

    .atk-create-mode-tabs {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px;
        flex-shrink: 0;
        border: 1px solid #E2E8F0;
        border-radius: 999px;
        background: #F1F5F9;
    }

    .atk-create-mode-tabs a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 999px;
        color: #475569;
        text-decoration: none;
        white-space: nowrap;
        font-size: 12px;
        font-weight: 500;
    }

    .atk-create-mode-tabs a .material-symbols-outlined {
        color: #94A3B8;
        font-size: 16px;
    }

    .atk-create-mode-tabs a:hover {
        color: #0284C7;
        background: #fff;
    }

    .atk-create-mode-tabs a.active {
        color: #fff;
        background: #38BDF8;
        font-weight: 700;
        box-shadow: 0 2px 4px rgba(56, 189, 248, .2);
    }

    .atk-create-mode-tabs a.active .material-symbols-outlined {
        color: #fff;
    }

    /* KEMBALI */

    .atk-create-back {
        display: flex;
        align-items: center;
        gap: 6px;
        width: 100%;
        max-width: 960px;
        margin: 0 auto 16px;
        color: #94A3B8;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .atk-create-back:hover {
        color: #0F172A;
    }

    .atk-create-back .material-symbols-outlined {
        font-size: 18px;
    }

    /* KARTU FORM */

    .atk-create-card {
        position: relative;
        width: 100%;
        max-width: 960px;
        margin: 0 auto;
        overflow: hidden;
        background: #fff;
        border: 1px solid rgba(226, 232, 240, .8);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, .04);
    }

    .atk-create-gold-line {
        width: 100%;
        height: 3px;
        background: #E5B93C;
    }

    .atk-create-card-body {
        padding: 28px;
    }

    .atk-create-card-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 20px;
        margin-bottom: 20px;
        border-bottom: 1px solid #F1F5F9;
    }

    .atk-create-heading-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        border-radius: 12px;
        background: #E0F2FE;
        color: #0284C7;
    }

    .atk-create-heading-icon .material-symbols-outlined {
        font-size: 22px;
    }

    .atk-create-card-heading h3 {
        margin: 0;
        color: #0F172A;
        font-size: 17px;
        font-weight: 700;
        line-height: 1.5;
    }

    /* NOTIFIKASI STOK */

    .atk-create-notice {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        margin-bottom: 24px;
        border: 1px solid #BAE6FD;
        border-radius: 12px;
        background: #E0F2FE;
        color: #0369A1;
        font-size: 13px;
    }

    .atk-create-notice > .material-symbols-outlined {
        flex-shrink: 0;
        color: #0284C7;
        font-size: 20px;
    }

    .atk-create-notice p {
        margin: 0;
        font-weight: 500;
        line-height: 1.7;
    }

    .atk-create-notice a {
        color: inherit;
        font-weight: 700;
        text-decoration: underline;
    }

    /* FIELD */

    .atk-create-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .atk-create-field {
        min-width: 0;
    }

    .atk-create-field label {
        display: block;
        margin-bottom: 6px;
        color: #0F172A;
        font-size: 13px;
        font-weight: 700;
    }

    .atk-create-required {
        color: #EF4444;
    }

    .atk-create-field .form-control,
    .atk-create-field .form-select {
        display: block;
        width: 100%;
        min-height: 42px;
        margin: 0;
        padding: 10px 13px;
        border: 1px solid #CBD5E1;
        border-radius: 10px;
        background-color: #fff;
        color: #0F172A;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        font-size: 13px;
        font-weight: 500;
        line-height: 1.5;
        box-shadow: none;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .atk-create-field .form-control::placeholder {
        color: #94A3B8;
        opacity: 1;
    }

    .atk-create-field .form-control:focus,
    .atk-create-field .form-select:focus {
        border-color: #38BDF8;
        outline: 0;
        box-shadow: 0 0 0 2px rgba(56, 189, 248, .2);
    }

    .atk-create-field select.form-select {
        padding-right: 38px;
        appearance: none;
        -webkit-appearance: none;
        cursor: pointer;
    }

    .atk-create-select-wrap,
    .atk-create-stock-wrap,
    .atk-create-location-wrap {
        position: relative;
    }

    .atk-create-select-wrap > .material-symbols-outlined {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        color: #94A3B8;
        font-size: 20px;
        pointer-events: none;
    }

    .atk-create-field .is-invalid {
        border-color: #EF4444 !important;
    }

    .atk-create-field .invalid-feedback {
        display: block;
        margin-top: 6px;
        color: #EF4444;
        font-size: 12px;
        font-weight: 600;
    }

    .atk-create-stock-wrap .form-control {
        padding-right: 65px;
        font-weight: 600;
    }

    .atk-create-stock-unit {
        position: absolute;
        top: 50%;
        right: 14px;
        transform: translateY(-50%);
        color: #94A3B8;
        font-size: 12px;
        font-weight: 700;
        pointer-events: none;
    }

    .atk-create-help {
        display: block;
        margin-top: 4px;
        color: #94A3B8;
        font-size: 11px;
        line-height: 1.6;
    }

    .atk-create-location-wrap > .material-symbols-outlined {
        position: absolute;
        top: 11px;
        left: 12px;
        color: #94A3B8;
        font-size: 18px;
        pointer-events: none;
    }

    .atk-create-location-wrap .form-control {
        padding-left: 36px;
    }

    .atk-create-field textarea.form-control {
        min-height: 82px;
        resize: vertical;
    }

    /* TOMBOL */

    .atk-create-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 20px;
        margin-top: 4px;
        border-top: 1px solid #F1F5F9;
    }

    .atk-create-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        padding: 10px 24px;
        border-radius: 999px;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
        transition: .2s ease;
    }

    .atk-create-btn-cancel {
        min-width: 90px;
        color: #0F172A;
        background: #fff;
        border: 1px solid #CBD5E1;
    }

    .atk-create-btn-cancel:hover {
        color: #0F172A;
        background: #F8FAFC;
    }

    .atk-create-btn-save {
        color: #fff;
        background: #38BDF8;
        border: 1px solid #38BDF8;
        box-shadow: 0 2px 5px rgba(56, 189, 248, .2);
    }

    .atk-create-btn-save:hover {
        color: #fff;
        background: #0EA5E9;
    }

    .atk-create-btn-save .material-symbols-outlined {
        font-size: 18px;
    }

    /* FOOTER */

    .atk-create-footer {
        max-width: 896px;
        margin: 28px auto 0;
        color: #94A3B8;
        font-size: 12px;
        font-weight: 500;
        line-height: 1.8;
        text-align: center;
    }

    /* RESPONSIVE */

    @media (max-width: 767.98px) {
        .atk-custom-header {
            align-items: flex-start;
            flex-direction: column;
            padding: 18px 16px;
        }

        .atk-header-right {
            width: 100%;
            justify-content: flex-end;
        }

        .atk-header-date {
            display: none;
        }

        .atk-create-page {
            padding: 20px 14px;
        }

        .atk-create-mode {
            align-items: flex-start;
            flex-direction: column;
            padding: 14px;
        }

        .atk-create-mode-tabs {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
        }

        .atk-create-mode-tabs a {
            padding-right: 12px;
            padding-left: 12px;
        }

        .atk-create-card-body {
            padding: 22px 16px;
        }

        .atk-create-card-heading h3 {
            font-size: 15px;
        }

        .atk-create-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .atk-create-btn {
            width: 100%;
        }

        .atk-create-footer {
            font-size: 11px;
        }
    }
</style>

<div class="atk-create-page inventory-page">

    <div class="inv-page-head">
        <div class="inv-heading">
            <div class="inv-breadcrumb"><span>Persediaan &amp; Logistik</span><span class="inv-breadcrumb-dot"></span><span class="inv-breadcrumb-current">Master Data</span></div>
            <h1 class="inv-title">Tambah Barang</h1>
            <p class="inv-subtitle">Tambahkan item baru ke master persediaan</p>
        </div>
        <a href="{{ route('barangs.index') }}" class="inv-button"><span class="material-symbols-outlined">arrow_back</span>Kembali</a>
    </div>

    {{-- MODE TAMPILAN --}}
    <div class="atk-create-mode">
        <div class="atk-create-mode-heading">
            <span class="material-symbols-outlined">folder</span>
            <h4>Mode Tampilan</h4>
        </div>

        <div class="atk-create-mode-tabs">
            <a href="{{ route('barangs.create') }}" class="active">
                <span class="material-symbols-outlined">add</span>
                <span>Tambah Barang</span>
            </a>

            <a href="{{ route('barangs.index') }}">
                <span class="material-symbols-outlined">edit</span>
                <span>Edit Barang</span>
            </a>

            <a href="{{ route('barangs.index') }}">
                <span class="material-symbols-outlined">visibility</span>
                <span>Detail Barang</span>
            </a>
        </div>
    </div>

    {{-- KEMBALI --}}
    <a href="{{ route('barangs.index') }}" class="atk-create-back">
        <span class="material-symbols-outlined">arrow_back</span>
        <span>Kembali ke Daftar Barang</span>
    </a>

    {{-- KARTU FORM --}}
    <div class="atk-create-card">
        <div class="atk-create-gold-line"></div>

        <div class="atk-create-card-body">

            <div class="atk-create-card-heading">
                <div class="atk-create-heading-icon">
                    <span class="material-symbols-outlined filled">add_box</span>
                </div>
                <h3>Formulir Tambah Master Barang</h3>
            </div>

            <div class="atk-create-notice">
                <span class="material-symbols-outlined filled">folder</span>
                <p>
                    Stok awal 0. Tambahkan stok lewat menu
                    <a href="{{ route('stock-in.index') }}">Barang Masuk</a>.
                </p>
            </div>

            {{-- FORM --}}
            <form action="{{ route('barangs.store') }}"
                  method="POST"
                  class="atk-create-form">
                @csrf

                <div class="atk-create-field">
                    <label for="code">
                        Kode Barang <span class="atk-create-required">*</span>
                    </label>

                    <input
                        type="text"
                        id="code"
                        name="code"
                        value="{{ old('code') }}"
                        class="form-control @error('code') is-invalid @enderror"
                        placeholder="Contoh: ATK-005"
                        required
                    >

                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="atk-create-field">
                    <label for="name">
                        Nama Barang <span class="atk-create-required">*</span>
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Contoh: Kertas HVS Folio 70gr"
                        required
                    >

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="atk-create-field">
                    <label for="category_id">
                        Kategori <span class="atk-create-required">*</span>
                    </label>

                    <div class="atk-create-select-wrap">
                        <select id="category_id"
                                name="category_id"
                                class="form-select @error('category_id') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Kategori --</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <span class="material-symbols-outlined">expand_more</span>
                    </div>

                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="atk-create-field">
                    <label for="unit_id">
                        Satuan <span class="atk-create-required">*</span>
                    </label>

                    <div class="atk-create-select-wrap">
                        <select id="unit_id"
                                name="unit_id"
                                class="form-select @error('unit_id') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Satuan --</option>

                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}"
                                    {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>

                        <span class="material-symbols-outlined">expand_more</span>
                    </div>

                    @error('unit_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="atk-create-field">
                    <label for="minimum_stock">
                        Stok Minimum <span class="atk-create-required">*</span>
                    </label>

                    <div class="atk-create-stock-wrap">
                        <input
                            type="number"
                            id="minimum_stock"
                            name="minimum_stock"
                            value="{{ old('minimum_stock', 0) }}"
                            min="0"
                            class="form-control @error('minimum_stock') is-invalid @enderror"
                            required
                        >
                        <span class="atk-create-stock-unit">UNIT</span>
                    </div>

                    <small class="atk-create-help">
                        Peringatan otomatis muncul di dashboard jika stok riil
                        sama atau di bawah batas ini.
                    </small>

                    @error('minimum_stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="atk-create-field">
                    <label for="location">Lokasi</label>

                    <div class="atk-create-location-wrap">
                        <span class="material-symbols-outlined">warehouse</span>

                        <input
                            type="text"
                            id="location"
                            name="location"
                            value="{{ old('location') }}"
                            class="form-control @error('location') is-invalid @enderror"
                            placeholder="Contoh: Gudang A, Rak 1"
                        >
                    </div>

                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="atk-create-field">
                    <label for="description">Deskripsi</label>

                    <textarea
                        id="description"
                        name="description"
                        rows="3"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Keterangan spesifikasi fisik barang, warna, merek, atau peruntukan operasional..."
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="atk-create-actions">
                    <a href="{{ route('barangs.index') }}"
                       class="atk-create-btn atk-create-btn-cancel">
                        Batal
                    </a>

                    <button type="submit"
                            class="atk-create-btn atk-create-btn-save">
                        <span class="material-symbols-outlined">check</span>
                        <span>Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="atk-create-footer">
        © 2026 Sistem Manajemen Persediaan &amp; ATK
        • PT Pupuk Sriwidjaja Palembang
        • Member of Pupuk Indonesia
    </footer>

</div>

@endsection
