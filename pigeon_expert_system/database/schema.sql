CREATE DATABASE IF NOT EXISTS pigeon_expert_system;
USE pigeon_expert_system;

CREATE TABLE gejala (
    id VARCHAR(5) PRIMARY KEY,
    nama VARCHAR(255) NOT NULL
);

CREATE TABLE penyakit (
    id VARCHAR(5) PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    solusi TEXT,
    pencegahan TEXT
);

CREATE TABLE aturan (
    id VARCHAR(5) PRIMARY KEY,
    id_penyakit VARCHAR(5),
    FOREIGN KEY (id_penyakit) REFERENCES penyakit(id)
);

CREATE TABLE aturan_detail (
    id_aturan VARCHAR(5),
    id_gejala VARCHAR(5),
    PRIMARY KEY (id_aturan, id_gejala),
    FOREIGN KEY (id_aturan) REFERENCES aturan(id),
    FOREIGN KEY (id_gejala) REFERENCES gejala(id)
);

CREATE TABLE diagnosa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_merpati VARCHAR(255) NOT NULL,
    id_penyakit VARCHAR(5),
    gejala_terpilih TEXT,
    confidence FLOAT,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_penyakit) REFERENCES penyakit(id)
);

-- Insert Gejala
INSERT INTO gejala (id, nama) VALUES
('G01', 'Nafsu makan menurun'),
('G02', 'Burung terlihat lesu'),
('G03', 'Diare'),
('G04', 'Diare berdarah'),
('G05', 'Berat badan menurun'),
('G06', 'Bulu kusam'),
('G07', 'Bulu mengembang'),
('G08', 'Mata berair'),
('G09', 'Mata bengkak'),
('G10', 'Keluar cairan dari hidung'),
('G11', 'Bersin'),
('G12', 'Batuk'),
('G13', 'Napas berbunyi'),
('G14', 'Sulit bernapas'),
('G15', 'Sayap terkulai'),
('G16', 'Sulit berjalan'),
('G17', 'Kehilangan keseimbangan'),
('G18', 'Kepala gemetar'),
('G19', 'Tortikolis (kepala berputar)'),
('G20', 'Kelumpuhan'),
('G21', 'Luka pada kulit'),
('G22', 'Benjolan atau plak di rongga mulut'),
('G23', 'Bau mulut'),
('G24', 'Sulit menelan makanan'),
('G25', 'Kotoran berlendir'),
('G26', 'Demam'),
('G27', 'Sering minum'),
('G28', 'Produksi telur menurun'),
('G29', 'Aktivitas menurun'),
('G30', 'Kondisi tubuh kurus');

-- Insert Penyakit with detailed solutions and prevention tips
INSERT INTO penyakit (id, nama, deskripsi, solusi, pencegahan) VALUES
('P01', 'Newcastle Disease',
'Penyakit Newcastle (ND) atau yang dikenal dengan nama Tetelo adalah penyakit viral yang sangat menular pada unggas, termasuk merpati. Penyakit ini disebabkan oleh virus Newcastle Disease (NDV), yaitu Avian Paramyxovirus-1 (APMV-1). Gejala yang paling khas adalah gangguan saraf seperti leher berputar (tortikolis) dan kelumpuhan.',
'1. Isolasi segera burung yang menunjukkan gejala saraf untuk mencegah penyebaran ke seluruh koloni.\n2. Berikan dukungan vitamin terutama Vitamin B Kompleks dosis tinggi untuk membantu pemulihan sistem saraf.\n3. Berikan pakan yang mudah dicerna dan bantu burung makan/minum secara manual jika kondisinya sangat lemah.\n4. Gunakan desinfektan virucidal (pembunuh virus) untuk membersihkan seluruh area kandang secara menyeluruh.\n5. Tidak ada pengobatan spesifik untuk virus ND, namun pemberian antibiotik spektrum luas dapat dilakukan untuk mencegah infeksi sekunder bakteri.\n6. Berikan elektrolit dalam air minum untuk mencegah dehidrasi.',
'1. Vaksinasi rutin merupakan langkah pencegahan utama dan paling efektif.\n2. Batasi akses orang asing atau burung liar masuk ke area kandang.\n3. Terapkan protokol biosekuriti yang ketat: cuci tangan dan ganti alas kaki sebelum masuk kandang.\n4. Karantina burung baru selama minimal 30 hari sebelum digabungkan dengan koloni lama.\n5. Jaga kebersihan sirkulasi udara dan hindari kepadatan burung yang berlebihan dalam satu kandang.'),

('P02', 'Trichomoniasis',
'Trichomoniasis, sering disebut "Canker" atau "Goham", disebabkan oleh protozoa parasit Trichomonas gallinae. Penyakit ini sering menyerang tenggorokan dan mulut, menyebabkan munculnya plak kuning atau benjolan yang menghambat burung untuk makan.',
'1. Berikan obat yang mengandung bahan aktif Ronidazole, Metronidazole, atau Dimetridazole sesuai dosis anjuran dokter hewan.\n2. Bersihkan plak kuning di mulut burung secara hati-hati jika menghalangi pernapasan atau saluran makan.\n3. Berikan pakan lunak atau bantuan pemberian nutrisi cair selama burung sulit menelan.\n4. Segera ganti dan desinfeksi wadah air minum setiap hari karena parasit ini menyebar terutama melalui air minum yang terkontaminasi ludah burung sakit.\n5. Lakukan pengobatan massal pada satu koloni jika ditemukan lebih dari satu burung yang terjangkit.',
'1. Pastikan wadah air minum selalu bersih dan ganti air secara teratur minimal 2 kali sehari.\n2. Tambahkan cuka apel atau pengasam air minum lainnya (water acidifier) untuk menurunkan pH air sehingga parasit sulit bertahan hidup.\n3. Hindari penggunaan air minum secara bersamaan antara burung dewasa dengan anakan yang baru disapih.\n4. Pastikan kualitas pakan bebas dari debu dan kotoran.\n5. Lakukan pemeriksaan rutin pada rongga mulut burung secara berkala.'),

('P03', 'Coccidiosis',
'Coccidiosis adalah penyakit parasit usus yang disebabkan oleh protozoa genus Eimeria. Penyakit ini menyebabkan kerusakan pada dinding usus, mengakibatkan diare (terkadang berdarah) dan penurunan berat badan yang drastis.',
'1. Berikan obat anti-koksidia seperti Toltrazuril, Amprolium, atau Sulfa-based medications.\n2. Pastikan kandang dalam kondisi kering karena kelembapan tinggi mempercepat perkembangan kista koksidia (ookista).\n3. Ganti alas kandang (litter) secara rutin dan pastikan tidak ada kebocoran air di area kandang.\n4. Berikan suplemen vitamin A dan K untuk membantu regenerasi epitel usus dan mencegah perdarahan internal.\n5. Berikan probiotik setelah masa pengobatan selesai untuk memulihkan mikroflora usus yang sehat.',
'1. Jaga agar alas kandang selalu kering dan tidak lembap.\n2. Hindari kontaminasi pakan dan air minum oleh kotoran burung.\n3. Pastikan ventilasi kandang baik agar sirkulasi udara lancar dan kelembapan terjaga.\n4. Bersihkan peralatan kandang secara rutin menggunakan desinfektan yang efektif terhadap ookista.\n5. Hindari kepadatan burung yang terlalu tinggi dalam satu ruangan.'),

('P04', 'Salmonellosis',
'Salmonellosis atau "Paratyphus" disebabkan oleh bakteri Salmonella typhimurium var. copenhagen. Bakteri ini menyerang saluran pencernaan, namun bisa menyebar ke persendian (menyebabkan sayap terkulai) dan saraf.',
'1. Berikan antibiotik yang tepat seperti Enrofloxacin, Amoxicillin, atau Trimethoprim-Sulfa sesuai resep.\n2. Lakukan pengobatan minimal selama 10-14 hari untuk memastikan bakteri benar-benar mati dan tidak menjadi pembawa (carrier).\n3. Burung yang sudah lumpuh atau sayapnya turun secara permanen sebaiknya dievaluasi, karena kerusakan sendi akibat Salmonella seringkali sulit pulih sempurna.\n4. Berikan multivitamin untuk meningkatkan daya tahan tubuh selama masa pemulihan.\n5. Tingkatkan kebersihan kandang dengan menyemprotkan desinfektan bakterisida.',
'1. Berikan pakan berkualitas yang disimpan di tempat kering dan bebas dari tikus (tikus adalah pembawa utama Salmonella).\n2. Jaga kebersihan air minum dan gunakan filter air jika perlu.\n3. Jangan memasukkan burung baru tanpa melalui masa karantina yang ketat.\n4. Lakukan pembersihan rutin kotoran di dasar kandang untuk mengurangi populasi bakteri.\n5. Berikan probiotik secara berkala untuk memperkuat sistem imun saluran pencernaan.'),

('P05', 'Psittacosis',
'Psittacosis atau Ornithosis disebabkan oleh bakteri intraseluler Chlamydia psittaci. Penyakit ini menyerang sistem pernapasan dan mata, serta dapat menular ke manusia (zoonosis).',
'1. Berikan antibiotik golongan Tetracycline (seperti Doxycycline) secara konsisten selama 30-45 hari sesuai protokol medis.\n2. Isolasi burung di ruangan yang berventilasi sangat baik untuk mengurangi konsentrasi bakteri di udara.\n3. Gunakan masker dan sarung tangan saat membersihkan kandang burung sakit untuk mencegah penularan ke manusia.\n4. Berikan vitamin tambahan untuk mendukung sistem imun burung.\n5. Bersihkan kotoran burung secara basah (jangan disapu kering) agar debu yang mengandung bakteri tidak berterbangan.',
'1. Hindari membeli burung dari sumber yang tidak jelas kesehatannya.\n2. Pastikan sirkulasi udara di dalam kandang sangat baik dan tidak pengap.\n3. Jaga kebersihan lingkungan kandang dari tumpukan kotoran kering yang bisa menjadi debu.\n4. Batasi kontak antara burung peliharaan dengan burung liar.\n5. Lakukan desinfeksi kandang secara berkala menggunakan bahan yang aman bagi pernapasan burung.'),

('P06', 'Aspergillosis',
'Aspergillosis adalah infeksi jamur pada sistem pernapasan yang disebabkan oleh spora Aspergillus fumigatus. Jamur ini biasanya tumbuh pada pakan yang berjamur atau alas kandang yang lembap.',
'1. Segera ganti pakan dan alas kandang dengan yang baru dan berkualitas baik.\n2. Berikan obat antijamur seperti Itraconazole atau Fluconazole di bawah pengawasan dokter hewan.\n3. Pindahkan burung ke tempat yang udaranya bersih, segar, dan kering.\n4. Berikan terapi uap (nebulizer) dengan cairan antijamur jika terjadi sumbatan berat di saluran napas.\n5. Berikan nutrisi tinggi untuk membantu pemulihan kondisi fisik burung.',
'1. Jangan pernah memberikan pakan yang sudah terlihat berdebu, menggumpal, atau berbau apek.\n2. Simpan stok pakan di tempat yang kering dan berventilasi, gunakan wadah kedap udara.\n3. Pastikan alas kandang (serutan kayu/jerami) selalu kering dan tidak pernah dibiarkan basah/berjamur.\n4. Jaga agar kandang tidak lembap dan memiliki sirkulasi udara yang baik.\n5. Bersihkan sisa pakan yang tercecer di lantai kandang agar tidak menjadi media tumbuh jamur.'),

('P07', 'Avian Pox',
'Pox atau Cacar Burung disebabkan oleh virus Avipoxvirus. Penyakit ini ditandai dengan munculnya kutil atau keropeng pada area yang tidak berbulu (sekitar mata, paruh, kaki) atau bentuk basah di dalam mulut.',
'1. Oleskan antiseptik seperti Betadine atau salep antibiotik pada luka kutil untuk mencegah infeksi sekunder bakteri.\n2. Jangan mencabut kutil secara paksa karena akan menyebabkan perdarahan hebat dan penyebaran virus.\n3. Berikan tambahan vitamin A dosis tinggi untuk membantu kesehatan kulit dan membran mukosa.\n4. Jika kutil berada di dalam mulut, berikan makanan lunak agar burung tetap bisa makan.\n5. Isolasi burung sakit karena virus ini dapat menyebar melalui kontak langsung atau peralatan kandang.',
'1. Kendalikan populasi nyamuk di sekitar kandang, karena nyamuk adalah vektor utama penyebaran virus Pox.\n2. Gunakan kelambu atau kawat nyamuk pada ventilasi kandang.\n3. Vaksinasi Pox dapat dilakukan pada burung sehat untuk memberikan kekebalan jangka panjang.\n4. Jaga kebersihan lingkungan kandang agar tidak menjadi tempat berkembang biak nyamuk.\n5. Hindari menaruh burung di tempat yang banyak semak belukar atau genangan air.'),

('P08', 'Capillariasis',
'Capillariasis adalah infeksi cacing gelang halus (Capillaria spp.) yang menyerang kerongkongan, tembolok, atau usus. Cacing ini sangat kecil dan bisa menyebabkan kerusakan serius pada lapisan saluran pencernaan.',
'1. Berikan obat cacing yang efektif terhadap Capillaria seperti Levamisole, Fenbendazole, atau Ivermectin.\n2. Ulangi pemberian obat cacing setelah 2 minggu untuk membasmi larva yang baru menetas.\n3. Bersihkan kotoran burung secara total dan lakukan desinfeksi lantai kandang untuk mematikan telur cacing.\n4. Berikan suplemen vitamin A untuk membantu pemulihan dinding usus yang rusak akibat gigitan cacing.\n5. Pastikan burung mendapatkan asupan cairan yang cukup.',
'1. Berikan obat cacing secara rutin setiap 3-4 bulan sekali (program deworming).\n2. Jaga kebersihan lantai kandang dan pastikan burung tidak mematuk kotorannya sendiri.\n3. Hindari membiarkan burung mencari makan di tanah yang becek atau terkontaminasi kotoran burung lain.\n4. Pastikan kualitas air minum selalu terjaga.\n5. Jaga populasi inang perantara seperti cacing tanah atau serangga agar tidak masuk ke kandang.'),

('P09', 'Infeksi Parasit Darah',
'Parasit darah seperti Haemoproteus disebabkan oleh protozoa yang menyerang sel darah merah burung. Penyakit ini disebarkan melalui gigitan lalat pengisap darah (Pseudolynchia canariensis).',
'1. Berikan obat antimalaria/antiprotozoa seperti Chloroquine atau Pyrimethamine sesuai dosis yang disarankan pakar.\n2. Langkah terpenting adalah membasmi lalat merpati (kedani) yang ada di bulu burung menggunakan bedak atau semprotan antikutu yang aman.\n3. Berikan suplemen penambah darah (zat besi) dan multivitamin untuk mengatasi anemia.\n4. Pastikan burung beristirahat total dan tidak dilatih/diterbangkan selama masa pengobatan.\n5. Berikan nutrisi protein tinggi untuk mempercepat pembentukan sel darah merah baru.',
'1. Lakukan penyemprotan kandang secara berkala untuk membasmi lalat merpati dan serangga pengisap darah lainnya.\n2. Gunakan obat kutu/lalat tetes atau semprot pada burung secara rutin.\n3. Jaga kebersihan area sekitar kandang dari sampah atau kotoran yang mengundang lalat.\n4. Pastikan kandang mendapatkan sinar matahari yang cukup pada pagi hari.\n5. Pantau kondisi fisik burung secara berkala, terutama warna selaput lendir mulut (pastikan tetap merah muda, tidak pucat).'),

('P10', 'Coryza (Snot)',
'Coryza atau Snot adalah penyakit pernapasan yang disebabkan oleh bakteri Haemophilus gallinarum. Penyakit ini sangat umum dan ditandai dengan pembengkakan muka serta keluarnya cairan berbau dari hidung.',
'1. Berikan antibiotik yang sensitif terhadap bakteri gram negatif seperti Oxytetracycline, Erythromycin, atau Enrofloxacin.\n2. Bersihkan cairan yang keluar dari hidung dan mata secara rutin menggunakan kapas basah hangat.\n3. Lakukan uap panas (vapor therapy) sederhana untuk membantu burung melegakan pernapasan.\n4. Isolasi burung sakit agar tidak menulari burung lain melalui kontak langsung atau air minum.\n5. Tambahkan vitamin ke dalam air minum untuk membantu proses pemulihan daya tahan tubuh.',
'1. Jaga agar kondisi kandang tetap kering dan tidak lembap, terutama saat musim hujan.\n2. Hindari arus angin yang bertiup kencang langsung ke arah burung (draft) di malam hari.\n3. Pastikan ventilasi udara lancar sehingga tidak terjadi penumpukan gas amonia dari kotoran.\n4. Berikan pakan tambahan dan vitamin secara rutin untuk menjaga stamina burung.\n5. Jangan mencampur burung dari berbagai usia dalam satu kandang yang sempit.');

-- Insert Aturan and Aturan Detail
INSERT INTO aturan (id, id_penyakit) VALUES
('R01', 'P01'), ('R02', 'P01'), ('R03', 'P01'),
('R04', 'P02'), ('R05', 'P02'), ('R06', 'P02'),
('R07', 'P03'), ('R08', 'P03'), ('R09', 'P03'),
('R10', 'P04'), ('R11', 'P04'), ('R12', 'P04'),
('R13', 'P05'), ('R14', 'P05'), ('R15', 'P05'),
('R16', 'P06'), ('R17', 'P06'), ('R18', 'P06'),
('R19', 'P07'), ('R20', 'P07'), ('R21', 'P07'),
('R22', 'P08'), ('R23', 'P08'), ('R24', 'P08'),
('R25', 'P09'), ('R26', 'P09'), ('R27', 'P09'),
('R28', 'P10'), ('R29', 'P10'), ('R30', 'P10');

INSERT INTO aturan_detail (id_aturan, id_gejala) VALUES
('R01', 'G14'), ('R01', 'G15'), ('R01', 'G16'),
('R02', 'G14'), ('R02', 'G16'), ('R02', 'G17'),
('R03', 'G15'), ('R03', 'G16'), ('R03', 'G17'),
('R04', 'G19'), ('R04', 'G20'), ('R04', 'G21'),
('R05', 'G19'), ('R05', 'G21'), ('R05', 'G01'),
('R06', 'G20'), ('R06', 'G21'), ('R06', 'G25'),
('R07', 'G03'), ('R07', 'G04'), ('R07', 'G05'),
('R08', 'G03'), ('R08', 'G05'), ('R08', 'G23'),
('R09', 'G04'), ('R09', 'G05'), ('R09', 'G25'),
('R10', 'G03'), ('R10', 'G05'), ('R10', 'G24'),
('R11', 'G03'), ('R11', 'G02'), ('R11', 'G24'),
('R12', 'G05'), ('R12', 'G24'), ('R12', 'G25'),
('R13', 'G07'), ('R13', 'G08'), ('R13', 'G09'),
('R14', 'G08'), ('R14', 'G09'), ('R14', 'G10'),
('R15', 'G09'), ('R15', 'G10'), ('R15', 'G11'),
('R16', 'G11'), ('R16', 'G12'), ('R16', 'G13'),
('R17', 'G12'), ('R17', 'G13'), ('R17', 'G22'),
('R18', 'G11'), ('R18', 'G13'), ('R18', 'G26'),
('R19', 'G18'), ('R19', 'G06'), ('R19', 'G28'),
('R20', 'G18'), ('R20', 'G06'), ('R20', 'G02'),
('R21', 'G18'), ('R21', 'G28'), ('R21', 'G22'),
('R22', 'G01'), ('R22', 'G03'), ('R22', 'G05'),
('R23', 'G03'), ('R23', 'G23'), ('R23', 'G27'),
('R24', 'G05'), ('R24', 'G25'), ('R24', 'G27'),
('R25', 'G02'), ('R25', 'G22'), ('R25', 'G25'),
('R26', 'G01'), ('R26', 'G02'), ('R26', 'G30'),
('R27', 'G22'), ('R27', 'G25'), ('R27', 'G30'),
('R28', 'G07'), ('R28', 'G08'), ('R28', 'G09'),
('R29', 'G08'), ('R29', 'G09'), ('R29', 'G10'),
('R30', 'G09'), ('R30', 'G10'), ('R30', 'G12');
