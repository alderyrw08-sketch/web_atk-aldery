<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    protected $fillable = [
        'transaction_number', 'transaction_date', 'department', 'recipient',
        'purpose', 'user_id', 'notes', 'status',
    ];

    protected function casts(): array
    {
        return ['transaction_date' => 'date'];
    }

    public function user() { return $this->belongsTo(User::class); }
    public function details() { return $this->hasMany(StockOutDetail::class); }
}