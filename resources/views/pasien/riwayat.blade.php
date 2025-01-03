@extends('layouts.pasien')

@section('title', 'Riwayat Pemeriksaan')

@section('content')
    <div class="container mt-4">
        <h1>Riwayat Pemeriksaan</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Jadwal Periksa</th>
                    <th>Keluhan</th>
                    <th>Status</th>
                    <th>Antrian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftarPoli as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->hari }}, {{ $item->jam_mulai }} - {{ $item->jam_selesai }}</td>
                        <td>{{ $item->keluhan }}</td>
                        <td>{{ $status[$item->id] }}</td>
                        <td>{{ $status[$item->id] == 'Menunggu diperiksa' ? $nomor_antrian[$item->id] : '-' }}</td>
                        <td>
                            @if ($status[$item->id] == 'Sudah diperiksa')
                                <button class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#detailModal-{{ $item->id }}">
                                    Detail
                                </button>
                            @else
                                -
                            @endif
                        </td>
                    </tr>

                    {{-- modal --}}
                    <div class="modal fade" id="detailModal-{{ $item->id }}" data-backdrop="static" data-keyboard="false"
                        tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-right">
                                        <i class="fa fa-close close" data-bs-dismiss="modal"></i>
                                    </div>

                                    <div class="px-4 py-5">
                                        <h4 class="theme-color mb-5 text-left">Nomor Antrean
                                            <strong>{{ $nomor_antrian[$item->id] ?? 'N/A' }}</strong>
                                        </h4>
                                        <h5 class="text-uppercase">{{ $item->pasien_name }}</h5>

                                        <span class="theme-color">Riwayat Pemeriksaan</span>
                                        <div class="mb-3">
                                            <hr class="new1" style="border-top: 2px dashed #000;margin: 0.4rem 0;">
                                        </div>

                                        @if ($detailPeriksa[$item->id])
                                            <div class="d-flex justify-content-between">
                                                <small>Tanggal Periksa</small>
                                                <small>{{ Carbon\Carbon::parse($detailPeriksa[$item->id]->tgl_periksa)->format('Y-m-d') }}</small>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <small>Catatan Dokter</small>
                                                <small>{{ $detailPeriksa[$item->id]->catatatn }}</small>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <small>Biaya Pemeriksaan</small>
                                                <small>
                                                    <strong>Rp{{ number_format($detailPeriksa[$item->id]->biaya_periksa, 0, ',', '.') }}</strong>
                                                </small>
                                            </div>
                                            @if ($detailPeriksa[$item->id] && !empty($detailPeriksa[$item->id]->obat_ids))
                                                <div class="d-flex justify-content-between">
                                                    <small>Obat</small>
                                                    <small>
                                                        <ul>
                                                            @foreach ($detailPeriksa[$item->id]->detailPeriksa as $obat)
                                                                <li>{{ $obat->obat->nama_obat }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </small>
                                                </div>
                                            @else
                                                <p>obat hilang</p>
                                            @endif
                                        @else
                                            <p>Data pemeriksaan belum tersedia.</p>
                                        @endif

                                        <div class="mb-3">
                                            <hr class="new1" style="border-top: 2px dashed #000;margin: 0.4rem 0;">
                                        </div>

                                        <div class="text-center mt-5">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="window.print()">Print</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                @empty
                    <tr class="text-center">
                        <td colspan="6">Belum ada riwayat pemeriksaan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
