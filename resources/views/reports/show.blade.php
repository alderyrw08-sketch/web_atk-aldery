@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3>{{ $report['title'] }}</h3>
        <div class="d-print-none d-flex gap-2">
            @can('laporan.export')
                <a href="{{ route('reports.pdf', array_merge(['type' => $type], request()->query())) }}" class="btn btn-danger">Export PDF</a>
                <a href="{{ route('reports.excel', array_merge(['type' => $type], request()->query())) }}" class="btn btn-success">Export Excel</a>
            @endcan
            <button type="button" onclick="window.print()" class="btn btn-outline-dark">Print</button>
            <a href="{{ route('reports.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
    <p class="text-muted">{{ $report['period'] }}</p>

    <form method="GET" action="{{ route('reports.show', $type) }}" class="row g-2 d-print-none">
        @if (in_array('date', $report['filters']))
            <div class="col-md-2">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control" title="Tanggal awal">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control" title="Tanggal akhir">
            </div>
        @endif

        @if (in_array('supplier', $report['filters']))
            <div class="col-md-3">
                <select name="supplier_id" class="form-select">
                    <option value="">Semua supplier</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        @if (in_array('department', $report['filters']))
            <div class="col-md-2">
                <input type="text" name="department" value="{{ request('department') }}" class="form-control" placeholder="Departemen">
            </div>
        @endif

        @if (in_array('item', $report['filters']))
            <div class="col-md-3">
                <select name="item_id" class="form-select">
                    <option value="">Semua barang</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}" {{ request('item_id') == $barang->id ? 'selected' : '' }}>
                            {{ $barang->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-dark">Filter</button>
            <a href="{{ route('reports.show', $type) }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3 bg-white">
            <thead>
                <tr>
                    @foreach ($report['headings'] as $heading)
                        <th>{{ $heading }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse ($report['rows'] as $row)
                    <tr>
                        @foreach ($row as $cell)
                            <td>{{ $cell }}</td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($report['headings']) }}" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @foreach ($report['summary'] as $label => $value)
        <p class="fw-bold mb-1">{{ $label }}: {{ $value }}</p>
    @endforeach
</div>
@endsection