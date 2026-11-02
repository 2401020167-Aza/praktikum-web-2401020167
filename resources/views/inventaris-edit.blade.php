<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Inventaris</title>
</head>
<body>
    <h1>Ubah Data Inventaris</h1>

    {{-- Feedback Notifikasi Gagal --}}
    @if (session('gagal'))
        <p><strong>Gagal:</strong> {{ session('gagal') }}</p>
    @endif

    {{-- Pesan Kesalahan Validasi --}}
    @if ($errors->any())
        <div>
            <strong>Terjadi kesalahan input:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Edit Data Inventaris (Update) --}}
    <form action="{{ route('inventaris.update', $inventaris['id']) }}" method="POST">
        @csrf
        @method('PUT')
        
        <p>
            Kode Barang (10 Karakter Alfanumerik)<br>
            <input type="text" name="kode_barang" value="{{ old('kode_barang', $inventaris['kode_barang']) }}" maxlength="10">
        </p>
        <p>
            Nama Barang<br>
            <input type="text" name="nama_barang" value="{{ old('nama_barang', $inventaris['nama_barang']) }}">
        </p>
        <p>
            Nomor Aset<br>
            <input type="text" name="nomor_aset" value="{{ old('nomor_aset', $inventaris['nomor_aset']) }}">
        </p>
        <p>
            Tahun Perolehan (2000 - 2026)<br>
            <input type="number" name="tahun_perolehan" value="{{ old('tahun_perolehan', $inventaris['tahun_perolehan']) }}" min="2000" max="2026">
        </p>
        <p>
            Ruang Laboratorium<br>
            <select name="ruang_id">
                <option value="">-- Pilih Ruang --</option>
                @foreach ($daftarRuang as $ruang)
                    <option value="{{ $ruang['id'] }}" 
                        @selected(old('ruang_id', $inventaris['ruang_id']) == $ruang['id'])>
                        {{ $ruang['nama_ruang'] }}
                    </option>
                @endforeach
            </select>
        </p>
        <button type="submit">Simpan Perubahan</button>
        <a href="{{ route('inventaris.index') }}">Batal / Kembali</a>
    </form>
</body>
</html>
