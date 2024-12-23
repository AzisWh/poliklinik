@extends('layouts.pasien')

@section('title', 'Pasien Dashboard')

@section('content')
    <div class="container">
        <div class="py-5">
            <div class="card">
                <div class="card-header">
                    <h2>Poli yang Tersedia</h2>
                </div>

                <div class="card-body">
                    {{-- Filter berdasarkan poli --}}
                    <form method="GET" action="{{ route('pasien.poli') }}">
                        <select name="id_poli" class="form-select" onchange="this.form.submit()">
                            <option value="">Pilih Poli</option>
                            @foreach ($poli as $item)
                                <option value="{{ $item->id }}" {{ request('id_poli') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    {{-- Tabel Jadwal --}}
                    @if (count($jadwal) > 0)
                        <div class="table-responsive mt-4">
                            <table id="jadwal_table" class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Dokter</th>
                                        <th>Hari</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Daftar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jadwal as $item)
                                        <tr>
                                            <td>Dr. {{ $item->dokter->name }}</td>
                                            <td>{{ $item->hari }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $item->jam_mulai }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-danger">{{ $item->jam_selesai }}</span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm"
                                                    onclick="showModal({{ $item }})">Daftar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="mt-4 alert alert-info">
                            Tidak ada jadwal untuk poli ini.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="daftarModal" tabindex="-1" aria-labelledby="daftarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="daftarForm" method="POST" action="{{ route('pasien.poli.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="daftarModalLabel">Form Pendaftaran Poli</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_jadwal" id="id_jadwal">
                        <input type="hidden" name="id_pasien" value="{{ $user->id ?? '' }}">

                        <div class="mb-3">
                            <label for="nama_pasien" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="nama_pasien" value="{{ $user->name ?? '' }}"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label for="nama_poli" class="form-label">Poli</label>
                            <input type="text" class="form-control" id="nama_poli" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="nama_dokter" class="form-label">Dokter</label>
                            <input type="text" class="form-control" id="nama_dokter" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="keluhan" class="form-label">Keluhan</label>
                            <textarea class="form-control" name="keluhan" id="keluhan" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showModal(jadwal) {
            $('#id_jadwal').val(jadwal.id);
            $('#nama_poli').val(jadwal.dokter.poli?.name || '');
            $('#nama_dokter').val(jadwal.dokter.name || '');
            $('#daftarModal').modal('show');
        }
    </script>
@endsection
