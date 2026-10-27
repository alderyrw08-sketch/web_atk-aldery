<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOutDetail extends Model
{
    protected $fillable = ['stock_out_id', 'item_id', 'quantity'];

    public function item() { return $this->belongsTo(Barang::class, 'item_id'); }
    public function stockOut() { return $this->belongsTo(StockOut::class); }
}