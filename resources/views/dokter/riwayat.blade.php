@extends('layouts.dokter')

@section('title', 'Riwayat Pemeriksaan')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center">Riwayat Pemeriksaan</h1>

        @if ($riwayatPeriksa->isEmpty())
            <div class="alert alert-warning text-center mt-4">
                <strong>Belum ada riwayat pemeriksaan.</strong>
            </div>
        @else
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>No. Antrian</th>
                        <th>Nama Pasien</th>
                        <th>Keluhan</th>
                        <th>Tanggal Periksa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayatPeriksa as $key => $periksa)
                        <tr>
                            <td>{{ $periksa->daftarPoli->no_antrian }}</td>
                            <td>{{ $periksa->daftarPoli->pasien->name }}</td>
                            <td>{{ $periksa->daftarPoli->keluhan }}</td>
                            <td>{{ Carbon\Carbon::parse($periksa->tgl_periksa)->format('Y-m-d') }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $periksa->id }}">
                                    Lihat Detail
                                </button>
                            </td>
                        </tr>

                        {{-- modal --}}
                        <div class="modal fade" id="detailModal{{ $periksa->id }}" data-backdrop="static"
                            data-keyboard="false" tabindex="-1" aria-labelledby="detailModalLabel{{ $periksa->id }}"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body ">
                                        <div class="text-right"> <i class="fa fa-close close" data-dismiss="modal"></i>
                                        </div>

                                        <div class="px-4 py-5">

                                            <h4 class=" theme-color mb-5 text-left">Nomor Antrean
                                                <strong>{{ $periksa->daftarPoli->no_antrian }}</strong>
                                            </h4>
                                            <h5 class="text-uppercase">{{ $periksa->daftarPoli->pasien->name }}</h5>

                                            <span class="theme-color">Riwayat Pemeriksaan</span>
                                            <div class="mb-3">
                                                <hr class="new1"
                                                    style=" border-top: 2px dashed #5252524f;margin: 0.4rem 0;">
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <small>Keluhan</small>
                                                <small>{{ $periksa->daftarPoli->keluhan }}</small>
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <small>Tanggal Periksa</small>
                                                <small>{{ Carbon\Carbon::parse($periksa->tgl_periksa)->format('Y-m-d ') }}
                                                </small>
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <small>Obat</small>
                                                <small>
                                                    <ul>
                                                        @foreach ($periksa->detailPeriksa as $detail)
                                                            <li>{{ $detail->obat->nama_obat }} -
                                                                Rp{{ number_format($detail->obat->harga, 0, ',', '.') }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </small>
                                            </div>

                                            <div class="mb-3">
                                                <hr class="new1"
                                                    style=" border-top: 2px dashed #5252524f;margin: 0.4rem 0;">
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <small>Total Biaya</small>
                                                <small>Rp{{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</small>
                                            </div>

                                            <div class="text-center mt-5">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
