
<?php


use App\Models\Barang;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangsImport implements ToCollection, WithHeadingRow
{
    public int $berhasil = 0;

    public array $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $baris = $index + 2;

            $code = trim((string) ($row['code'] ?? ''));
            $name = trim((string) ($row['name'] ?? ''));
            $categoryName = trim((string) ($row['category'] ?? ''));
            $unitName = trim((string) ($row['unit'] ?? ''));

            if (
                $code === '' ||
                $name === '' ||
                $categoryName === '' ||
                $unitName === ''
            ) {
                $this->errors[] =
                    "Baris {$baris}: kode, nama, kategori, dan satuan wajib diisi.";
                continue;
            }

            if (Barang::where('code', $code)->exists()) {
                $this->errors[] =
                    "Baris {$baris}: kode barang {$code} sudah terdaftar.";
                continue;
            }

            $category = Category::where('name', $categoryName)->first();
            $unit = Unit::where('name', $unitName)->first();

            if (!$category) {
                $this->errors[] =
                    "Baris {$baris}: kategori {$categoryName} tidak ditemukan.";
                continue;
            }

            if (!$unit) {
                $this->errors[] =
                    "Baris {$baris}: satuan {$unitName} tidak ditemukan.";
                continue;
            }

            $stock = $row['stock'] ?? 0;
            $minimumStock = $row['minimum_stock'] ?? 0;

            if (
                !is_numeric($stock) ||
                !is_numeric($minimumStock) ||
                $stock < 0 ||
                $minimumStock < 0
            ) {
                $this->errors[] =
                    "Baris {$baris}: stok dan stok minimum harus berupa angka tidak negatif.";
                continue;
            }

            Barang::create([
                'code'          => $code,
                'name'          => $name,
                'category_id'   => $category->id,
                'unit_id'       => $unit->id,
                'stock'         => $stock,
                'minimum_stock' => $minimumStock,
                'location'      => $row['location'] ?? null,
                'description'   => $row['description'] ?? null,
                'status'        => true,
            ]);

            $this->berhasil++;
        }
    }
}
