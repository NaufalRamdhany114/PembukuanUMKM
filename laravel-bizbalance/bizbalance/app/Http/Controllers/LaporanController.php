<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class LaporanController extends Controller
{
    public function laporan()
    {
        $laporans = Laporan::all();
        return view('laporan.pencatatan', compact('laporans'));
    }

    public function create()
    {
        return view('laporan.pencatatan-entry');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah_pemasukan' => 'required|numeric|min:0',
            'jumlah_pengeluaran' => 'required|numeric|min:0',
            'jumlah_kewajiban' => 'required|numeric|min:0',
        ]);

        Laporan::create([
            'tanggal' => $request->tanggal,
            'jumlah_pemasukan' => $request->jumlah_pemasukan,
            'jumlah_pengeluaran' => $request->jumlah_pengeluaran,
            'jumlah_kewajiban' => $request->jumlah_kewajiban,
        ]);

        return redirect()->route('laporan.pencatatan');
    }

    public function edit($id_laporan)
    {
        $laporan = Laporan::findOrFail($id_laporan);
        return view('laporan.pencatatan-edit', compact('laporan'));
    }

    public function update(Request $request, $id_laporan)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'pendapatan' => 'required|numeric|min:0',
            'pengeluaran' => 'required|numeric|min:0',
            'kewajiban' => 'required|numeric|min:0',
        ]);

        $laporan = Laporan::findOrFail($id_laporan);

        $laporan->update([
            'tanggal' => $request->tanggal,
            'jumlah_pemasukan' => $request->pendapatan,
            'jumlah_pengeluaran' => $request->pengeluaran,
            'jumlah_kewajiban' => $request->kewajiban,
        ]);

        return redirect()->route('laporan.pencatatan');
    }

    public function delete($id_laporan)
    {
        $laporan = Laporan::find($id_laporan);

        if (!$laporan) {
            return redirect()->route('laporan.pencatatan')->with('error', 'Laporan tidak ditemukan!');
        }

        return view('laporan.pencatatan-hapus', compact('laporan'));
    }

    public function destroy($id_laporan)
    {
        $laporan = Laporan::find($id_laporan);

        if (!$laporan) {
            return redirect()->route('laporan.pencatatan');
        }

        $laporan->delete();

        return redirect()->route('laporan.pencatatan')->with('success', 'Laporan berhasil dihapus.');
    }
    public function cetak()
    {
        $laporans = Laporan::all();
        $pdf = Pdf::loadview('laporan.pencatatan-cetak', compact('laporans'));
        return $pdf->download('laporan-keuangan.pdf');
    }

}
