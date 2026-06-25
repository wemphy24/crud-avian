<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TableD;
use App\Models\TableC;
use App\Models\TableA;

// sabagai transaksi
class TableB extends Model
{
    protected $table = 'table_b';
    protected $fillable = [
        'kode_toko',
        'nominal_transaksi',
    ];
    protected $casts = [
        'nominal_transaksi' => 'decimal:2',
    ];

    // relasi ke table_a, cek kode baru dulu, kalau tidak ada cek kode lama
    public function toko(): ?TableA
    {
        return TableA::where('kode_toko_baru', $this->kode_toko)
            ->orWhere('kode_toko_lama', $this->kode_toko)
            ->first();
    }

    // untuk ambil area_sales dari transaksi ini
    public function getAreaSalesAttribute(): ?string
    {
        return $this->toko()?->area_sales;
    }

    // untuk ambil semua sales yang handle transaksi ini
    public function getSalesAttribute()
    {
        $area = $this->area_sales;

        if (!$area) {
            return collect();
        }
        return TableD::where('kode_sales', 'LIKE', $area . '%')->get();
    }

    // scope filter transaksi by area
    public function scopeByArea($query, string $area)
    {
        $kodeToko = TableC::where('area_sales', $area)
            ->pluck('kode_toko');

        $kodeLama = TableA::whereIn('kode_toko_baru', $kodeToko)
            ->whereNotNull('kode_toko_lama')
            ->pluck('kode_toko_lama');

        return $query->whereIn('kode_toko', $kodeToko->merge($kodeLama));
    }
}
