<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventaris Laboratorium</title>
</head>
<body>
    <h1>Sistem Inventaris Laboratorium</h1>

    {{-- Feedback Notifikasi --}}
    @if (session('berhasil'))
        <p><strong>Berhasil:</strong> {{ session('berhasil') }}</p>
    @endif
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

    {{-- Form Tambah Inventaris (Create) --}}
    <h2>Tambah Inventaris Baru</h2>
    <form action="{{ route('inventaris.store') }}" method="POST">
        @csrf
        <p>
            Kode Barang (10 Karakter Alfanumerik)<br>
            <input type="text" name="kode_barang" value="{{ old('kode_barang') }}" maxlength="10">
        </p>
        <p>
            Nama Barang<br>
            <input type="text" name="nama_barang" value="{{ old('nama_barang') }}">
        </p>
        <p>
            Nomor Aset<br>
            <input type="text" name="nomor_aset" value="{{ old('nomor_aset') }}">
        </p>
        <p>
            Tahun Perolehan (2000 - 2026)<br>
            <input type="number" name="tahun_perolehan" value="{{ old('tahun_perolehan') }}" min="2000" max="2026">
        </p>
        <p>
            Ruang Laboratorium<br>
            <select name="ruang_id">
                <option value="">-- Pilih Ruang --</option>
                @foreach ($daftarRuang as $ruang)
                    <option value="{{ $ruang['id'] }}" @selected(old('ruang_id') == $ruang['id'])>
                        {{ $ruang['nama_ruang'] }}
                    </option>
                @endforeach
            </select>
        </p>
        <button type="submit">Tambah Inventaris</button>
    </form>

    <hr>

    {{-- Form Pencarian 3 Kolom dan Filter Ruang --}}
    <h2>Pencarian dan Filter Inventaris</h2>
    <form action="{{ route('inventaris.index') }}" method="GET">
        <p>
            Kata Kunci Pencarian (Kode, Nama, atau Nomor Aset)<br>
            <input type="text" name="q" value="{{ $kataKunci }}" placeholder="Cari barang...">
        </p>
        <p>
            Filter Berdasarkan Ruang<br>
            <select name="ruang_id">
                <option value="">-- Semua Ruang --</option>
                @foreach ($daftarRuang as $ruang)
                    <option value="{{ $ruang['id'] }}" @selected((string) $ruangId === (string) $ruang['id'])>
                        {{ $ruang['nama_ruang'] }}
                    </option>
                @endforeach
            </select>
        </p>
        <button type="submit">Cari Data</button>
        <a href="{{ route('inventaris.index') }}">Reset</a>
    </form>

    <hr>

    {{-- Tabel Data Inventaris (Read) --}}
    <h2>Daftar Inventaris Laboratorium</h2>
    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Nomor Aset</th>
                <th>Tahun</th>
                <th>Status Usia</th>
                <th>Ruang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($daftarInventaris as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['kode_barang'] }}</td>
                    <td>{{ $item['nama_barang'] }}</td>
                    <td>{{ $item['nomor_aset'] }}</td>
                    <td>{{ $item['tahun_perolehan'] }}</td>
                    <td>
                        {{-- Logika Percabangan statusUsiaAset --}}
                        @if (statusUsiaAset((int) $item['tahun_perolehan']) === 'Baru')
                            <strong>Baru</strong>
                        @else
                            <em>Lama</em>
                        @endif
                    </td>
                    <td>{{ $item['nama_ruang'] }}</td>
                    <td>
                        <a href="{{ route('inventaris.edit', $item['id']) }}">Ubah</a>
                        |
                        <form action="{{ route('inventaris.destroy', $item['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Data inventaris tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
