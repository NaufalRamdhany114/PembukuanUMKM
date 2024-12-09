@extends('layouts.app')

@section('title', 'Edit Pencatatan Keuangan')

@section('content')
<main>
    <section class="form-container">
        <h2>Edit Pencatatan Keuangan</h2>
        <form method="POST" action="{{ route('pencatatan.update', $laporan->id_laporan) }}">
            @csrf
            @method('PUT') 
            
            <label for="tanggal">Tanggal Transaksi</label>
            <input 
                type="date" 
                id="tanggal" 
                name="tanggal" 
                value="{{ old('tanggal', $laporan->tanggal) }}" 
                required>

            <label for="pendapatan">Pendapatan</label>
            <input 
                type="text" 
                id="pendapatan" 
                name="pendapatan" 
                value="{{ old('pendapatan', $laporan->jumlah_pemasukan) }}" 
                required 
                placeholder="Contoh: 1000000" 
                oninput="formatInputRupiah(event)">

            <label for="pengeluaran">Pengeluaran</label>
            <input 
                type="text" 
                id="pengeluaran" 
                name="pengeluaran" 
                value="{{ old('pengeluaran', $laporan->jumlah_pengeluaran) }}" 
                required 
                placeholder="Contoh: 500000" 
                oninput="formatInputRupiah(event)">

            <label for="kewajiban">Kewajiban</label>
            <input 
                type="text" 
                id="kewajiban" 
                name="kewajiban" 
                value="{{ old('kewajiban', $laporan->jumlah_kewajiban) }}" 
                required 
                placeholder="Contoh: 200000" 
                oninput="formatInputRupiah(event)">

            <div class="form-buttons">
                <button type="submit" class="btn-primary">Edit</button>
                <a href="{{ route('laporan.pencatatan') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </section>
</main>
@endsection
