<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\TableC;
use App\Models\TableA;

// sebagai master sales
class TableD extends Model
{
    protected $table = 'table_d';
    protected $primaryKey = 'kode_sales';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'kode_sales',
        'nama_sales',
    ];
    public $timestamps = false;

    // untuk ambil prefix area dari kode_sales
    public function getPrefixAreaAttribute(): string
    {
        return substr($this->kode_sales, 0, 1);
    }


    // relasi ke table_c via prefix
    public function areaToko(): Collection
    {
        return TableC::where('area_sales', $this->prefix_area)->get();
    }


    // untuk ambil semua toko yang ditangani sales ini  
    public function getTokoAttribute(): Collection
    {
        $kodeToko = TableC::where('area_sales', $this->prefix_area)
            ->pluck('kode_toko');

        return TableA::whereIn('kode_toko_baru', $kodeToko)->get();
    }

    // mencari total transaksi yang ditangani sales ini
    public function getTotalTransaksiAttribute(): float
    {
        $kodeToko = TableC::where('area_sales', $this->prefix_area)
            ->pluck('kode_toko');

        $kodeLama = TableA::whereIn('kode_toko_baru', $kodeToko)
            ->whereNotNull('kode_toko_lama')
            ->pluck('kode_toko_lama');

        return TableB::whereIn('kode_toko', $kodeToko->merge($kodeLama))
            ->sum('nominal_transaksi');
    }

    // scope filter sales by area prefix
    public function scopeByArea($query, string $area)
    {
        return $query->where('kode_sales', 'LIKE', $area . '%');
    }
}
