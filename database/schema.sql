CREATE DATABASE IF NOT EXISTS pigeon_expert_system;
USE pigeon_expert_system;

CREATE TABLE gejala (
    id_gejala VARCHAR(5) PRIMARY KEY,
    nama VARCHAR(255) NOT NULL
);

CREATE TABLE penyakit (
    id_penyakit VARCHAR(5) PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    solusi TEXT,
    pencegahan TEXT
);

CREATE TABLE aturan (
    id_aturan VARCHAR(5) PRIMARY KEY,
    id_penyakit VARCHAR(5),
    FOREIGN KEY (id_penyakit) REFERENCES penyakit(id_penyakit)
);

CREATE TABLE aturan_detail (
    id_aturan VARCHAR(5),
    id_gejala VARCHAR(5),
    bobot DECIMAL(5,2) DEFAULT 0,
    PRIMARY KEY (id_aturan, id_gejala),
    FOREIGN KEY (id_aturan) REFERENCES aturan(id_aturan),
    FOREIGN KEY (id_gejala) REFERENCES gejala(id_gejala)
);

CREATE TABLE diagnosa (
    id_diagnosa INT AUTO_INCREMENT PRIMARY KEY,
    nama_merpati VARCHAR(255) NOT NULL,
    id_penyakit VARCHAR(5),
    gejala_terpilih TEXT,
    confidence FLOAT,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_penyakit) REFERENCES penyakit(id_penyakit)
);

CREATE TABLE admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE pengunjung (
    id_pengunjung INT AUTO_INCREMENT PRIMARY KEY,
    total INT DEFAULT 0
);

-- Default visitor count
INSERT INTO pengunjung (total) VALUES (0);

-- Default admin: admin / admin123
INSERT INTO admin (username, password) VALUES ('admin', '$2y$10$8W3n.yQvRkH.LqY6mR.eueGZ1v1o/vHlKkYjQz.aFvXhZ9IqKxX3O');

-- Insert Gejala
INSERT INTO gejala (id_gejala, nama) VALUES
('G001', 'Penurunan / Kehilangan nafsu makan'),
('G002', 'Diare (non-berdarah, semua warna)'),
('G003', 'Diare berdarah'),
('G004', 'Keluar air mata berlebihan'),
('G005', 'Gangguan pernapasan / Napas tersengal-sengal'),
('G006', 'Penurunan / Kehilangan berat badan'),
('G007', 'Kematian'),
('G008', 'Lemah / Lesu / Kelemahan (umum & otot)'),
('G009', 'Bulu kusam'),
('G010', 'Penurunan kondisi fisik'),
('G011', 'Bersin-bersin'),
('G012', 'Hidung berair'),
('G013', 'Batuk'),
('G014', 'Penurunan produksi telur'),
('G015', 'Napas cepat'),
('G016', 'Suara pernapasan serak'),
('G017', 'Kerutan di belakang leher'),
('G018', 'Kehilangan keseimbangan');

-- Insert Penyakit
INSERT INTO penyakit (id_penyakit, nama, deskripsi, solusi, pencegahan) VALUES
('A01', 'Kolera Burung', 'Penyakit infeksi bakteri yang menyerang sistem pencernaan and pernapasan.', 'Pemberian antibiotik and perbaikan sanitasi.', 'Vaksinasi kolera and menjaga kebersihan kandang.'),
('A02', 'Paratifus Burung', 'Penyakit bakteri yang menyebabkan gangguan pencernaan parah.', 'Antibiotik sesuai petunjuk dokter hewan.', 'Pemberian pakan bersih and karantina burung baru.'),
('A03', 'Cacingan', 'Infeksi cacing parasit di dalam saluran pencernaan.', 'Pemberian obat cacing secara rutin.', 'Menjaga kebersihan lantai kandang.'),
('A04', 'Koksidiosis', 'Penyakit parasit protozoa yang menyerang usus.', 'Pemberian obat antikoksidia.', 'Menjaga kondisi kandang tetap kering.'),
('A05', 'Snot (Rhinotracheitis)', 'Penyakit pernapasan menular pada unggas.', 'Antibiotik and vitamin untuk meningkatkan daya tahan.', 'Menghindari kelembapan tinggi and sirkulasi udara buruk.'),
('A06', 'Batuk Burung', 'Gangguan pernapasan yang ditandai dengan batuk and bersin.', 'Obat pernapasan and lingkungan yang hangat.', 'Menghindari debu and polusi udara di sekitar kandang.'),
('A07', 'Tetelo', 'Penyakit viral saraf yang sangat menular.', 'Dukungan vitamin and nutrisi, isolasi burung sakit.', 'Vaksinasi rutin ND (Newcastle Disease).');

-- Insert Aturan
INSERT INTO aturan (id_aturan, id_penyakit) VALUES
('R01', 'A01'), ('R02', 'A01'), ('R03', 'A01'),
('R04', 'A02'), ('R05', 'A02'), ('R06', 'A02'),
('R07', 'A03'), ('R08', 'A03'), ('R09', 'A03'),
('R10', 'A04'), ('R11', 'A04'), ('R12', 'A04'),
('R13', 'A05'), ('R14', 'A05'), ('R15', 'A05'),
('R16', 'A06'), ('R17', 'A06'), ('R18', 'A06'),
('R19', 'A07'), ('R20', 'A07'), ('R21', 'A07');

-- Insert Aturan Detail
INSERT INTO aturan_detail (id_aturan, id_gejala, bobot) VALUES
('R01', 'G001', 33.33), ('R01', 'G002', 33.33), ('R01', 'G004', 33.34),
('R02', 'G001', 33.33), ('R02', 'G005', 33.33), ('R02', 'G006', 33.34),
('R03', 'G002', 33.33), ('R03', 'G005', 33.33), ('R03', 'G007', 33.34),
('R04', 'G001', 33.33), ('R04', 'G002', 33.33), ('R04', 'G006', 33.34),
('R05', 'G002', 33.33), ('R05', 'G007', 33.33), ('R05', 'G008', 33.34),
('R06', 'G006', 33.33), ('R06', 'G008', 33.33), ('R06', 'G009', 33.34),
('R07', 'G001', 33.33), ('R07', 'G002', 33.33), ('R07', 'G006', 33.34),
('R08', 'G002', 33.33), ('R08', 'G006', 33.33), ('R08', 'G009', 33.34),
('R09', 'G006', 33.33), ('R09', 'G009', 33.33), ('R09', 'G010', 33.34),
('R10', 'G001', 33.33), ('R10', 'G003', 33.33), ('R10', 'G006', 33.34),
('R11', 'G003', 33.33), ('R11', 'G007', 33.33), ('R11', 'G008', 33.34),
('R12', 'G001', 33.33), ('R12', 'G006', 33.33), ('R12', 'G008', 33.34),
('R13', 'G001', 33.33), ('R13', 'G008', 33.33), ('R13', 'G011', 33.34),
('R14', 'G011', 33.33), ('R14', 'G012', 33.33), ('R14', 'G013', 33.34),
('R15', 'G008', 33.33), ('R15', 'G013', 33.33), ('R15', 'G014', 33.34),
('R16', 'G010', 33.33), ('R16', 'G011', 33.33), ('R16', 'G013', 33.34),
('R17', 'G013', 33.33), ('R17', 'G014', 33.33), ('R17', 'G015', 33.34),
('R18', 'G011', 33.33), ('R18', 'G015', 33.33), ('R18', 'G016', 33.34),
('R19', 'G005', 33.33), ('R19', 'G006', 33.33), ('R19', 'G007', 33.34),
('R20', 'G006', 33.33), ('R20', 'G008', 33.33), ('R20', 'G017', 33.34),
('R21', 'G007', 33.33), ('R21', 'G017', 33.33), ('R21', 'G018', 33.34);
