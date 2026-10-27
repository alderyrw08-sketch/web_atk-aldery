<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'item_id', 'transaction_type', 'reference_id', 'stock_before',
        'quantity', 'stock_after', 'user_id', 'notes',
    ];

    public function item() { return $this->belongsTo(Barang::class, 'item_id'); }
    public function user() { return $this->belongsTo(User::class); }
}