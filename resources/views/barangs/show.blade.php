@extends('layouts.app')

@section('content')
<div class="flex flex-col w-full">
    <script>
        (function updateActiveSidebar() {
            const activeItem = document.querySelector('nav a[data-path="master-barang"]');
            if (activeItem) {
                activeItem.className = 'flex items-center gap-3 px-space-sm py-2 rounded-full font-title-md text-title-md bg-primary-container text-on-primary font-semibold shadow-sm transition-all duration-150';
            }
        })();
    </script>
    <div class="p-margin flex flex-col gap-space-lg">
        <!-- Header & Tombol Aksi -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-space-md">
            <div class="flex flex-col gap-1">
                <div class="flex items-center gap-2">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Persediaan &amp; Logistik</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span>
                    <span class="font-label-sm text-label-sm text-primary font-semibold">Master Data</span>
                </div>
                <h1 class="font-headline-md text-headline-md text-on-surface font-bold tracking-tight">Daftar Barang</h1>
                <p class="font-body-md text-body-md text-on-surface-variant">Pengelolaan Data Barang dan ATK Unit Kerja Learning Center</p>
            </div>
            <div class="flex items-center gap-space-sm">
                <button class="flex items-center gap-2 px-4 py-2.5 rounded-full bg-surface-container-low text-on-surface font-label-md text-label-md hover:bg-surface-container transition-all shadow-sm" type="button">
                    <span class="material-symbols-outlined text-[18px] text-primary">cloud_download</span>
                    <span>Unduh Template</span>
                </button>
                <button class="flex items-center gap-2 px-4 py-2.5 rounded-full bg-surface-container-low text-on-surface font-label-md text-label-md hover:bg-surface-container transition-all shadow-sm" type="button">
                    <span class="material-symbols-outlined text-[18px] text-primary">upload_file</span>
                    <span>Impor Data</span>
                </button>
            </div>
        </div>

        <!-- Kartu Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-space-md">
            <div class="bg-surface-container-lowest rounded-DEFAULT p-space-md shadow-sm flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Total Terdaftar</span>
                    <span class="font-headline-sm text-headline-sm text-on-surface font-bold mt-1">4 <span class="font-body-sm text-body-sm font-normal text-on-surface-variant">Barang</span></span>
                </div>
                <div class="w-11 h-11 rounded-full bg-surface-container flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[24px]">inventory_2</span>
                </div>
            </div>
            <div class="bg-surface-container-lowest rounded-DEFAULT p-space-md shadow-sm flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Stok Aman</span>
                    <span class="font-headline-sm text-headline-sm text-tertiary font-bold mt-1">2 <span class="font-body-sm text-body-sm font-normal text-on-surface-variant">Item</span></span>
                </div>
                <div class="w-11 h-11 rounded-full bg-surface-container flex items-center justify-center text-tertiary">
                    <span class="material-symbols-outlined text-[24px]">check_circle</span>
                </div>
            </div>
            <div class="bg-surface-container-lowest rounded-DEFAULT p-space-md shadow-sm flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Stok Menipis</span>
                    <span class="font-headline-sm text-headline-sm text-on-surface font-bold mt-1">1 <span class="font-body-sm text-body-sm font-normal text-on-surface-variant">Item</span></span>
                </div>
                <div class="w-11 h-11 rounded-full bg-surface-container flex items-center justify-center text-on-secondary-fixed-variant">
                    <span class="material-symbols-outlined text-[24px]">warning</span>
                </div>
            </div>
            <div class="bg-surface-container-lowest rounded-DEFAULT p-space-md shadow-sm flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Stok Habis&nbsp;</span>
                    <span class="font-headline-sm text-headline-sm text-error font-bold mt-1">1 <span class="font-body-sm text-body-sm font-normal text-on-surface-variant">Item</span></span>
                </div>
                <div class="w-11 h-11 rounded-full bg-error-container flex items-center justify-center text-error">
                    <span class="material-symbols-outlined text-[24px]">error</span>
                </div>
            </div>
        </div>

        <!-- Katalog Data Master -->
        <div class="bg-surface-container-lowest rounded-DEFAULT p-space-lg shadow-sm flex flex-col gap-space-lg">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-space-md pb-space-sm">
                <div class="flex flex-col gap-0.5">
                    <div class="flex items-center gap-2">
                        <span class="font-title-lg text-title-lg text-on-surface font-bold">Katalog Data Master</span>
                        <span class="px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-primary-fixed text-on-primary-fixed-variant font-semibold">4 Data</span>
                    </div>
                    <span class="font-body-sm text-body-sm text-on-surface-variant">Master Data • Manajemen Gudang &amp; ATK</span>
                </div>
                <button class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-primary-container hover:bg-primary text-on-primary font-label-lg text-label-lg font-semibold shadow-sm transition-all duration-150 shrink-0" type="button">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    <span>Tambah Barang</span>
                </button>
            </div>

            <!-- Search & Filter Bar -->
            <div class="bg-surface-container-low p-space-md rounded-DEFAULT flex flex-col xl:flex-row items-stretch xl:items-center justify-between gap-space-md">
                <div class="flex flex-col md:flex-row items-stretch md:items-center gap-space-sm flex-1">
                    <div class="relative flex-1 min-w-[240px]">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">search</span>
                        <input class="w-full h-11 pl-10 pr-4 bg-surface-container-lowest text-on-surface font-body-md text-body-md rounded-DEFAULT placeholder:text-outline focus:outline-none transition-all" placeholder="Cari kode atau nama barang..." type="text">
                    </div>
                    <div class="relative min-w-[170px]">
                        <select class="w-full h-11 pl-3.5 pr-9 bg-surface-container-lowest text-on-surface font-body-md text-body-md rounded-DEFAULT focus:outline-none appearance-none cursor-pointer">
                            <option value="">Semua Status Stok</option>
                            <option value="aman">Aman</option>
                            <option value="menipis">Menipis</option>
                            <option value="habis">Habis</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-outline pointer-events-none text-[20px]">expand_more</span>
                    </div>
                </div>
                <div class="flex items-center justify-between md:justify-end gap-space-sm shrink-0">
                    <div class="relative min-w-[160px]">
                        <select class="w-full h-11 pl-3.5 pr-9 bg-surface-container-lowest text-on-surface font-body-md text-body-md rounded-DEFAULT focus:outline-none appearance-none cursor-pointer">
                            <option value="10">Tampilkan 10 data</option>
                            <option value="25">Tampilkan 25 data</option>
                            <option value="50">Tampilkan 50 data</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-outline pointer-events-none text-[20px]">expand_more</span>
                    </div>
                    <div class="flex items-center gap-space-sm shrink-0">
                        <button class="h-11 px-4 rounded-DEFAULT bg-surface-container-lowest hover:bg-surface-container text-on-surface font-label-md text-label-md flex items-center gap-2 transition-colors shadow-sm" title="Ekspor Excel" type="button">
                            <span class="material-symbols-outlined text-[18px] text-tertiary">table_view</span>
                            <span class="hidden sm:inline">Excel</span>
                        </button>
                        <button class="h-11 px-4 rounded-DEFAULT bg-surface-container-lowest hover:bg-surface-container text-on-surface font-label-md text-label-md flex items-center gap-2 transition-colors shadow-sm" title="Cetak Daftar" type="button">
                            <span class="material-symbols-outlined text-[18px] text-primary">print</span>
                            <span class="hidden sm:inline">Cetak</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="overflow-x-auto rounded-DEFAULT">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-primary-fixed/40 text-on-primary-fixed-variant">
                            <th class="py-3.5 px-4 font-label-md text-label-md uppercase tracking-wider rounded-l-DEFAULT text-center">No</th>
                            <th class="py-3.5 px-4 font-label-md text-label-md uppercase tracking-wider text-center">Kode</th>
                            <th class="py-3.5 px-4 font-label-md text-label-md uppercase tracking-wider">Nama Barang</th>
                            <th class="py-3.5 px-4 font-label-md text-label-md uppercase tracking-wider text-center">Kategori</th>
                            <th class="py-3.5 px-4 font-label-md text-label-md uppercase tracking-wider text-center">Satuan</th>
                            <th class="py-3.5 px-4 font-label-md text-label-md uppercase tracking-wider text-center">Stok</th>
                            <th class="py-3.5 px-4 font-label-md text-label-md uppercase tracking-wider text-center">Minimum</th>
                            <th class="py-3.5 px-4 font-label-md text-label-md uppercase tracking-wider text-center">Status Stok</th>
                            <th class="py-3.5 px-4 font-label-md text-label-md uppercase tracking-wider">Lokasi</th>
                            <th class="py-3.5 px-4 font-label-md text-label-md uppercase tracking-wider text-center">Status</th>
                            <th class="py-3.5 px-4 font-label-md text-label-md uppercase tracking-wider text-center rounded-r-DEFAULT">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-0 text-on-surface font-body-md text-body-md">
                        <tr class="hover:bg-surface-container-low transition-colors duration-150">
                            <td class="py-4 px-4 font-body-sm text-body-sm text-on-surface-variant text-center">1</td>
                            <td class="py-4 px-4 font-label-md text-label-md text-primary font-semibold text-center">ATK-001</td>
                            <td class="py-4 px-4 font-title-md text-title-md font-bold text-on-surface">KERTAS A4</td>
                            <td class="py-4 px-4 text-center"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-surface-container text-on-surface-variant">ATK</span></td>
                            <td class="py-4 px-4 text-center"><span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-surface-container-high text-on-surface-variant font-semibold uppercase tracking-wider">BOX</span></td>
                            <td class="py-4 px-4 text-center font-title-md text-title-md font-semibold text-on-surface">10</td>
                            <td class="py-4 px-4 text-on-surface-variant font-body-md text-body-md text-center">5</td>
                            <td class="py-4 px-4 text-center"><div class="flex justify-center items-center"><span class="inline-flex items-center gap-1 px-3 py-1 rounded-full font-label-sm text-label-sm bg-tertiary-fixed text-on-tertiary-fixed font-semibold"><span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>Aman</span></div></td>
                            <td class="py-4 px-4 text-on-surface-variant font-body-sm text-body-sm">Learning center pusri</td>
                            <td class="py-4 px-4 text-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full font-label-sm text-label-sm bg-tertiary-fixed text-on-tertiary-fixed font-semibold">Aktif</span></td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button class="w-8 h-8 rounded-full bg-primary-fixed/50 hover:bg-primary-fixed text-on-primary-fixed-variant flex items-center justify-center transition-colors" title="Detail Barang" type="button"><span class="material-symbols-outlined text-[17px]">visibility</span></button>
                                    <button class="w-8 h-8 rounded-full bg-surface-container-high hover:bg-surface-variant text-on-surface flex items-center justify-center transition-colors" title="Edit Barang" type="button"><span class="material-symbols-outlined text-[17px]">edit</span></button>
                                    <button class="w-8 h-8 rounded-full bg-error-container hover:bg-error hover:text-on-error text-on-error-container flex items-center justify-center transition-colors" title="Nonaktifkan" type="button"><span class="material-symbols-outlined text-[17px]">block</span></button>
                                    <button class="w-8 h-8 rounded-full bg-error-container hover:bg-error hover:text-on-error text-on-error-container flex items-center justify-center transition-colors" title="Hapus" type="button"><span class="material-symbols-outlined text-[17px]">delete</span></button>
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-surface-container-low/40 hover:bg-surface-container-low transition-colors duration-150">
                            <td class="py-4 px-4 font-body-sm text-body-sm text-on-surface-variant text-center">2</td>
                            <td class="py-4 px-4 font-label-md text-label-md text-primary font-semibold text-center">atk-002</td>
                            <td class="py-4 px-4 font-title-md text-title-md font-bold text-on-surface">kertas a5</td>
                            <td class="py-4 px-4 text-center"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-surface-container text-on-surface-variant">ATK</span></td>
                            <td class="py-4 px-4 text-center"><span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-surface-container-high text-on-surface-variant font-semibold uppercase tracking-wider">PCS</span></td>
                            <td class="py-4 px-4 text-center font-title-md text-title-md font-bold text-error">0</td>
                            <td class="py-4 px-4 text-on-surface-variant font-body-md text-body-md text-center">12</td>
                            <td class="py-4 px-4 text-center"><div class="flex justify-center items-center"><span class="inline-flex items-center gap-1 px-3 py-1 rounded-full font-label-sm text-label-sm bg-error-container text-on-error-container font-semibold"><span class="w-1.5 h-1.5 rounded-full bg-error"></span>Habis</span></div></td>
                            <td class="py-4 px-4 text-on-surface-variant font-body-sm text-body-sm">diklat</td>
                            <td class="py-4 px-4 text-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full font-label-sm text-label-sm bg-tertiary-fixed text-on-tertiary-fixed font-semibold">Aktif</span></td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button class="w-8 h-8 rounded-full bg-primary-fixed/50 hover:bg-primary-fixed text-on-primary-fixed-variant flex items-center justify-center transition-colors" title="Detail Barang" type="button"><span class="material-symbols-outlined text-[17px]">visibility</span></button>
                                    <button class="w-8 h-8 rounded-full bg-surface-container-high hover:bg-surface-variant text-on-surface flex items-center justify-center transition-colors" title="Edit Barang" type="button"><span class="material-symbols-outlined text-[17px]">edit</span></button>
                                    <button class="w-8 h-8 rounded-full bg-error-container hover:bg-error hover:text-on-error text-on-error-container flex items-center justify-center transition-colors" title="Nonaktifkan" type="button"><span class="material-symbols-outlined text-[17px]">block</span></button>
                                    <button class="w-8 h-8 rounded-full bg-error-container hover:bg-error hover:text-on-error text-on-error-container flex items-center justify-center transition-colors" title="Hapus" type="button"><span class="material-symbols-outlined text-[17px]">delete</span></button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-container-low transition-colors duration-150">
                            <td class="py-4 px-4 font-body-sm text-body-sm text-on-surface-variant text-center">3</td>
                            <td class="py-4 px-4 font-label-md text-label-md text-primary font-semibold text-center">ATK-003</td>
                            <td class="py-4 px-4 font-title-md text-title-md font-bold text-on-surface">Pulpen Hitam</td>
                            <td class="py-4 px-4 text-center"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-surface-container text-on-surface-variant">ATK</span></td>
                            <td class="py-4 px-4 text-center"><span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-surface-container-high text-on-surface-variant font-semibold uppercase tracking-wider">PCS</span></td>
                            <td class="py-4 px-4 text-center font-title-md text-title-md font-semibold text-on-surface">8</td>
                            <td class="py-4 px-4 text-on-surface-variant font-body-md text-body-md text-center">10</td>
                            <td class="py-4 px-4 text-center"><div class="flex justify-center items-center"><span class="inline-flex items-center gap-1 px-3 py-1 rounded-full font-label-sm text-label-sm bg-surface-variant text-on-secondary-fixed-variant font-semibold"><span class="w-1.5 h-1.5 rounded-full bg-secondary-container"></span>Menipis</span></div></td>
                            <td class="py-4 px-4 text-on-surface-variant font-body-sm text-body-sm">Gudang A</td>
                            <td class="py-4 px-4 text-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full font-label-sm text-label-sm bg-tertiary-fixed text-on-tertiary-fixed font-semibold">Aktif</span></td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button class="w-8 h-8 rounded-full bg-primary-fixed/50 hover:bg-primary-fixed text-on-primary-fixed-variant flex items-center justify-center transition-colors" title="Detail Barang" type="button"><span class="material-symbols-outlined text-[17px]">visibility</span></button>
                                    <button class="w-8 h-8 rounded-full bg-surface-container-high hover:bg-surface-variant text-on-surface flex items-center justify-center transition-colors" title="Edit Barang" type="button"><span class="material-symbols-outlined text-[17px]">edit</span></button>
                                    <button class="w-8 h-8 rounded-full bg-error-container hover:bg-error hover:text-on-error text-on-error-container flex items-center justify-center transition-colors" title="Nonaktifkan" type="button"><span class="material-symbols-outlined text-[17px]">block</span></button>
                                    <button class="w-8 h-8 rounded-full bg-error-container hover:bg-error hover:text-on-error text-on-error-container flex items-center justify-center transition-colors" title="Hapus" type="button"><span class="material-symbols-outlined text-[17px]">delete</span></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection