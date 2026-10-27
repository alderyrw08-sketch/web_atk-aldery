@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h3>Laporan</h3>
    <p class="text-muted">Pilih laporan yang ingin dilihat.</p>

    <div class="row g-3">
        @foreach ([
            'stock-in'  => 'Laporan Barang Masuk',
            'stock-out' => 'Laporan Barang Keluar',
            'stock'     => 'Laporan Stok',
            'usage'     => 'Laporan Penggunaan ATK',
            'opname'    => 'Laporan Stock Opname',
        ] as $key => $label)
            <div class="col-md-4">
                <a href="{{ route('reports.show', $key) }}" class="card text-decoration-none text-dark h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-0">{{ $label }}</h5>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection