@extends('layouts.dokter')

@section('title', 'Periksa Dashboard')

@section('content')

    @if ($daftarPoli->isEmpty())
        <p>Tidak ada pasien yang terdaftar untuk jadwal Anda.</p>
    @else
        <div class="card">
            <div class="card-header">
                <h2>Daftar Pasien</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-dark">
                    <thead>
                        <tr class="text-white">
                            <th>No</th>
                            <th>Nama Pasien</th>
                            <th>Keluhan</th>
                            <th>No Antrian</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftarPoli as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->pasien->name ?? '-' }}</td>
                                <td>{{ $item->keluhan }}</td>
                                <td class="text-center">
                                    <span class="badge badge-primary">{{ $item->no_antrian }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-block">Periksa</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @endif
@endsection
