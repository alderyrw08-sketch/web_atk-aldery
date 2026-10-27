@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h3>Dashboard</h3>
    <p class="text-muted">Halo, {{ Auth::user()->name }}. Ringkasan persediaan saat ini.</p>

    <div class="row g-3">
        @foreach ([
            ['Total Barang', $totalBarang, ''],
            ['Total Kategori', $totalKategori, ''],
            ['Total Supplier', $totalSupplier, ''],
            ['Total Stok', $totalStok, ''],
            ['Barang Masuk Hari Ini', $masukHariIni, 'text-success'],
            ['Barang Keluar Hari Ini', $keluarHariIni, 'text-primary'],
            ['Penggunaan ATK Bulan Ini', $penggunaanBulanIni, 'text-primary'],
        ] as [$label, $value, $class])
            <div class="col-6 col-lg-3">
                <div class="card text-center"><div class="card-body">
                    <div class="text-muted">{{ $label }}</div>
                    <div class="fs-2 fw-bold {{ $class }}">{{ $value }}</div>
                </div></div>
            </div>
        @endforeach
        <div class="col-6 col-lg-3">
            <div class="card text-center border-warning"><div class="card-body">
                <div class="text-muted">Stok Menipis</div>
                <div class="fs-2 fw-bold text-warning">{{ $barangMenipis }}</div>
            </div></div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card text-center border-danger"><div class="card-body">
                <div class="text-muted">Barang Habis</div>
                <div class="fs-2 fw-bold text-danger">{{ $barangHabis }}</div>
            </div></div>
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Barang Masuk vs Barang Keluar</strong>
                    <div class="btn-group btn-group-sm">
                        @foreach (['mingguan' => 'Mingguan', 'bulanan' => 'Bulanan', 'tahunan' => 'Tahunan'] as $key => $label)
                            <a href="{{ route('home', ['filter' => $key]) }}"
                               class="btn {{ $filter === $key ? 'btn-dark' : 'btn-outline-dark' }}">{{ $label }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="chartMasukKeluar" height="110"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header"><strong>Barang Paling Banyak Digunakan</strong></div>
                <ul class="list-group list-group-flush">
                    @forelse ($terbanyak as $row)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $row->item->name ?? '-' }}</span>
                            <strong>{{ $row->total }} {{ $row->item->unit->name ?? '' }}</strong>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada data</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header"><strong>Notifikasi Stok Minimum</strong></div>
        <div class="card-body">
            @forelse ($peringatan as $barang)
                <div class="alert {{ $barang->stock == 0 ? 'alert-danger' : 'alert-warning' }} py-2 mb-2">
                    <strong>{{ $barang->name }}</strong>
                    {{ $barang->stock == 0 ? 'habis.' : 'hampir habis.' }}
                    Stok saat ini: {{ $barang->stock }} {{ $barang->unit->name ?? '' }},
                    minimum: {{ $barang->minimum_stock }} {{ $barang->unit->name ?? '' }}
                </div>
            @empty
                <p class="text-muted mb-0">Semua stok dalam kondisi aman.</p>
            @endforelse
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('chartMasukKeluar'), {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [
                { label: 'Barang Masuk', data: @json($dataMasuk), backgroundColor: '#198754' },
                { label: 'Barang Keluar', data: @json($dataKeluar), backgroundColor: '#0d6efd' }
            ]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });
</script>
@endsection