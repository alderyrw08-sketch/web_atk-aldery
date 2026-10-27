@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px;">
    <h3>Edit Supplier</h3>

    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Supplier</label>
            <input type="text" name="name" value="{{ old('name', $supplier->name) }}"
                   class="form-control @error('name') is-invalid @enderror">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="address" rows="2" class="form-control">{{ old('address', $supplier->address) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $supplier->email) }}"
                   class="form-control @error('email') is-invalid @enderror">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">PIC (Penanggung Jawab)</label>
            <input type="text" name="pic" value="{{ old('pic', $supplier->pic) }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection