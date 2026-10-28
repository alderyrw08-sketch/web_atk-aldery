<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'ATK',
            'Perlengkapan',
            'Kertas & Dokumen',
            'Tinta & Ribbon Printer',
            'Elektronik & Aksesoris',
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat] = Category::firstOrCreate(['name' => $cat]);
        }

        $units = ['BOX', 'PCS', 'RIM', 'UNIT', 'PACK', 'SET'];
        $unitModels = [];
        foreach ($units as $unit) {
            $unitModels[$unit] = Unit::firstOrCreate(['name' => $unit]);
        }

        $suppliers = [
            [
                'name' => 'PT Pusri Logistik Mandiri',
                'phone' => '0711-712222',
                'address' => 'Jl. Mayor Zen, Palembang',
            ],
            [
                'name' => 'CV Sumber Makmur ATK',
                'phone' => '0711-354123',
                'address' => 'Jl. Jend. Sudirman No. 45, Palembang',
            ],
            [
                'name' => 'Toko ATK Sejahtera',
                'phone' => '0812-78901234',
                'address' => 'Jl. Veteran No. 12, Palembang',
            ],
        ];

        foreach ($suppliers as $sup) {
            Supplier::firstOrCreate(['name' => $sup['name']], $sup);
        }

        $items = [
            [
                'code' => 'ATK-001',
                'name' => 'KERTAS A4',
                'category_id' => $categoryModels['ATK']->id,
                'unit_id' => $unitModels['BOX']->id,
                'stock' => 10,
                'minimum_stock' => 5,
                'location' => 'Learning center pusri',
                'description' => 'Kertas HVS A4 80 gram PaperOne',
                'status' => true,
            ],
            [
                'code' => 'ATK-002',
                'name' => 'Kertas A5',
                'category_id' => $categoryModels['ATK']->id,
                'unit_id' => $unitModels['PCS']->id,
                'stock' => 0,
                'minimum_stock' => 12,
                'location' => 'Diklat',
                'description' => 'Kertas HVS A5 70 gram',
                'status' => true,
            ],
            [
                'code' => 'ATK-003',
                'name' => 'Pulpen Hitam',
                'category_id' => $categoryModels['ATK']->id,
                'unit_id' => $unitModels['PCS']->id,
                'stock' => 8,
                'minimum_stock' => 10,
                'location' => 'Gudang A',
                'description' => 'Ballpoint Pilot G2 0.5 Black',
                'status' => true,
            ],
            [
                'code' => 'ATK-004',
                'name' => 'Stapler',
                'category_id' => $categoryModels['Perlengkapan']->id,
                'unit_id' => $unitModels['UNIT']->id,
                'stock' => 25,
                'minimum_stock' => 5,
                'location' => 'Gudang B',
                'description' => 'Stapler Max HD-10',
                'status' => false,
            ],
        ];

        foreach ($items as $item) {
            Barang::firstOrCreate(['code' => $item['code']], $item);
        }
    }
}
