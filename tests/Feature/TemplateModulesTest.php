<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TemplateModulesTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->seed(MasterDataSeeder::class);

        $this->adminUser = User::where('email', 'admin@mail.com')->first();
    }

    public function test_user_can_view_barang_list(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('barangs.index'));
        $response->assertStatus(200);
        $response->assertSee('Daftar Barang');
    }

    public function test_user_can_view_barang_create_page(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('barangs.create'));
        $response->assertStatus(200);
        $response->assertSee('Tambah Barang');
    }

    public function test_user_can_view_barang_show_page(): void
    {
        $barang = Barang::first();
        if ($barang) {
            $response = $this->actingAs($this->adminUser)->get(route('barangs.show', $barang));
            $response->assertStatus(200);
            $response->assertSee($barang->kode_barang);
        }
    }

    public function test_user_can_view_barang_edit_page(): void
    {
        $barang = Barang::first();
        if ($barang) {
            $response = $this->actingAs($this->adminUser)->get(route('barangs.edit', $barang));
            $response->assertStatus(200);
            $response->assertSee('Edit Barang');
        }
    }

    public function test_user_can_view_stock_in_list(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('stock-in.index'));
        $response->assertStatus(200);
        $response->assertSee('Barang Masuk');
    }

    public function test_user_can_view_stock_in_create_page(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('stock-in.create'));
        $response->assertStatus(200);
        $response->assertSee('Tambah Barang Masuk');
    }

    public function test_user_can_view_stock_out_list(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('stock-out.index'));
        $response->assertStatus(200);
        $response->assertSee('Barang Keluar');
    }

    public function test_user_can_view_stock_out_create_page(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('stock-out.create'));
        $response->assertStatus(200);
        $response->assertSee('Tambah Barang Keluar');
    }

    public function test_user_can_fetch_barang_datatables_json(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('barangs.data'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_user_can_fetch_stock_in_datatables_json(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('stock-in.data'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_user_can_fetch_stock_out_datatables_json(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('stock-out.data'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }
}
