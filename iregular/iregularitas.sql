-- Membuat database dengan nama iregularitas
CREATE DATABASE IF NOT EXISTS iregularitas;

-- Menggunakan database iregularitas
USE iregularitas;

-- Membuat tabel iregular dengan kolom dan tipe data yang sesuai
CREATE TABLE IF NOT EXISTS iregular (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_sistem VARCHAR(255) NOT NULL,
    reg_asal_p6 VARCHAR(255) NOT NULL,
    kantor_asal_p6 VARCHAR(255) NOT NULL,
    nopend_asal_p6 VARCHAR(255) NOT NULL,
    tanggal_berita_acara VARCHAR(255) NOT NULL,   -- Format 'yyyy/mm/dd hh:mm'
    bulan VARCHAR(50),                        -- Menyimpan nama bulan
    week VARCHAR(5),                          -- Format seperti 'W01'
    produksi VARCHAR(50),                     -- Format angka dengan titik seperti '1.031.953'
    target VARCHAR(10),                       -- Format persentase seperti '1%'
    tahun YEAR,                               -- Tahun
    reg_tujuan_p6 VARCHAR(255) NOT NULL,
    kantor_tujuan_p6 VARCHAR(255) NOT NULL,
    nopend_tujuan_p6 VARCHAR(255) NOT NULL,
    deskripsi TEXT,                           -- Deskripsi panjang
    dnln VARCHAR(50),                         -- Bisa disesuaikan jika berupa enum atau angka
    nomor_kiriman VARCHAR(255)                -- Format nomor atau teks
);

-- Contoh memasukkan data ke dalam tabel iregular
INSERT INTO iregular (id_sistem, reg_asal_p6, kantor_asal_p6, nopend_asal_p6, tanggal_berita_acara, bulan, week, produksi, target, tahun, reg_tujuan_p6, kantor_tujuan_p6, nopend_tujuan_p6, deskripsi, dnln, nomor_kiriman)
VALUES 
    ('ID001', 'Reg Asal 1', 'Kantor Asal 1', 'NoPend Asal 1', STR_TO_DATE('05-01-2023 15:04', '%d-%m-%Y %H:%i'), 'Januari', 'W01', '1.031.953', '1%', 2023, 'Reg Tujuan 1', 'Kantor Tujuan 1', 'NoPend Tujuan 1', 'Deskripsi Contoh', 'DNLN1', 'No Kiriman 1'),
    ('ID002', 'Reg Asal 2', 'Kantor Asal 2', 'NoPend Asal 2', STR_TO_DATE('06-02-2023 10:30', '%d-%m-%Y %H:%i'), 'Februari', 'W02', '2.500.000', '2%', 2023, 'Reg Tujuan 2', 'Kantor Tujuan 2', 'NoPend Tujuan 2', 'Deskripsi Contoh 2', 'DNLN2', 'No Kiriman 2');

-- Contoh mengambil data dari tabel iregular
SELECT 
    id_sistem,
    reg_asal_p6,
    kantor_asal_p6,
    nopend_asal_p6,
    DATE_FORMAT(tanggal_berita_acara, '%d-%m-%y %H:%i') AS tanggal_berita_acara,  -- Format output tanggal
    bulan,
    week,
    produksi,
    target,
    tahun,
    reg_tujuan_p6,
    kantor_tujuan_p6,
    nopend_tujuan_p6,
    deskripsi,
    dnln,
    nomor_kiriman
FROM 
    iregular;
