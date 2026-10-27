<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    protected $fillable = ['opname_number', 'opname_date', 'user_id', 'status', 'notes'];

    protected function casts(): array
    {
        return ['opname_date' => 'date'];
    }

    public function user() { return $this->belongsTo(User::class); }
    public function details() { return $this->hasMany(StockOpnameDetail::class); }
}