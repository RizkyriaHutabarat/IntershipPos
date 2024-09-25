-- Membuat database dengan nama iregular
CREATE DATABASE IF NOT EXISTS iregularitas;

-- Menggunakan database iregular
USE iregularitas;

-- Membuat tabel iregular dengan kolom dan tipe data yang sesuai
CREATE TABLE IF NOT EXISTS iregular (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_sistem VARCHAR(255) NOT NULL,
    reg_asal_p6 VARCHAR(255) NOT NULL,
    kantor_asal_p6 VARCHAR(255) NOT NULL,
    nopend_asal_p6 VARCHAR(255) NOT NULL,
    tanggal_berita_acara DATE,          -- Disarankan menggunakan DATE jika berisi tanggal
    bulan VARCHAR(50),                  -- Gunakan VARCHAR jika formatnya berupa nama atau angka
    week INT,                           -- Gunakan INT jika berisi angka
    produksi DECIMAL(10, 2),            -- Sesuaikan dengan tipe data numerik untuk produksi, atau VARCHAR jika berupa teks
    target DECIMAL(10, 2),              -- Sesuaikan tipe data dengan kebutuhan
    tahun YEAR,                         -- Gunakan YEAR jika berisi tahun saja
    reg_tujuan_p6 VARCHAR(255) NOT NULL,
    kantor_tujuan_p6 VARCHAR(255) NOT NULL,
    nopend_tujuan_p6 VARCHAR(255) NOT NULL,
    deskripsi TEXT,                     -- Gunakan TEXT untuk deskripsi panjang
    dnln VARCHAR(50),                   -- Bisa disesuaikan jika berupa enum atau angka
    nomor_kiriman VARCHAR(255)          -- Gunakan VARCHAR jika formatnya berupa nomor atau teks
);
