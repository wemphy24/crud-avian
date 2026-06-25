<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;
use App\Models\TableD;

// sebagai area toko 
class TableC extends Model
{
    protected $table = 'table_c';
    protected $fillable = [
        'kode_toko',
        'area_sales',
    ];

    // relasi ke table_a 
    public function toko(): BelongsTo
    {
        return $this->belongsTo(TableA::class, 'kode_toko', 'kode_toko_baru');
    }

    // relasi ke table_d via prefix area_sales
    public function sales(): Collection
    {
        return TableD::where('kode_sales', 'LIKE', $this->area_sales . '%')->get();
    }

    // scope filter by area
    public function scopeByArea($query, string $area)
    {
        return $query->where('area_sales', $area);
    }
}
