@extends('layouts.app')

@section('title', 'Pencatatan Keuangan')

@section('content')
<main>
    <section class="form-container">
        <h2>Pencatatan Keuangan</h2>
        <form action="{{ route('pencatatan.store') }}" method="POST">
            @csrf
            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" required>

            <label for="jumlah_pemasukan">Jumlah Pemasukan:</label>
            <input type="number" name="jumlah_pemasukan" required>

            <label for="jumlah_pengeluaran">Jumlah Pengeluaran:</label>
            <input type="number" name="jumlah_pengeluaran" required>

            <label for="jumlah_kewajiban">Jumlah Kewajiban:</label>
            <input type="number" name="jumlah_kewajiban" required>
        <div class="form-buttons">
            <button type="submit" class="btn-primary">Simpan</button>
            <a href="{{ route('laporan.pencatatan') }}" class="btn-secondary">Batal</a>
        </div>
        </form>

    </section>
</main>
@endsection
