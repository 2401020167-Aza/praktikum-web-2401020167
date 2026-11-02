##### **FAKULTAS TEKNIK DAN TEKNOLOGI KEMARITIMAN** 

# **SOAL STUDI KASUS PRAKTIKUM PEMROGRAMAN WEB** 

### **Lima Tipe Setara Berdasarkan Modul 1 sampai Modul 7** 

|**Komponen**|**Keterangan**|
|---|---|
|Mata kuliah|Praktikum Pemrograman Web|
|Kode|INF11197|
|Semester dan SKS|Semester V • 1 SKS|
|Bentuk|Praktik individual berbasis studi kasus|
|Alokasi waktu|1 × 170 menit|
|Teknologi|Laravel, PHP, MySQL atau MariaDB, PDO, Blade, Git dan GitHub|



##### **Tim Dosen Pengampu** 

Berta Erwin Slam, S.T., M.Kom. • Muhamad Radzi Rathomi, S.Kom., M.Cs. • Nolan Efranda, M.Kom. 

Soal Studi Kasus Modul 1–7 | Halaman 1 

## **Tujuan dan Cakupan Penilaian** 

Soal ini mengukur kemampuan mahasiswa merancang dan mengembangkan aplikasi web sederhana menggunakan Laravel sesuai CPMK091 dan CPMK092. Mahasiswa harus menghasilkan aplikasi CRUD yang terhubung ke basis data, memproses input secara aman, menguji fungsi, memperbaiki kesalahan, dan mendokumentasikan hasil. Kelima tipe memiliki struktur serta tingkat kesulitan yang sama; hanya domain datanya yang berbeda. 

|**Modul**|**Kemampuan yang Dinilai**|**Bukti Minimal**|
|---|---|---|
|1|Lingkungan Laravel, client–server, HTTP, Git dan keamanan<br>konfigurasi|Versi perangkat, halaman Laravel, repository,<br>.gitignore|
|2|Variabel, tipe data, operator, percabangan, perulangan,<br>fungsi dan keluaran Blade|Fungsi sederhana dan hasil dinamis pada Blade|
|3|GET dan POST, form, sanitasi, validasi server-side dan pesan<br>kesalahan|Form, @csrf, old(), input valid dan tidak valid|
|4|Entitas, atribut, PK, FK, relasi, DDL dan DML|Skema dua tabel, constraints dan data awal|
|5|Koneksi PDO, prepared statement dan error handling|prepare(), execute(), try–catch, report(), respons<br>aman|
|6|CRUD Create dan Read, duplikat, feedback operasi|Tambah dan daftar data terintegrasi|
|7|Update, Delete, pencarian, filter, testing, debugging dan<br>commit|CRUD lengkap, pencarian/filter, issue dan git<br>log|



## **Instruksi Teknis Bersama** 

- 1.Kerjakan hanya tipe yang dibagikan dosen. Gunakan Laravel dan basis data MySQL atau MariaDB pada proyek baru atau proyek praktik yang telah disiapkan. 

- 2.Gunakan dua tabel berelasi satu-ke-banyak sesuai spesifikasi tipe. Terapkan primary key, foreign key, UNIQUE, NOT NULL, CHECK, ON UPDATE CASCADE, dan ON DELETE RESTRICT. 

- 3.Sediakan route GET untuk indeks, POST untuk Create, GET untuk form edit, PUT untuk Update, dan DELETE untuk Delete. Halaman indeks harus memuat form tambah, form pencarian, filter, feedback, serta tabel data. 

- 4.Terapkan trim dan strip_tags pada input teks yang relevan, validasi server-side, pesan kesalahan, old(), token @csrf, dan method spoofing untuk PUT serta DELETE. 

- 5.Akses basis data melalui PDO dari koneksi Laravel. Semua query yang menerima input pengguna wajib memakai prepared statement; dilarang menggabungkan input langsung ke string SQL. 

- 6.Tangani kesalahan koneksi atau query dengan try–catch. Catat detail melalui report(), tetapi tampilkan pesan yang aman dan singkat kepada pengguna. 

- 7.Gunakan Blade dan HTML sederhana tanpa CSS, JavaScript, Bootstrap, Tailwind, atau pustaka tampilan lain. Gambar laporan harus sama dengan kode dan hasil aplikasi yang dikerjakan. 

- 8.Buat minimal lima commit terstruktur dan satu GitHub Issue yang mencatat masalah, langkah pemeriksaan, perbaikan, serta hasil uji ulang. File .env tidak boleh masuk repository. 

Soal Studi Kasus Modul 1–7 | Halaman 2 

## **Fitur dan Pengujian Wajib** 

|**No.**|**Fitur atau Uji**|**Kriteria Keberhasilan**|
|---|---|---|
|1|Read|Tiga data awal dan nama tabel master tampil pada indeks.|
|2|Create valid|Data baru tersimpan dan feedback keberhasilan tampil.|
|3|Create tidak valid|Pesan kesalahan tampil dan input lama dipertahankan.|
|4|Duplikat|Kode atau identitas unik yang sama ditolak tanpa merusak data.|
|5|Update|Data lama tampil pada form edit dan perubahan tersimpan.|
|6|Konflik Update|Nilai unik milik data lain ditolak.|
|7|Delete|Data terpilih terhapus melalui form DELETE dengan CSRF.|
|8|Pencarian|Kata kunci mencari tiga kolom yang telah ditentukan.|
|9|Filter|Hasil dapat dibatasi berdasarkan tabel master.|
|10|Error handling|Kesalahan koneksi atau query dicatat, sedangkan pengguna menerima respons<br>aman.|



## **Berkas yang Dikumpulkan** 

- Tautan repository GitHub berisi source code, berkas SQL, .env.example, README, dan riwayat commit. Repository tidak memuat .env atau kata sandi. 

- Laporan PDF ringkas berisi identitas, tipe soal, rancangan relasi, daftar route, penjelasan prepared statement dan error handling, hasil sepuluh pengujian, kendala, perbaikan, serta simpulan. 

- Tangkapan layar harus memperlihatkan URL atau terminal yang relevan dan tidak boleh berasal dari tipe lain. 

Soal Studi Kasus Modul 1–7 | Halaman 3 

## **Rubrik Penilaian** 

|**Komponen**|**Bobot**|**Indikator**|
|---|---|---|
|CRUD dan penyajian data|45|Create, Read, Update, Delete, feedback, pencarian, dan filter<br>berfungsi terintegrasi.|
|Rancangan data dan SQL|20|Dua entitas tepat; PK, FK, relasi, constraint, DDL, DML, dan data<br>awal benar.|
|Form dan pengolahan input|20|GET/POST, sanitasi, validasi, CSRF, old(), pesan error, dan<br>pencegahan duplikat benar.|
|Keamanan, testing, kode dan Git|15|Prepared statement, error handling, bukti uji, kode rapi, issue,<br>commit, dan perlindungan .env.|
|Total|100|Setiap tipe dinilai dengan rubrik yang sama.|



## **Kesetaraan Lima Tipe** 

|**Tipe**|**Domain**|**Tabel Master**|**Tabel Utama**|**Nilai Numerik**|
|---|---|---|---|---|
|A|Perpustakaan|kategori_buku|buku|tahun_terbit|
|B|Inventaris laboratorium|ruang|inventaris|tahun_perolehan|
|C|Produk UMKM|kategori_produk|produk|stok|
|D|Kegiatan mahasiswa|jenis_kegiatan|kegiatan|kuota|
|E|Peserta pelatihan|program_pelatihan|peserta|usia|



Semua tipe memiliki dua tabel, satu relasi satu-ke-banyak, dua nilai unik pada tabel utama, satu field numerik dengan batas CHECK, lima route CRUD, pencarian tiga kolom, satu filter, sepuluh skenario uji, dan rubrik yang sama. 

Soal Studi Kasus Modul 1–7 | Halaman 4 

## **Tipe B Sistem Inventaris Laboratorium** 

Pengelola laboratorium memerlukan aplikasi untuk mendata barang pada setiap ruang. Petugas harus dapat menjalankan CRUD, mencari inventaris, dan memfilter berdasarkan ruang. Aplikasi wajib menolak kode barang atau nomor aset yang sama. 

#### **Spesifikasi Data** 

|**Tabel**|**Kolom dan Ketentuan**|
|---|---|
|ruang|id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY; nama_ruang VARCHAR(100) NOT<br>NULL UNIQUE.|
||id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY; kode_barang CHAR(10) NOT NULL<br>UNIQUE; nama_barang VARCHAR(100) NOT NULL; nomor_aset VARCHAR(30) NOT NULL|
|inventaris|UNIQUE; tahun_perolehan SMALLINT UNSIGNED NOT NULL CHECK (tahun_perolehan<br>BETWEEN 2000 AND 2026); ruang_id BIGINT UNSIGNED NOT NULL sebagai FK; created_at<br>dan updated_at.|



#### **Data Awal Wajib** 

|**Kode**|**Nama Barang**|**Nomor Aset**|**Tahun**|**Ruang**|
|---|---|---|---|---|
|IV00000001|Komputer Praktikum|AST-LAB-0001|2023|Lab Pemrograman|
|IV00000002|Proyektor|AST-LAB-0002|2022|Lab Pemrograman|
|IV00000003|Router|AST-LAB-0003|2024|Lab Jaringan|



#### **Ketentuan Khusus Tipe** 

- Nama basis data: inventaris_lab_NIM. Route utama: /inventaris. 

- Pencarian memeriksa kode_barang, nama_barang, dan nomor_aset; filter menggunakan ruang_id. 

- Validasi utama: kode tepat 10 karakter alfanumerik; nama 3–100 karakter; nomor aset 5–30 karakter; tahun 2000– 2026; ruang wajib tersedia. 

- Buat fungsi PHP sederhana statusUsiaAset() untuk menampilkan ‘Baru’ jika tahun ≥2023 dan ‘Lama’ jika di bawahnya dan tampilkan hasilnya pada Blade menggunakan percabangan dan perulangan. 

- Seluruh fitur dan bukti pengujian tetap mengikuti Instruksi Teknis Bersama. Tidak boleh mengganti jumlah tabel, jumlah field inti, atau jenis fitur. 

Soal Studi Kasus Modul 1–7 | Halaman 5 

