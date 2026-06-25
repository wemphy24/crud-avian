<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\TableC;
use App\Models\TableB;
use Illuminate\Database\Eloquent\Relations\HasMany;

// sebagai master toko
class TableA extends Model
{
    protected $table      = 'table_a';
    protected $primaryKey = 'kode_toko_baru';
    public $incrementing  = false;
    protected $keyType    = 'integer';
    protected $fillable = [
        'kode_toko_baru',
        'kode_toko_lama',
    ];

    // relasi ke table_c (langsung, kode baru)
    public function area(): HasOne
    {
        return $this->hasOne(TableC::class, 'kode_toko', 'kode_toko_baru');
    }

    // relasi ke table_b via kode_toko_baru
    public function transaksiKodeBaru(): HasMany
    {
        return $this->hasMany(TableB::class, 'kode_toko', 'kode_toko_baru');
    }

    // reklasi ke table_b via kode_toko_lama
    public function transaksiKodeLama(): HasMany
    {
        return $this->hasMany(TableB::class, 'kode_toko', 'kode_toko_lama');
    }

    // gabungan transaksi (kode baru + lama)
    public function semuaTransaksi(): Collection
    {
        return TableB::where('kode_toko', $this->kode_toko_baru)
            ->when($this->kode_toko_lama, function ($query) {
                $query->orWhere('kode_toko', $this->kode_toko_lama);
            })
            ->get();
    }

    // untuk ambil nama area toko
    public function getAreaSalesAttribute(): ?string
    {
        return $this->area?->area_sales;
    }

    // untuk ambil semua sales di area toko ini
    public function getSalesAttribute(): Collection
    {
        $area = $this->area_sales;

        if (!$area) {
            return new Collection();
        }
        return TableD::where('kode_sales', 'LIKE', $area . '%')->get();
    }
}
