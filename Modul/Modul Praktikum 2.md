

Praktikum Pemrograman Web (INF11197)  |  Pertemuan 1–2  |  Halaman 7

## FAKULTAS TEKNIK DAN TEKNOLOGI KEMARITIMAN
## PRAKTIKUM / MATA
## KULIAH
## PRAKTIKUM PEMROGRAMAN WEB
## HAL.: 7
## MODUL / PRAKTIKUM
## 2
## SINTAKS DASAR PHP PADA PROYEK LARAVEL

INF11197 • Semester V • 1 SKS  |  Tim Dosen: Berta Erwin Slam, S.T., M.Kom.; Muhamad Radzi Rathomi,
S.Kom., M.Cs.; Nolan Efranda, M.Kom.
## KETERKAITAN DENGAN RPS

Komponen RPS Isi Pertemuan 2
CPL dan CPMK CPL09; CPMK092 — mampu mengembangkan piranti lunak dengan menggunakan
kaidah dan bahasa pemrograman yang sesuai.
Sub-CPMK092.1 Mahasiswa mampu mengembangkan fungsi server-side dan operasi CRUD yang
terhubung dengan basis data menggunakan bahasa pemrograman web yang sesuai (C6).
Indikator 1) Menggunakan sintaks PHP. 2) Menerapkan variabel, operator, percabangan,
perulangan, dan fungsi. 3) Menampilkan keluaran dinamis.
Materi pokok Sintaks PHP; variabel dan tipe data; struktur kontrol; fungsi dan modularisasi.
Model dan langkah Discovery Learning & Guided Practice: mengamati contoh, memodifikasi kode,
menyelesaikan latihan, dan menguji hasil.
Bentuk pembelajaran Luring: praktik terarah dan latihan kode. Daring: Google Classroom/GitHub untuk latihan
dan umpan balik.
Penilaian Partisipasi 0,75% dan tugas 2,5%: ketepatan sintaks, logika, fungsi, dan keluaran. Total
bobot terhadap nilai akhir: 3,25%.
Alokasi dan BK 1 × 170 menit. Pemetaan CPMK092: BK07, BK08, BK11, BK14, dan BK15.
Media dan prasyarat VS Code, XAMPP/Laragon, PHP, Composer, Laravel, browser, Git/GitHub, komputer, dan
internet; prasyarat INF11117 Pemrograman Web.

## SASARAN

Setelah  mengikuti  Pertemuan  2,  mahasiswa  mampu  menggunakan  sintaks  PHP,  variabel,  tipe  data,
operator,  percabangan,  perulangan,  dan  fungsi  untuk  menghasilkan  keluaran  dinamis  sederhana  pada
proyek Laravel.
## RENCANA WAKTU 1 X 170 MENIT

Langkah Discovery Learning dan Guided Practice Waktu
Mengamati contoh dan mengenali bagian kode 15 menit
Latihan variabel, tipe data, dan operator 30 menit
Latihan percabangan dan perulangan 30 menit
Latihan fungsi dan modularisasi 30 menit
Memodifikasi kode dan menampilkan keluaran dinamis 45 menit
Menguji hasil, memperbaiki kesalahan, dan refleksi 20 menit

## PERSIAPAN PRAKTIKUM

- Gunakan proyek Laravel dari Pertemuan 1 dan pastikan halaman bawaan masih dapat dibuka.
- Buat salinan cadangan atau pastikan commit awal tersedia sebelum mengubah kode.

Praktikum Pemrograman Web (INF11197)  |  Pertemuan 1–2  |  Halaman 8
- Jalankan php artisan serve dan gunakan alamat http://127.0.0.1:8000.
- Pada pertemuan ini belum menggunakan controller, model, migration, basis data, autentikasi, atau CSS.
## PRAKTIKUM

Percobaan 1 — Mengamati sintaks, variabel, dan operator
Kode  menggunakan  variabel  $nama  dan  array  $nilai.  Operator  +=  menjumlahkan  nilai,  operator  /
menghitung rata-rata, dan operator >= membandingkan hasil dengan batas kelulusan.
Buka routes/web.php. Pertahankan route bawaan, kemudian tambahkan route /latihan-php berikut. Ketik
kode sama seperti pada blok kode dan gambar.
Isi yang ditambahkan pada routes/web.php:
## <?php

use Illuminate\Support\Facades\Route;

Route::get('/latihan-php', function () {
$nama = 'Nama Mahasiswa';
## $nilai = [80, 75, 90];

$hitungRataRata = function (array $data): float {
## $total = 0;
foreach ($data as $angka) {
## $total += $angka;
## }
return $total / count($data);
## };

$rataRata = $hitungRataRata($nilai);
if ($rataRata >= 75) {
$status = 'Lulus';
} else {
$status = 'Perlu Perbaikan';
## }

return view('latihan-php', compact(
'nama', 'nilai', 'rataRata', 'status'
## ));
## });



Praktikum Pemrograman Web (INF11197)  |  Pertemuan 1–2  |  Halaman 9

Gambar 7. Kode routes/web.php yang sama dengan langkah praktik, tanpa controller dan tanpa CSS.
Materi RPS Bagian kode
Sintaks PHP Pembuka <?php, titik koma, array, pemanggilan view, dan compact.
Variabel dan tipe data $nama berupa string; $nilai berupa array integer; $rataRata berupa float; $status
berupa string.
Operator += untuk penjumlahan, / untuk pembagian, dan >= untuk perbandingan.
Percabangan if dan else menentukan status Lulus atau Perlu Perbaikan.
Perulangan foreach menjumlahkan setiap angka di dalam array.
Fungsi dan modularisasi $hitungRataRata adalah fungsi anonim dengan parameter array dan nilai balik float.

Percobaan 2 — Membuat view keluaran dinamis
Buat  resources/views/latihan-php.blade.php.  Kode  berikut  hanya  menggunakan HTML  dan  Blade  dasar.
Tidak ada CSS, sehingga tampilan browser juga harus sederhana.
<!DOCTYPE html>
<html lang="id">
## <head>
<meta charset="UTF-8">
<title>Latihan PHP</title>
## </head>
## <body>
<h1>Hasil Latihan PHP</h1>
<p>Nama: {{ $nama }}</p>
<p>Daftar nilai:</p>
## <ul>
@foreach ($nilai as $angka)
## <li>{{ $angka }}</li>
## @endforeach
## </ul>
<p>Rata-rata: {{ number_format($rataRata, 2) }}</p>
<p>Status: {{ $status }}</p>
## </body>
## </html>

Praktikum Pemrograman Web (INF11197)  |  Pertemuan 1–2  |  Halaman 10


Gambar 8. Kode latihan-php.blade.php yang digunakan pada praktik tanpa CSS.
Percobaan 3 — Menguji route dan keluaran
Periksa route, jalankan server, lalu buka http://127.0.0.1:8000/latihan-php.
php artisan route:list --path=latihan-php
php artisan serve


Gambar 9. Contoh pengujian route /latihan-php pada terminal.
Dengan nilai 80, 75, dan 90, program menghasilkan rata-rata 81.67 dan status Lulus. Hasil pada browser
harus sama dengan data serta logika di routes/web.php.

Praktikum Pemrograman Web (INF11197)  |  Pertemuan 1–2  |  Halaman 11

Gambar 10. Hasil HTML polos yang sesuai dengan kode Blade tanpa CSS.
## TUGAS DAN PRAKTIK PERTEMUAN 2

- Ganti Nama Mahasiswa dengan nama sendiri dan ubah array menjadi lima nilai integer.
-  Pertahankan fungsi  hitung rata-rata,  foreach, dan percabangan.  Status Lulus diberikan jika rata-rata
minimal 75; selain itu tampilkan Perlu Perbaikan.
- Tampilkan nama, seluruh nilai, rata-rata dua angka desimal, dan status pada satu halaman HTML polos
tanpa CSS.
- Uji minimal dua data: satu menghasilkan Lulus dan satu menghasilkan Perlu Perbaikan.
- Commit perubahan ke repository dengan pesan Pertemuan 2 latihan PHP dasar.
- Kumpulkan source code atau repository, tangkapan layar dua hasil pengujian, dan laporan hasil praktik.
Format laporan hasil praktik
Halaman  judul
→  tujuan  →  kode  dan  penjelasan  variabel/operator/struktur  kontrol/fungsi  →  hasil  dua
pengujian
→ pembahasan → kendala dan solusi → kesimpulan → tautan repository atau lampiran source
code.
Komponen penilaian Pertemuan 2 Bobot nilai akhir
Partisipasi: kesiapan, keaktifan, dan respons terhadap umpan balik 0,75%
Sintaks, variabel, tipe data, dan operator 0,60%
Percabangan dan perulangan 0,60%
Fungsi dan modularisasi 0,60%
Keluaran dinamis dan bukti pengujian 0,50%
Laporan dan repository/source code 0,20%
## Total 3,25%

## RENCANA TUGAS DAN PRAKTIK TERINTEGRASI

Sesuai RPS terakhir, tugas dan praktik disajikan sebagai praktik individu terstruktur yang disertai laporan
hasil praktik. Bukti yang dikumpulkan mencakup konfigurasi lingkungan, repository/source code, tangkapan
layar pengujian, pembahasan hasil, serta refleksi kendala dan solusi.

Praktikum Pemrograman Web (INF11197)  |  Pertemuan 1–2  |  Halaman 12
Komponen penilaian mata kuliah Bobot
## UTS 20%
## UAS 20%
## Tugas 20%
## Praktik 30%
## Partisipasi 10%
## Total 100%

## REFERENSI

- Deitel, P. J., & Deitel, H. M. (2008). Internet & World Wide Web: How to Program (4th ed.). Pearson
## Education.
- Nixon, R. (2021). Learning PHP, MySQL & JavaScript (6th ed.). O’Reilly Media.
- PHP Documentation Group. PHP Manual: https://www.php.net/manual/en/
- Laravel Documentation: https://laravel.com/docs
- MDN Web Docs. Server-side website programming: https://developer.mozilla.org/
- Git Documentation: https://git-scm.com/doc
- Pertiwi, M., Efranda, N., Slam, B. E., Ritha, N., & Bettiza, M. (2024). UI/UX Design of Web-Based for
Outcome-based Education Assessment Information System in UMRAH. BIO Web of Conferences, 134.
Catatan: Gambar 4 merupakan halaman bawaan Laravel. Gambar 7–10 dibuat berdasarkan kode yang
ditampilkan  di  modul.  Karena  tidak  ada  CSS  pada  kode  Pertemuan  2,  hasil  browser  juga  ditampilkan
sebagai HTML polos.
Keterkaitan SDG 4: kegiatan praktikum mengembangkan literasi digital, berpikir komputasional, pemecahan
masalah, penggunaan version control, dan praktik pengembangan perangkat lunak secara terstruktur.