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
('G01', 'Penurunan / Kehilangan nafsu makan'),
('G02', 'Diare (non-berdarah, semua warna)'),
('G03', 'Diare berdarah'),
('G04', 'Keluar air mata berlebihan'),
('G05', 'Gangguan pernapasan / Napas tersengal-sengal'),
('G06', 'Penurunan / Kehilangan berat badan'),
('G07', 'Kematian'),
('G08', 'Lemah / Lesu / Kelemahan'),
('G09', 'Bulu kusam'),
('G10', 'Penurunan kondisi fisik'),
('G11', 'Bersin-bersin'),
('G12', 'Hidung berair'),
('G13', 'Batuk'),
('G14', 'Penurunan produksi telur'),
('G15', 'Napas cepat'),
('G16', 'Suara pernapasan serak'),
('G17', 'Kerutan di belakang leher'),
('G18', 'Kehilangan keseimbangan');

-- Insert Penyakit
INSERT INTO penyakit (id_penyakit, nama, deskripsi, solusi, pencegahan) VALUES
('A01', 'Kolera Burung', 'Penyakit infeksi bakteri yang menyerang sistem pencernaan dan pernapasan.', 'Pemberian antibiotik dan perbaikan sanitasi.', 'Vaksinasi kolera dan menjaga kebersihan kandang.'),
('A02', 'Paratifus Burung', 'Penyakit bakteri yang menyebabkan gangguan pencernaan parah.', 'Antibiotik sesuai petunjuk dokter hewan.', 'Pemberian pakan bersih dan karantina burung baru.'),
('A03', 'Cacingan (Cacing Usus)', 'Infeksi cacing parasit di dalam saluran pencernaan.', 'Pemberian obat cacing secara rutin.', 'Menjaga kebersihan lantai kandang.'),
('A04', 'Koksidiosis', 'Penyakit parasit protozoa yang menyerang usus.', 'Pemberian obat antikoksidia.', 'Menjaga kondisi kandang tetap kering.'),
('A05', 'Snot (Rhinotracheitis)', 'Penyakit pernapasan menular pada unggas.', 'Antibiotik dan vitamin untuk meningkatkan daya tahan.', 'Menghindari kelembapan tinggi dan sirkulasi udara buruk.'),
('A06', 'Batuk Burung', 'Gangguan pernapasan yang ditandai dengan batuk dan bersin.', 'Obat pernapasan dan lingkungan yang hangat.', 'Menghindari debu dan polusi udara di sekitar kandang.'),
('A07', 'Tetelo', 'Penyakit viral saraf yang sangat menular.', 'Dukungan vitamin dan nutrisi, isolasi burung sakit.', 'Vaksinasi rutin ND (Newcastle Disease).');

-- Insert Aturan
INSERT INTO aturan (id_aturan, id_penyakit) VALUES
('R01', 'A01'),
('R02', 'A02'),
('R03a', 'A03'),
('R03b', 'A04'),
('R04a', 'A03'),
('R04b', 'A04'),
('R05', 'A05'),
('R06', 'A06'),
('R07', 'A07');

-- Insert Aturan Detail
INSERT INTO aturan_detail (id_aturan, id_gejala, bobot) VALUES
-- R01: A01 (6 symptoms)
('R01', 'G01', 16.67), ('R01', 'G02', 16.67), ('R01', 'G04', 16.67), ('R01', 'G05', 16.67), ('R01', 'G06', 16.67), ('R01', 'G07', 16.65),
-- R02: A02 (6 symptoms)
('R02', 'G01', 16.67), ('R02', 'G02', 16.67), ('R02', 'G06', 16.67), ('R02', 'G07', 16.67), ('R02', 'G08', 16.67), ('R02', 'G09', 16.65),
-- R03a: A03 (5 symptoms)
('R03a', 'G01', 20.00), ('R03a', 'G02', 20.00), ('R03a', 'G06', 20.00), ('R03a', 'G09', 20.00), ('R03a', 'G10', 20.00),
-- R03b: A04 (5 symptoms)
('R03b', 'G01', 20.00), ('R03b', 'G02', 20.00), ('R03b', 'G06', 20.00), ('R03b', 'G09', 20.00), ('R03b', 'G10', 20.00),
-- R04a: A03 (5 symptoms)
('R04a', 'G01', 20.00), ('R04a', 'G03', 20.00), ('R04a', 'G06', 20.00), ('R04a', 'G07', 20.00), ('R04a', 'G08', 20.00),
-- R04b: A04 (5 symptoms)
('R04b', 'G01', 20.00), ('R04b', 'G03', 20.00), ('R04b', 'G06', 20.00), ('R04b', 'G07', 20.00), ('R04b', 'G08', 20.00),
-- R05: A05 (6 symptoms)
('R05', 'G01', 16.67), ('R05', 'G08', 16.67), ('R05', 'G11', 16.67), ('R05', 'G12', 16.67), ('R05', 'G13', 16.67), ('R05', 'G14', 16.65),
-- R06: A06 (6 symptoms)
('R06', 'G10', 16.67), ('R06', 'G11', 16.67), ('R06', 'G13', 16.67), ('R06', 'G14', 16.67), ('R06', 'G15', 16.67), ('R06', 'G16', 16.65),
-- R07: A07 (6 symptoms)
('R07', 'G05', 16.67), ('R07', 'G06', 16.67), ('R07', 'G07', 16.67), ('R07', 'G08', 16.67), ('R07', 'G17', 16.67), ('R07', 'G18', 16.65);
