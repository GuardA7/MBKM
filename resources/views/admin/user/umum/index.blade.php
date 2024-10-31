@extends('admin.layouts.app')

@section('title', 'Pelatihan')

@section('content')

<style>
    /* Limit the width of the Deskripsi column */
    .table th.text-nowrap,
    .table td.text-nowrap {
        white-space: nowrap;
        max-width: 150px; /* Adjust max width as needed */
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Add horizontal scrolling for the table */
    .table-responsive {
        overflow-x: auto;
    }

    /* Specific styling for the Deskripsi column */
    .table td.deskripsi {
        max-width: 100px; /* Set a smaller max width for the Deskripsi column */
        min-width: 80px;  /* Set a minimum width if necessary */
    }
</style>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Umum</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item">Umum</li>
        </ol>

        @if (session('tambah_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Tambah Berhasil!</strong> Umum telah berhasil ditambahkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <a href="{{ route('admin.umum.create') }}" class="btn btn-sm btn-success mb-2">
            <i class="fas fa-plus"></i> Tambah Umum
        </a>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> Data Umum
            </div>
            <div class="card-body">
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table id="umumTable" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Profile</th>
                                <th>Nama Umum</th>
                                <th>NIDN</th>
                                <th>Jenis Kelamin</th>
                                <th>No HP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</main>

@push('script')
<script>
    $(document).ready(function() {
        var table = $('#umumTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.umum.index') }}",
            responsive: true,
            columns: [
                { data: 'id', name: 'id' },
                {
                            data: 'profile',
                            name: 'profile',
                            render: function(data) {
                                if (data) {
                                    return `<img src="{{ asset('img/user/mahasiswa') }}/${data}" alt="Gambar" style="max-width: 50px; max-height: 50px;">`;
                                } else {
                                    return 'No Image';
                                }
                            },
                            orderable: false,
                            searchable: false
                        },
                { data: 'nama', name: 'nama' },
                { data: 'nik', name: 'nik' },
                { data: 'jenis_kelamin', name: 'jenis_kelamin' },
                { data: 'no_hp', name: 'no_hp' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <a class="btn btn-info btn-sm mx-1" href="{{ route('admin.umum.index', '') }}/${row.id}">
                                <i class="fas fa-eye"></i> 
                            </a>
                            <a class="btn btn-primary btn-sm mx-1" href="{{ route('admin.umum.edit', '') }}/${row.id}">
                                <i class="fas fa-pen"></i> 
                            </a>
                            <form action="{{ route('admin.umum.destroy', '') }}/${row.id}" method="POST" class="d-inline delete-form">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="button" class="btn btn-danger btn-sm delete-button" data-id="${row.id}">
                                    <i class="fas fa-trash"></i> 
                                </button>
                            </form>`;
                    }
                }
            ]
        });

        // Handle delete
        $(document).on('click', '.delete-button', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var url = form.attr('action');
            var deleteId = $(this).data('id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Hapus umum ini? ID=" + deleteId,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Terhapus!', response.message, 'success');
                                table.ajax.reload(null, false);
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'Gagal menghapus data.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

@endsection
