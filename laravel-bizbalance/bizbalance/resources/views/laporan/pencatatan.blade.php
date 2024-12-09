@extends('layouts.app')

@section('title', 'Pencatatan Keuangan')

@section('content')
<div class="riwayat">
    <div class="tombol">
    <div class="tambah-data-container">
        <a href="{{ url('pencatatan-entry') }}" class="tambah-data-button">Tambah Data</a>
    </div>
    <div class="tambah-data-container">
        <a href="{{ route('pencatatan.cetak') }}"class="cetak-data-button">Cetak Data</a>
    </div>
    </div>
    <table>
        <tr>
            <th scope="col" style="width: 15%">Tanggal</th>
            <th scope="col" style="width: 15%">Pendapatan</th>
            <th scope="col" style="width: 15%">Pengeluaran</th>
            <th scope="col" style="width: 15%">Kewajiban</th>
            <th scope="col" style="width: 20%">Aksi</th>
        </tr>
        @forelse($laporans as $laporan)
        <tr>
            <td>{{ $laporan->tanggal }}</td>
            <td>Rp. {{ number_format($laporan->jumlah_pemasukan, 0, ',', '.') }}</td>
            <td>Rp. {{ number_format($laporan->jumlah_pengeluaran, 0, ',', '.') }}</td>
            <td>Rp. {{ number_format($laporan->jumlah_kewajiban, 0, ',', '.') }}</td>
            <td class="action-buttons">
                <form action="{{ route('pencatatan.edit', $laporan->id_laporan) }}" method="GET" style="display: inline;">
                    <button type="submit" class="edit-button">Edit</button>
                </form>

                <form action="{{ route('pencatatan.hapus', $laporan->id_laporan) }}" method="GET" style="display: inline;">
                    @csrf
                    <input type="hidden" name="id_laporan" value="{{ $laporan->id_laporan }}">
                    <button type="submit" class="delete-button">Delete</button>
                </form>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align: center;">Tidak ada data</td>
        </tr>
        @endforelse
    </table>
</div>
@endsection
