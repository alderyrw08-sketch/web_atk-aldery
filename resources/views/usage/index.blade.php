@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Penggunaan ATK</h3>

    <form method="GET" action="{{ route('usage.index') }}" class="row g-2 mt-2">
        <div class="col-md-2">
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control" title="Dari tanggal">
        </div>
        <div class="col-md-2">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control" title="Sampai tanggal">
        </div>
        <div class="col-md-3">
            <input type="text" name="department" value="{{ request('department') }}" class="form-control" placeholder="Departemen">
        </div>
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
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-dark">Filter</button>
            <a href="{{ route('usage.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <div class="row mt-3 g-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><strong>Total per Barang</strong></div>
                <ul class="list-group list-group-flush">
                    @forelse ($perBarang as $row)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $row['name'] }}</span>
                            <strong>{{ $row['total'] }} {{ $row['unit'] }}</strong>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada data</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><strong>Total per Departemen</strong></div>
                <ul class="list-group list-group-flush">
                    @forelse ($perDepartemen as $dept => $total)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $dept }}</span>
                            <strong>{{ $total }}</strong>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada data</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3 bg-white">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Penerima</th>
                    <th>Departemen</th>
                    <th>Keperluan</th>
                    <th>Petugas</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($details as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->stockOut->transaction_date->format('d-m-Y') }}</td>
                        <td>{{ $detail->item->name ?? '-' }}</td>
                        <td>{{ $detail->quantity }} {{ $detail->item->unit->name ?? '' }}</td>
                        <td>{{ $detail->stockOut->recipient }}</td>
                        <td>{{ $detail->stockOut->department }}</td>
                        <td>{{ $detail->stockOut->purpose ?: '-' }}</td>
                        <td>{{ $detail->stockOut->user->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data penggunaan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection