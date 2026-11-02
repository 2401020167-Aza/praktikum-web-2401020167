# Sistem Inventaris Laboratorium (Tipe B)
**Praktikum Pemrograman Web (INF11197) - Modul 1 sampai Modul 7**

* **Mahasiswa**: Shalsabyla Finta Azalea
* **NIM**: 2401020167
* **Program Studi**: Teknik Informatika
* **Fakultas**: Fakultas Teknik dan Teknologi Kemaritiman
* **Universitas**: Universitas Maritim Raja Ali Haji (UMRAH)

---

## 📌 Deskripsi Proyek
Proyek ini merupakan implementasi studi kasus praktikum individual **Tipe B: Sistem Inventaris Laboratorium** yang mencakup capaian pembelajaran CPMK091 dan CPMK092 dari Modul 1 sampai Modul 7:
1. **Modul 1**: Konfigurasi lingkungan Laravel, Git versioning, keamanan file `.env`.
2. **Modul 2**: Logika percabangan, perulangan, dan fungsi PHP `statusUsiaAset()` pada Blade.
3. **Modul 3**: Sanitasi input (`trim`, `strip_tags`), validasi server-side, proteksi CSRF, dan method spoofing.
4. **Modul 4**: Perancangan basis data relasional 2 tabel (`ruang` dan `inventaris`), DDL, DML data awal, dan constraint (PK, FK, UNIQUE, CHECK).
5. **Modul 5**: Koneksi database melalui **Native PDO Prepared Statements** via `DB::connection()->getPdo()` dan penanganan kesalahan dengan `try-catch` & `report()`.
6. **Modul 6**: Operasi CRUD Create dan Read terintegrasi dengan feedback notifikasi.
7. **Modul 7**: Operasi Update, Delete, pencarian multi-kolom (3 kolom: kode, nama, nomor aset), filter relasi ruang, dan automated testing.

---

## 🚀 Panduan Menjalankan Aplikasi

### 1. Kebutuhan Sistem
* PHP >= 8.2
* Composer
* MySQL / MariaDB (Laragon / XAMPP)

### 2. Instalasi dan Setup
1. Clone repositori:
   ```bash
   git clone https://github.com/2401020167-Aza/praktikum-web-2401020167.git
   cd praktikum-web-2401020167
   ```
2. Instal dependensi:
   ```bash
   composer install
   ```
3. Konfigurasi berkas `.env`:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Impor basis data:
   * Jalankan `database/sql/inventaris_lab_struktur.sql`
   * Jalankan `database/sql/inventaris_lab_data.sql`
5. Jalankan server Laravel:
   ```bash
   php artisan serve
   ```
6. Buka aplikasi di browser:
   * **Sistem Inventaris Laboratorium**: `http://127.0.0.1:8000/inventaris`

---

## 🧪 Menjalankan Pengujian (Automated Testing)
Proyek ini dilengkapi dengan 10 skenario pengujian otomatis menggunakan Pest:
```bash
php artisan test --filter=InventarisTest
```

---

## 📄 Berkas Pendukung
* Berkas DDL: `database/sql/inventaris_lab_struktur.sql`
* Berkas DML: `database/sql/inventaris_lab_data.sql`
* Laporan Praktikum Lengkap: `docs/LAPORAN_STUDI_KASUS_TIPE_B.md`
