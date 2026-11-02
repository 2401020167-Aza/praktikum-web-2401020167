<?php

use Illuminate\Support\Facades\DB;

beforeEach(function () {
    // Siapkan skema tabel ruang & inventaris untuk lingkungan testing (kompatibel SQLite & MySQL)
    DB::statement('CREATE TABLE IF NOT EXISTS ruang (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nama_ruang VARCHAR(100) NOT NULL UNIQUE
    )');

    DB::statement('CREATE TABLE IF NOT EXISTS inventaris (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        kode_barang CHAR(10) NOT NULL UNIQUE,
        nama_barang VARCHAR(100) NOT NULL,
        nomor_aset VARCHAR(30) NOT NULL UNIQUE,
        tahun_perolehan SMALLINT NOT NULL,
        ruang_id INTEGER NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )');

    // Bersihkan data lama
    DB::statement('DELETE FROM inventaris');
    DB::statement('DELETE FROM ruang');

    // Data awal wajib
    DB::statement("INSERT INTO ruang (id, nama_ruang) VALUES (1, 'Lab Pemrograman'), (2, 'Lab Jaringan')");
    DB::statement("INSERT INTO inventaris (id, kode_barang, nama_barang, nomor_aset, tahun_perolehan, ruang_id) VALUES
        (1, 'IV00000001', 'Komputer Praktikum', 'AST-LAB-0001', 2023, 1),
        (2, 'IV00000002', 'Proyektor', 'AST-LAB-0002', 2022, 1),
        (3, 'IV00000003', 'Router', 'AST-LAB-0003', 2024, 2)
    ");
});

test('fitur 1 (Read): menampilkan 3 data awal dan master ruang pada indeks inventaris', function () {
    $response = $this->get('/inventaris');

    $response->assertOk()
        ->assertSee('IV00000001')
        ->assertSee('Komputer Praktikum')
        ->assertSee('AST-LAB-0001')
        ->assertSee('2023')
        ->assertSee('Lab Pemrograman')
        ->assertSee('IV00000002')
        ->assertSee('Proyektor')
        ->assertSee('IV00000003')
        ->assertSee('Router')
        ->assertSee('Lab Jaringan');
});

test('fitur 2 (Create valid): menyimpan data inventaris baru dan menampilkan umpan balik sukses', function () {
    $payload = [
        'kode_barang' => 'IV00000004',
        'nama_barang' => 'Switch Manageable',
        'nomor_aset' => 'AST-LAB-0004',
        'tahun_perolehan' => '2025',
        'ruang_id' => '2',
    ];

    $response = $this->post('/inventaris', $payload);

    $response->assertRedirect('/inventaris')
        ->assertSessionHas('berhasil', 'Data inventaris berhasil ditambahkan.');

    $this->assertDatabaseHas('inventaris', [
        'kode_barang' => 'IV00000004',
        'nama_barang' => 'Switch Manageable',
        'nomor_aset' => 'AST-LAB-0004',
        'tahun_perolehan' => 2025,
        'ruang_id' => 2,
    ]);
});

test('fitur 3 (Create tidak valid): menolak input kosong atau tidak sesuai ketentuan dan mempertahankan old input', function () {
    $payload = [
        'kode_barang' => 'IV1', // Tidak 10 karakter
        'nama_barang' => '',    // Kosong
        'nomor_aset' => 'NO',   // Kurang dari 5 karakter
        'tahun_perolehan' => '1998', // Kurang dari 2000
        'ruang_id' => '',       // Kosong
    ];

    $response = $this->from('/inventaris')->post('/inventaris', $payload);

    $response->assertRedirect('/inventaris')
        ->assertSessionHasErrors(['kode_barang', 'nama_barang', 'nomor_aset', 'tahun_perolehan', 'ruang_id']);
});

test('fitur 4 (Duplikat): menolak kode barang atau nomor aset yang sama tanpa merusak data', function () {
    $payload = [
        'kode_barang' => 'IV00000001', // Duplikat kode
        'nama_barang' => 'Komputer Baru',
        'nomor_aset' => 'AST-LAB-9999',
        'tahun_perolehan' => '2024',
        'ruang_id' => '1',
    ];

    $response = $this->from('/inventaris')->post('/inventaris', $payload);

    $response->assertRedirect('/inventaris')
        ->assertSessionHas('gagal', 'Kode barang atau nomor aset sudah terdaftar.');

    // Pastikan tidak ada record tambahan
    $count = DB::table('inventaris')->count();
    expect($count)->toBe(3);
});

test('fitur 5 (Update): menampilkan data lama pada form edit dan menyimpan perubahan', function () {
    // Cek form edit
    $editPage = $this->get('/inventaris/1/edit');
    $editPage->assertOk()
        ->assertSee('IV00000001')
        ->assertSee('Komputer Praktikum');

    // Kirim pembaruan
    $payload = [
        'kode_barang' => 'IV00000001',
        'nama_barang' => 'Komputer Praktikum Core i7',
        'nomor_aset' => 'AST-LAB-0001',
        'tahun_perolehan' => '2023',
        'ruang_id' => '1',
    ];

    $response = $this->put('/inventaris/1', $payload);

    $response->assertRedirect('/inventaris')
        ->assertSessionHas('berhasil', 'Data inventaris berhasil diperbarui.');

    $this->assertDatabaseHas('inventaris', [
        'id' => 1,
        'nama_barang' => 'Komputer Praktikum Core i7',
    ]);
});

test('fitur 6 (Konflik Update): menolak pembaruan jika kode barang atau nomor aset bentrok dengan data lain', function () {
    // Coba ubah data ID 1 agar nomor asetnya sama dengan ID 2
    $payload = [
        'kode_barang' => 'IV00000001',
        'nama_barang' => 'Komputer Praktikum',
        'nomor_aset' => 'AST-LAB-0002', // Milik ID 2
        'tahun_perolehan' => '2023',
        'ruang_id' => '1',
    ];

    $response = $this->from('/inventaris/1/edit')->put('/inventaris/1', $payload);

    $response->assertRedirect('/inventaris/1/edit')
        ->assertSessionHas('gagal', 'Kode barang atau nomor aset sudah digunakan inventaris lain.');
});

test('fitur 7 (Delete): menghapus data inventaris dengan form DELETE dan CSRF', function () {
    $response = $this->delete('/inventaris/3');

    $response->assertRedirect('/inventaris')
        ->assertSessionHas('berhasil', 'Data inventaris berhasil dihapus.');

    $this->assertDatabaseMissing('inventaris', [
        'id' => 3,
        'kode_barang' => 'IV00000003',
    ]);
});

test('fitur 8 (Pencarian): mencari kata kunci pada 3 kolom (kode_barang, nama_barang, nomor_aset)', function () {
    // Cari berdasarkan nama
    $this->get('/inventaris?q=Proyektor')
        ->assertOk()
        ->assertSee('Proyektor')
        ->assertDontSee('Router');

    // Cari berdasarkan kode
    $this->get('/inventaris?q=IV00000003')
        ->assertOk()
        ->assertSee('Router')
        ->assertDontSee('Komputer Praktikum');

    // Cari berdasarkan nomor aset
    $this->get('/inventaris?q=AST-LAB-0001')
        ->assertOk()
        ->assertSee('Komputer Praktikum')
        ->assertDontSee('Proyektor');
});

test('fitur 9 (Filter): menyaring daftar inventaris berdasarkan ruang laboratorium', function () {
    // Filter ke Lab Jaringan (ruang_id = 2)
    $response = $this->get('/inventaris?ruang_id=2');

    $response->assertOk()
        ->assertSee('Router')
        ->assertDontSee('Komputer Praktikum')
        ->assertDontSee('Proyektor');
});

test('fitur 10 & Modul 2: fungsi statusUsiaAset dan penampilan status Baru vs Lama', function () {
    expect(statusUsiaAset(2023))->toBe('Baru');
    expect(statusUsiaAset(2024))->toBe('Baru');
    expect(statusUsiaAset(2022))->toBe('Lama');
    expect(statusUsiaAset(2019))->toBe('Lama');

    // Cek penampilan pada halaman indeks
    $this->get('/inventaris')
        ->assertOk()
        ->assertSee('Baru') // untuk 2023 & 2024
        ->assertSee('Lama'); // untuk 2022
});
