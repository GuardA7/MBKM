@extends('admin.layouts.app')

@section('title', 'Tambah Kelas')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Kelas</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item">Kelas</li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>

            <!-- Alert Messages -->
            @if (session('tambah_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Tambah Berhasil!</strong> Kelas telah berhasil ditambahkan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif 

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus"></i> Tambah Kelas</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.kelas.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf <!-- CSRF token for security -->

                                <!-- Nama Kelas -->
                                <div class="mb-3">
                                    <label for="nama_kelas" class="form-label">Nama Kelas</label>
                                    <input type="text" name="nama_kelas"
                                        class="form-control @error('nama') is-invalid @enderror" id="nama_kelas"
                                        value="{{ old('nama_kelas') }}" placeholder="Masukan Nama Kelas" required>
                                    @error('nama_kelas')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <!-- Prodi Selection -->
                                <div class="mb-3">
                                    <label for="prodi_id" class="form-label">Prodi</label>
                                    <select name="prodi_id" id="prodi_id"
                                        class="form-select @error('prodi_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Prodi --</option>
                                        @foreach ($prodis as $prodi)
                                            <option value="{{ $prodi->id }}"
                                                {{ old('prodi_id') == $prodi->id ? 'selected' : '' }}>
                                                {{ $prodi->nama_prodi }}</option>
                                        @endforeach
                                    </select>

                                    @error('prodi_id')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                                <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
