@extends('layouts.pasien')

@section('title', 'Riwayat Pemeriksaan')

@section('content')
    <div class="container mt-4">
        <h1>Riwayat Pemeriksaan</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
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
                        <td>{{ $item->jadwal->tanggal ?? '-' }}</td>
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

                    <!-- Modal for Details -->
                    <div class="modal fade" id="detailModal-{{ $item->id }}" tabindex="-1"
                        aria-labelledby="detailModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailModalLabel">Detail Pemeriksaan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @if ($detailPeriksa[$item->id])
                                        <p><strong>Tanggal Periksa:</strong> {{ $detailPeriksa[$item->id]->tgl_periksa }}
                                        </p>
                                        <p><strong>Catatan Dokter:</strong> {{ $detailPeriksa[$item->id]->catatatn }}</p>
                                        <p><strong>Biaya Pemeriksaan:</strong> Rp.
                                            {{ number_format($detailPeriksa[$item->id]->biaya_periksa, 0, ',', '.') }}</p>
                                        @if ($detailPeriksa[$item->id]->detailPeriksa->isNotEmpty())
                                            <p><strong>Obat:</strong></p>
                                            <ul>
                                                @foreach ($detailPeriksa[$item->id]->detailPeriksa as $obat)
                                                    <li>{{ $obat->obat->nama_obat }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @else
                                        <p>Data pemeriksaan belum tersedia.</p>
                                    @endif
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
