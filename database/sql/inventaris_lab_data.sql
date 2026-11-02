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
