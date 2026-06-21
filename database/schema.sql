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
('G01', 'Penurunan nafsu makan, diare berwarna hijau kekuningan, keluar air mata berlebihan, napas tersengal-sengal, kehilangan berat badan, dan kematian.'),
('G02', 'Nafsu makan menurun, diare berwarna hijau gelap atau coklat, lesu, bulu kusam, penurunan berat badan, dan kematian.'),
('G03', 'Diare, kehilangan nafsu makan, bulu kusam, penurunan berat badan, dan penurunan kondisi fisik.'),
('G04', 'Diare berdarah, lemah, nafsu makan menurun, penurunan berat badan, dan kematian.'),
('G05', 'Bersin-bersin, hidung berair, batuk, kehilangan nafsu makan, kelemahan, dan penurunan produksi telur.'),
('G06', 'Batuk, bersin-bersin, nafas cepat, suara pernafasan serak, penurunan kondisi fisik, dan penurunan produksi telur.'),
('G07', 'Kelemahan otot, kerutan di belakang leher, gangguan pernapasan, berat badan turun, kehilangan keseimbangan, dan kematian.');

-- Insert Penyakit
INSERT INTO penyakit (id_penyakit, nama, deskripsi, solusi, pencegahan) VALUES
('P01', 'Kolera Burung', 'Penyakit infeksi bakteri yang menyerang sistem pencernaan dan pernapasan.', 'Pemberian antibiotik dan perbaikan sanitasi.', 'Vaksinasi kolera dan menjaga kebersihan kandang.'),
('P02', 'Paratifus Burung', 'Penyakit bakteri yang menyebabkan gangguan pencernaan parah.', 'Antibiotik sesuai petunjuk dokter hewan.', 'Pemberian pakan bersih dan karantina burung baru.'),
('P03', 'Cacingan (Cacing Usus)', 'Infeksi cacing parasit di dalam saluran pencernaan.', 'Pemberian obat cacing secara rutin.', 'Menjaga kebersihan lantai kandang.'),
('P04', 'Koksidiosis', 'Penyakit parasit protozoa yang menyerang usus.', 'Pemberian obat antikoksidia.', 'Menjaga kondisi kandang tetap kering.'),
('P05', 'Snot (Rhinotracheitis)', 'Penyakit pernapasan menular pada unggas.', 'Antibiotik dan vitamin untuk meningkatkan daya tahan.', 'Menghindari kelembapan tinggi dan sirkulasi udara buruk.'),
('P06', 'Batuk Burung', 'Gangguan pernapasan yang ditandai dengan batuk dan bersin.', 'Obat pernapasan dan lingkungan yang hangat.', 'Menghindari debu dan polusi udara di sekitar kandang.'),
('P07', 'Tetelo', 'Penyakit viral saraf yang sangat menular.', 'Dukungan vitamin dan nutrisi, isolasi burung sakit.', 'Vaksinasi rutin ND (Newcastle Disease).');

-- Insert Aturan
INSERT INTO aturan (id_aturan, id_penyakit) VALUES
('R01', 'P01'),
('R02', 'P02'),
('R03', 'P03'),
('R04', 'P04'),
('R05', 'P05'),
('R06', 'P06'),
('R07', 'P07');

-- Insert Aturan Detail
INSERT INTO aturan_detail (id_aturan, id_gejala, bobot) VALUES
('R01', 'G01', 100.00),
('R02', 'G02', 100.00),
('R03', 'G03', 100.00),
('R04', 'G04', 100.00),
('R05', 'G05', 100.00),
('R06', 'G06', 100.00),
('R07', 'G07', 100.00);
