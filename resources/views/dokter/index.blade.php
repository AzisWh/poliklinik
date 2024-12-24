@extends('layouts.dokter')

@section('title', 'Dokter Dashboard')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h2>Profile</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="bg-primary">
                    <tr class="text-white">
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No Hp</th>
                        <th>Nama Poli</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $dokter)
                        <tr>
                            <td>{{ $dokter->name }}</td>
                            <td>{{ $dokter->alamat }}</td>
                            <td>{{ $dokter->no_hp }}</td>
                            <td>{{ $dokter->poli->name }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editDokter({{ $dokter }})">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data Dokter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nama Dokter:</label>
                            <input type="text" class="form-control" name="name" id="edit_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_alamat" class="form-label">Alamat:</label>
                            <input type="text" class="form-control" name="alamat" id="edit_alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_no_hp" class="form-label">No Hp:</label>
                            <input type="text" class="form-control" name="no_hp" id="edit_no_hp" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_id_poli" class="form-label">Nama Poli:</label>
                            <select class="form-control" name="id_poli" id="edit_id_poli" required>
                                @foreach ($datapoli as $poli)
                                    <option value="{{ $poli->id }}">{{ $poli->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editDokter(dokter) {
            $('#editModalLabel').text('Edit Data Dokter');

            // Set action URL
            $('#editForm').attr('action', '/dokter/profile/' + dokter.id);

            // Set form values
            $('#edit_name').val(dokter.name);
            $('#edit_alamat').val(dokter.alamat);
            $('#edit_no_hp').val(dokter.no_hp);
            $('#edit_id_poli').val(dokter.id_poli);

            // Show modal
            $('#editModal').modal('show');
        }
    </script>
@endsection
