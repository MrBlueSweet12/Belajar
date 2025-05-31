-- Hapus database jika sudah ada dan buat baru
DROP DATABASE IF EXISTS db_resto;
CREATE DATABASE db_resto;
USE db_resto;

-- Tabel kategori
CREATE TABLE kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel menu
CREATE TABLE menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    gambar VARCHAR(255),
    nama_menu VARCHAR(100) NOT NULL,
    kategori_id INT,
    deskripsi TEXT,
    harga DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE SET NULL
);

-- Tabel pelanggan
CREATE TABLE pelanggan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT,
    telp VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel user (admin)
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    level ENUM('admin', 'koki', 'kasir') NOT NULL DEFAULT 'kasir',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel order
CREATE TABLE `order` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    faktur VARCHAR(20) NOT NULL UNIQUE,
    pelanggan_id INT,
    tanggal_order DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'proses', 'selesai', 'batal') DEFAULT 'pending',
    total DECIMAL(10, 2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id) ON DELETE SET NULL
);

-- Tabel order_detail
CREATE TABLE order_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_id INT,
    jumlah INT NOT NULL,
    harga DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES `order`(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE SET NULL
);

-- Tambahkan data awal

-- Data kategori
INSERT INTO kategori (nama_kategori) VALUES 
('Makanan'), 
('Minuman'), 
('Dessert');

-- Data menu
INSERT INTO menu (gambar, nama_menu, kategori_id, deskripsi, harga) VALUES
('https://example.com/mie-jebew.jpg', 'Mie Jebew', 1, 'Mie Jebew Enak, Murah sekali', 11000),
('https://example.com/nasi-goreng.jpg', 'Nasi Goreng', 1, 'Nasi goreng spesial dengan telur dan ayam', 15000),
('https://example.com/es-teh.jpg', 'Es Teh', 2, 'Es teh manis segar', 5000);

-- Data pelanggan
INSERT INTO pelanggan (nama, alamat, telp) VALUES
('Christopher', 'Sidoarjo', '097347398'),
('Budi', 'Surabaya', '081234567890');

-- Data user
INSERT INTO user (email, password, level) VALUES
('admin@resto.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'), -- password: password
('koki@resto.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'koki'),
('kasir@resto.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kasir');

-- Data order
INSERT INTO `order` (faktur, pelanggan_id, tanggal_order, status, total) VALUES
('INV-001', 1, '2025-05-30 10:00:00', 'selesai', 26000);

-- Data order_detail
INSERT INTO order_detail (order_id, menu_id, jumlah, harga, subtotal) VALUES
(1, 1, 1, 11000, 11000),
(1, 3, 3, 5000, 15000);