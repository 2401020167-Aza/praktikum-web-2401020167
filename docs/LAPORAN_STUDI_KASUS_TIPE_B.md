# LAPORAN STUDI KASUS PRAKTIKUM PEMROGRAMAN WEB
## MODUL 1 SAMPAI MODUL 7: SISTEM INVENTARIS LABORATORIUM (TIPE B)

---

### IDENTITAS MAHASISWA
* **Nama Lengkap** : Shalsabyla Finta Azalea
* **NIM** : 2401020167
* **Program Studi** : Teknik Informatika
* **Mata Kuliah** : Praktikum Pemrograman Web (INF11197)
* **Semester / SKS** : V (Ganjil) / 1 SKS
* **Dosen Pengampu** :
  1. Berta Erwin Slam, S.T., M.Kom.
  2. Muhamad Radzi Rathomi, S.Kom., M.Cs.
  3. Nolan Efranda, M.Kom.
* **Fakultas** : Fakultas Teknik dan Teknologi Kemaritiman
* **Perguruan Tinggi** : Universitas Maritim Raja Ali Haji (UMRAH)
* **Tahun Akademik** : 2026/2027

---

## 1. PENDAHULUAN & TUJUAN
Berdasarkan dokumen **Soal Studi Kasus Praktikum Pemrograman Web (Modul 1 sampai Modul 7)**, praktikum individual ini mengukur pencapaian CPMK091 dan CPMK092. Kasus yang dikerjakan adalah **Tipe B: Sistem Inventaris Laboratorium**.

Tujuan praktikum ini adalah:
1. Merancang basis data relasional satu-ke-banyak dengan constraints integritas data (`PRIMARY KEY`, `FOREIGN KEY`, `UNIQUE`, `NOT NULL`, `CHECK`, `ON UPDATE CASCADE`, `ON DELETE RESTRICT`).
2. Mengembangkan antarmuka formulir dan tabel data menggunakan template engine Blade dengan HTML murni tanpa pustaka CSS/JS eksternal sesuai instruksi teknis.
3. Menerapkan pengolahan input aman di sisi server: sanitasi input (`trim`, `strip_tags`), validasi ketat, proteksi CSRF (`@csrf`), dan *method spoofing* (`PUT` dan `DELETE`).
4. Mengakses basis data menggunakan **Native PDO Prepared Statements** via `DB::connection()->getPdo()` untuk menjamin keamanan dari serangan SQL Injection.
5. Mengimplementasikan fitur pencarian multi-kolom (3 kolom) dan filter relasi tabel master.
6. Menerapkan fungsi PHP khusus `statusUsiaAset()` untuk menentukan status usia barang ('Baru' vs 'Lama') dan menampilkannya pada Blade.
7. Menerapkan mekanisme *error handling* menggunakan `try-catch`, pencatatan log dengan `report()`, dan respon pesan aman kepada pengguna.
8. Melakukan pengujian sistem mencakup 10 skenario wajib dan mencatat riwayat versi Git secara terstruktur.

---

## 2. RANCANGAN DATA DAN BASIS DATA (MODUL 4)

### A. Skema Tabel & Relasi
Sistem Inventaris Laboratorium menggunakan dua tabel yang saling berelasi satu-ke-banyak (One-to-Many): satu ruang laboratorium dapat memiliki banyak barang inventaris.

1. **Tabel Master: `ruang`**
   - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
   - `nama_ruang`: `VARCHAR(100) NOT NULL UNIQUE`

2. **Tabel Utama: `inventaris`**
   - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
   - `kode_barang`: `CHAR(10) NOT NULL UNIQUE`
   - `nama_barang`: `VARCHAR(100) NOT NULL`
   - `nomor_aset`: `VARCHAR(30) NOT NULL UNIQUE`
   - `tahun_perolehan`: `SMALLINT UNSIGNED NOT NULL CHECK (tahun_perolehan BETWEEN 2000 AND 2026)`
   - `ruang_id`: `BIGINT UNSIGNED NOT NULL` (Foreign Key mengacu ke `ruang(id)`)
   - `created_at`: `TIMESTAMP DEFAULT CURRENT_TIMESTAMP`
   - `updated_at`: `TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP`
   - Constraints:
     - `CONSTRAINT fk_inventaris_ruang FOREIGN KEY (ruang_id) REFERENCES ruang(id) ON UPDATE CASCADE ON DELETE RESTRICT`
     - `CONSTRAINT chk_tahun_perolehan CHECK (tahun_perolehan BETWEEN 2000 AND 2026)`

### B. Berkas DDL (`database/sql/inventaris_lab_struktur.sql`)
```sql
CREATE DATABASE IF NOT EXISTS praktikum_web_2401020167
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE praktikum_web_2401020167;

CREATE TABLE IF NOT EXISTS ruang (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_ruang VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS inventaris (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode_barang CHAR(10) NOT NULL UNIQUE,
    nama_barang VARCHAR(100) NOT NULL,
    nomor_aset VARCHAR(30) NOT NULL UNIQUE,
    tahun_perolehan SMALLINT UNSIGNED NOT NULL,
    ruang_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_inventaris_ruang
        FOREIGN KEY (ruang_id)
        REFERENCES ruang(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT chk_tahun_perolehan
        CHECK (tahun_perolehan BETWEEN 2000 AND 2026)
) ENGINE=InnoDB;
```

### C. Data Awal Wajib DML (`database/sql/inventaris_lab_data.sql`)
```sql
USE praktikum_web_2401020167;

INSERT INTO ruang (id, nama_ruang) VALUES
(1, 'Lab Pemrograman'),
(2, 'Lab Jaringan')
ON DUPLICATE KEY UPDATE nama_ruang=VALUES(nama_ruang);

INSERT INTO inventaris (id, kode_barang, nama_barang, nomor_aset, tahun_perolehan, ruang_id) VALUES
(1, 'IV00000001', 'Komputer Praktikum', 'AST-LAB-0001', 2023, 1),
(2, 'IV00000002', 'Proyektor', 'AST-LAB-0002', 2022, 1),
(3, 'IV00000003', 'Router', 'AST-LAB-0003', 2024, 2)
ON DUPLICATE KEY UPDATE
    kode_barang=VALUES(kode_barang),
    nama_barang=VALUES(nama_barang),
    nomor_aset=VALUES(nomor_aset),
    tahun_perolehan=VALUES(tahun_perolehan),
    ruang_id=VALUES(ruang_id);
```

---

## 3. RANCANGAN ROUTE APLIKASI
Sistem menyediakan 5 rute HTTP terstruktur pada `routes/web.php` dengan prefix URL `/inventaris`:

| Method HTTP | URI Path | Nama Route | Keterangan & Fungsi |
| :--- | :--- | :--- | :--- |
| **GET** | `/inventaris` | `inventaris.index` | Menampilkan halaman utama: form tambah barang, form pencarian kata kunci (`q`), form filter ruang (`ruang_id`), notifikasi umpan balik, dan tabel data inventaris. |
| **POST** | `/inventaris` | `inventaris.store` | Menerima data masukan baru, melakukan sanitasi dan validasi server-side, memeriksa duplikasi kode/nomor aset, lalu menyimpan ke basis data via PDO. |
| **GET** | `/inventaris/{id}/edit` | `inventaris.edit` | Mengambil data inventaris lama berdasarkan `{id}` dan merender ke halaman form edit. |
| **PUT** | `/inventaris/{id}` | `inventaris.update` | Memvalidasi pembaruan data, memeriksa konflik keunikan terhadap rekaman lain, lalu menjalankan perintah UPDATE via PDO. |
| **DELETE** | `/inventaris/{id}` | `inventaris.destroy` | Menghapus rekaman inventaris berdasarkan `{id}` menggunakan prepared statement dengan perlindungan CSRF. |

---

## 4. LOGIKA BISNIS & IMPLEMENTASI KODE

### A. Fungsi Logika Khusus `statusUsiaAset()` (Modul 2)
Sesuai ketentuan khusus Tipe B, dibuat fungsi pembantu PHP untuk menentukan kategori barang baru atau lama:
```php
if (! function_exists('statusUsiaAset')) {
    /**
     * Menentukan status usia aset berdasarkan tahun perolehan.
     * Mengembalikan 'Baru' jika tahun >= 2023 dan 'Lama' jika di bawahnya.
     */
    function statusUsiaAset(int $tahun): string
    {
        return $tahun >= 2023 ? 'Baru' : 'Lama';
    }
}
```

### B. Prepared Statement PDO & Error Handling (Modul 5, 6, 7)
Seluruh query dieksekusi menggunakan instance PDO dari koneksi Laravel (`DB::connection()->getPdo()`) dengan *positional/named parameter binding* (`:param`). Hal ini mencegah kerentanan SQL Injection karena input tidak pernah disambung langsung ke string SQL.

Contoh penanganan error dan pencarian 3 kolom:
```php
try {
    $pdo = DB::connection()->getPdo();
    $sql = 'SELECT i.id, i.kode_barang, i.nama_barang, i.nomor_aset,
                   i.tahun_perolehan, i.ruang_id, r.nama_ruang
            FROM inventaris AS i
            JOIN ruang AS r ON r.id = i.ruang_id
            WHERE 1 = 1';
    $parameter = [];

    if ($kataKunci !== '') {
        $sql .= ' AND (i.kode_barang LIKE :kata_kunci_kode
                  OR i.nama_barang LIKE :kata_kunci_nama
                  OR i.nomor_aset LIKE :kata_kunci_aset)';
        $nilaiPencarian = '%'.$kataKunci.'%';
        $parameter['kata_kunci_kode'] = $nilaiPencarian;
        $parameter['kata_kunci_nama'] = $nilaiPencarian;
        $parameter['kata_kunci_aset'] = $nilaiPencarian;
    }

    if ($ruangId !== '') {
        $sql .= ' AND i.ruang_id = :ruang_id';
        $parameter['ruang_id'] = (int) $ruangId;
    }

    $sql .= ' ORDER BY i.kode_barang ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($parameter);
    $daftarInventaris = $stmt->fetchAll(\PDO::FETCH_ASSOC);
} catch (\Throwable $error) {
    report($error); // Mencatat detail error teknis ke log Laravel
    return response('Data inventaris tidak dapat dibaca. Periksa koneksi dan query.', 500);
}
```

### C. Antarmuka Blade Murni Tanpa CSS
Sesuai Poin 7 Instruksi Teknis Bersama, view `resources/views/inventaris.blade.php` dan `resources/views/inventaris-edit.blade.php` dirancang menggunakan elemen HTML standar (`<table>`, `<form>`, `<input>`, `<select>`, `<button>`) tanpa library tampilan eksternal.

---

## 5. HASIL SEPULUH PENGUJIAN WAJIB

Seluruh 10 skenario pengujian wajib telah diuji dan diverifikasi menggunakan Automated Feature Test Pest (`tests/Feature/InventarisTest.php`) dengan hasil **10 Passed (61 Assertions)**:

| No | Fitur / Skenario Uji | Parameter / Tindakan | Ekspektasi | Hasil Pengujian | Status |
|:--:|:---|:---|:---|:---|:---:|
| 1 | **Read** | Akses `GET /inventaris` | 3 data awal (Komputer Praktikum, Proyektor, Router) dan nama ruang tampil di tabel | 3 data awal dan nama ruang tampil lengkap | **VALID** |
| 2 | **Create Valid** | Submit data valid: `IV00000004`, `Switch Manageable`, `AST-LAB-0004`, `2025`, `Ruang 2` | Data baru tersimpan ke database, redirect ke index dengan pesan sukses | Data tersimpan, pesan sukses tampil, tabel bertambah | **VALID** |
| 3 | **Create Tidak Valid** | Submit data tidak valid (kode < 10 char, nama kosong, tahun < 2000) | Validasi gagal, pesan kesalahan tampil per field, nilai input dipertahankan via `old()` | Pesan error validasi muncul, input form tetap tersimpan | **VALID** |
| 4 | **Duplikat** | Submit kode barang `IV00000001` yang sudah ada | Sistem menolak masukan dengan pesan gagal, database tidak berubah | Penolakan berhasil, pesan duplikat muncul, jumlah data tetap | **VALID** |
| 5 | **Update** | Buka form edit ID 1, ubah nama menjadi `Komputer Praktikum Core i7`, submit `PUT` | Nilai lama tampil pada form, perubahan berhasil disimpan ke database | Data berhasil diperbarui di database dan tabel | **VALID** |
| 6 | **Konflik Update** | Ubah nomor aset ID 1 menjadi `AST-LAB-0002` (milik ID 2) | Sistem menolak perubahan karena konflik keunikan dengan record lain | Update ditolak dengan peringatan konflik duplikasi | **VALID** |
| 7 | **Delete** | Klik Hapus pada ID 3 via form `DELETE` + CSRF | Record terhapus dari tabel dan database | ID 3 terhapus, data tidak lagi muncul di tabel | **VALID** |
| 8 | **Pencarian 3 Kolom** | Cari kata kunci `Proyektor` (nama), `IV00000003` (kode), dan `AST-LAB-0001` (aset) | Tabel menyaring baris yang cocok pada salah satu dari ketiga kolom | Kueri LIKE pada 3 kolom berhasil menampilkan data relevan | **VALID** |
| 9 | **Filter Ruang** | Pilih filter dropdown `Lab Jaringan` (id 2) | Hanya barang di Lab Jaringan yang ditampilkan | Tabel hanya memunculkan barang dengan ruang_id = 2 | **VALID** |
| 10 | **Error Handling & statusUsiaAset** | Uji fungsi usia: tahun 2023/2024 -> 'Baru', tahun 2022 -> 'Lama'; simulasi error koneksi | Label status usia tampil akurat di tabel; error query di-handle tanpa stack trace bocor | Status 'Baru' dan 'Lama' tampil tepat; respon error aman | **VALID** |

---

## 6. KENDALA, ANALISIS MASALAH, DAN PERBAIKAN

### GitHub Issue: Penanganan Konflik Keunikan Multi-Kolom pada Operasi Update
* **Identifikasi Masalah**:
  Pada operasi `PUT /inventaris/{id}`, pengecekan duplikasi kolom `UNIQUE` (`kode_barang` dan `nomor_aset`) tidak boleh memblokir rekaman itu sendiri jika pengguna hanya memperbarui field lain (seperti nama atau tahun) tanpa mengubah kode barangnya. Namun, jika pengguna memasukkan kode atau nomor aset milik rekaman lain, sistem wajib menolaknya.
* **Langkah Pemeriksaan**:
  Melakukan pengujian kueri pengecekan duplikat. Jika kueri hanya `WHERE kode_barang = :kode_barang`, maka saat user menyimpan form tanpa mengubah kode, kueri akan mendeteksi baris itu sendiri sebagai duplikat.
* **Solusi & Perbaikan**:
  Menambahkan klausul pengecualian `AND id <> :id` pada prepared statement pengecekan konflik update:
  ```sql
  SELECT COUNT(*) FROM inventaris
  WHERE (kode_barang = :kode_barang OR nomor_aset = :nomor_aset)
    AND id <> :id
  ```
  Dengan klausa ini, pemeriksaan mengabaikan rekaman yang sedang diedit dan hanya menolak jika nilai tersebut telah dipakai oleh baris lain.

---

## 7. RIWAYAT COMMIT GIT TERSTRUKTUR
Sesuai instruksi teknis poin 8 (minimal lima commit terstruktur), berikut daftar tahapan commit yang diterapkan:
1. `feat(db): skema ddl dan dml inventaris laboratorium tipe b`
2. `feat(views): template blade html murni inventaris dan inventaris-edit`
3. `feat(inventaris): implementasi fungsi statusUsiaAset dan read create pdo`
4. `feat(inventaris): implementasi update delete pencarian 3 kolom dan filter ruang`
5. `test(inventaris): automated feature tests 10 skenario wajib dan dokumentasi laporan`

---

## 8. KESIMPULAN
Aplikasi CRUD **Sistem Inventaris Laboratorium (Tipe B)** telah berhasil dikembangkan sesuai seluruh indikator rubrik penilaian dan Instruksi Teknis Bersama Modul 1 sampai Modul 7. Seluruh transaksi database menggunakan Native PDO prepared statements untuk menjamin keamanan dari injeksi SQL, validasi dan sanitasi server-side mencegah anomali data, tampilan Blade HTML polos memenuhi syarat tanpa framework styling eksternal, dan kesepuluh skenario pengujian berhasil diverifikasi dengan predikat valid.
