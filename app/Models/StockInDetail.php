<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockInDetail extends Model
{
    protected $fillable = ['stock_in_id', 'item_id', 'quantity', 'price'];

    public function item() { return $this->belongsTo(Barang::class, 'item_id'); }
    public function stockIn() { return $this->belongsTo(StockIn::class); }
}