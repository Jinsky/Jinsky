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
('G08', 'Lemah / Lesu / Kelemahan (umum & otot)'),
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
('A03', 'Cacingan', 'Infeksi cacing parasit di dalam saluran pencernaan.', 'Pemberian obat cacing secara rutin.', 'Menjaga kebersihan lantai kandang.'),
('A04', 'Koksidiosis', 'Penyakit parasit protozoa yang menyerang usus.', 'Pemberian obat antikoksidia.', 'Menjaga kondisi kandang tetap kering.'),
('A05', 'Snot (Rhinotracheitis)', 'Penyakit pernapasan menular pada unggas.', 'Antibiotik dan vitamin untuk meningkatkan daya tahan.', 'Menghindari kelembapan tinggi dan sirkulasi udara buruk.'),
('A06', 'Batuk Burung', 'Gangguan pernapasan yang ditandai dengan batuk dan bersin.', 'Obat pernapasan dan lingkungan yang hangat.', 'Menghindari debu dan polusi udara di sekitar kandang.'),
('A07', 'Tetelo', 'Penyakit viral saraf yang sangat menular.', 'Dukungan vitamin dan nutrisi, isolasi burung sakit.', 'Vaksinasi rutin ND (Newcastle Disease).');

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
('R01', 'G01', 33.33), ('R01', 'G02', 33.33), ('R01', 'G04', 33.34),
('R02', 'G01', 33.33), ('R02', 'G05', 33.33), ('R02', 'G06', 33.34),
('R03', 'G02', 33.33), ('R03', 'G05', 33.33), ('R03', 'G07', 33.34),
('R04', 'G01', 33.33), ('R04', 'G02', 33.33), ('R04', 'G06', 33.34),
('R05', 'G02', 33.33), ('R05', 'G07', 33.33), ('R05', 'G08', 33.34),
('R06', 'G06', 33.33), ('R06', 'G08', 33.33), ('R06', 'G09', 33.34),
('R07', 'G01', 33.33), ('R07', 'G02', 33.33), ('R07', 'G06', 33.34),
('R08', 'G02', 33.33), ('R08', 'G06', 33.33), ('R08', 'G09', 33.34),
('R09', 'G06', 33.33), ('R09', 'G09', 33.33), ('R09', 'G10', 33.34),
('R10', 'G01', 33.33), ('R10', 'G03', 33.33), ('R10', 'G06', 33.34),
('R11', 'G03', 33.33), ('R11', 'G07', 33.33), ('R11', 'G08', 33.34),
('R12', 'G01', 33.33), ('R12', 'G06', 33.33), ('R12', 'G08', 33.34),
('R13', 'G01', 33.33), ('R13', 'G08', 33.33), ('R13', 'G11', 33.34),
('R14', 'G11', 33.33), ('R14', 'G12', 33.33), ('R14', 'G13', 33.34),
('R15', 'G08', 33.33), ('R15', 'G13', 33.33), ('R15', 'G14', 33.34),
('R16', 'G10', 33.33), ('R16', 'G11', 33.33), ('R16', 'G13', 33.34),
('R17', 'G13', 33.33), ('R17', 'G14', 33.33), ('R17', 'G15', 33.34),
('R18', 'G11', 33.33), ('R18', 'G15', 33.33), ('R18', 'G16', 33.34),
('R19', 'G05', 33.33), ('R19', 'G06', 33.33), ('R19', 'G07', 33.34),
('R20', 'G06', 33.33), ('R20', 'G08', 33.33), ('R20', 'G17', 33.34),
('R21', 'G07', 33.33), ('R21', 'G17', 33.33), ('R21', 'G18', 33.34);
