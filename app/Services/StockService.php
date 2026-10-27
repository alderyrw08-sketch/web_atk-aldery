<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\StockHistory;
use Illuminate\Validation\ValidationException;

class StockService
{
    public function change(int $itemId, int $quantity, string $type, ?int $referenceId, int $userId, ?string $notes = null): void
    {
        $barang = Barang::lockForUpdate()->findOrFail($itemId);

        $before = $barang->stock;
        $after = $before + $quantity;

        if ($after < 0) {
            throw ValidationException::withMessages([
                'items' => "Stok {$barang->name} tidak cukup (tersedia {$before}).",
            ]);
        }

        $barang->stock = $after;
        $barang->save();

        StockHistory::create([
            'item_id'          => $barang->id,
            'transaction_type' => $type,
            'reference_id'     => $referenceId,
            'stock_before'     => $before,
            'quantity'         => $quantity,
            'stock_after'      => $after,
            'user_id'          => $userId,
            'notes'            => $notes,
        ]);
    }
}