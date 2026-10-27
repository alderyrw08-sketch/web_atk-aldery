@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px;">
    <h3>Tambah Role</h3>

    <form action="{{ route('roles.store') }}" method="POST" class="mt-3">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Role</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="form-control @error('name') is-invalid @enderror">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <label class="form-label">Permission</label>
        <div class="row">
            @foreach ($permissions as $module => $items)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-header py-1"><strong>{{ ucfirst($module) }}</strong></div>
                        <div class="card-body py-2">
                            @foreach ($items as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                           value="{{ $permission->name }}" id="p{{ $permission->id }}"
                                           {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="p{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection