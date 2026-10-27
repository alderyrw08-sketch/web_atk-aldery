<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name', 'address', 'phone', 'email', 'pic', 'status'];

    protected function casts(): array
    {
        return ['status' => 'boolean'];
    }
}