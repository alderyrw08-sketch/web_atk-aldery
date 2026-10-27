<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $fillable = [
        'transaction_number', 'transaction_date', 'supplier_id',
        'document_number', 'user_id', 'notes', 'status',
    ];

    protected function casts(): array
    {
        return ['transaction_date' => 'date'];
    }

    public function supplier() { return $this->belongsTo(Supplier::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function details() { return $this->hasMany(StockInDetail::class); }
}