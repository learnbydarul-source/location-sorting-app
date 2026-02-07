-- File: init.sql

-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS sortir_lacation;
USE sortir_lacation;

-- Buat tabel penerima
CREATE TABLE IF NOT EXISTS penerima (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_resi VARCHAR(50) NOT NULL,
    lokasi_penerima VARCHAR(100) NOT NULL,
    id_penerima VARCHAR(50) NOT NULL,
    gudang VARCHAR(50) NOT NULL,
    status_pengiriman VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert data contoh
INSERT INTO penerima (no_resi, lokasi_penerima, id_penerima, gudang, status_pengiriman) VALUES
('Resi20251120001', 'Jakarta Pusat', 'IDP001', 'Gudang A', 'Diproses'),
('Resi20251120002', 'Bandung', 'IDP002', 'Gudang B', 'Dalam Pengiriman'),
('Resi20251120003', 'Surabaya', 'IDP003', 'Gudang C', 'Selesai'),
('Resi20251120004', 'Medan', 'IDP004', 'Gudang D', 'Diproses'),
('Resi20251120005', 'Yogyakarta', 'IDP005', 'Gudang E', 'Dalam Pengiriman');

-- Buat juga tabel sortir untuk hapus.php
CREATE TABLE IF NOT EXISTS sortir (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_resi VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);