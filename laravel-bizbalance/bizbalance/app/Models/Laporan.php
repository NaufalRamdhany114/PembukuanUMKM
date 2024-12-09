<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'tb_laporan'; 
    protected $primaryKey = 'id_laporan';
    public $incrementing = true; 
    public $timestamps = true; 
    protected $fillable = ['tanggal', 'jumlah_pemasukan', 'jumlah_pengeluaran', 'jumlah_kewajiban'];
}
