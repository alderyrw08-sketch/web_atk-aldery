<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOpnameDetail extends Model
{
    protected $fillable = [
        'stock_opname_id', 'item_id', 'system_stock', 'physical_stock', 'difference', 'notes',
    ];

    public function item() { return $this->belongsTo(Barang::class, 'item_id'); }
    public function stockOpname() { return $this->belongsTo(StockOpname::class); }
}