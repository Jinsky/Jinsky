# Dokumentasi Flowchart Proyek Klinik Merpati

Dokumen ini berisi kumpulan flowchart yang menjelaskan alur kerja sistem pakar diagnosa penyakit merpati pada proyek Klinik Merpati.

## 1. Alur Proses Konsultasi & Diagnosa (User)
Menjelaskan bagaimana pengguna melakukan konsultasi dari awal hingga mendapatkan hasil.

```mermaid
graph TD
    A([Mulai]) --> B[Buka Halaman Konsultasi]
    B --> C[Input Nama Pemilik]
    C --> D[Pilih Gejala Fisik - Langkah 1]
    D --> E[Pilih Gejala Perilaku - Langkah 2]
    E --> F{Klik Tombol Diagnosa}
    F --> G[Sistem Menjalankan Forward Chaining]
    G --> H[Simpan Hasil ke Database]
    H --> I[Tampilkan Halaman Hasil]
    I --> J{Lihat Penyakit Lain?}
    J -- Ya --> K[Tampilkan List Penyakit Lain]
    J -- Tidak --> L([Selesai])
    K --> L
```

## 2. Logika Inferensi Forward Chaining
Detail teknis bagaimana fungsi `get_diagnosa()` mencocokkan gejala dengan aturan.

```mermaid
graph TD
    A([Mulai]) --> B[Terima Array Gejala Terpilih]
    B --> C[Ambil Semua Aturan & Detail dari DB]
    C --> D[Iterasi Setiap Aturan Penyakit]
    D --> E{Apakah Gejala Terpilih Cocok dengan Aturan?}
    E -- Ya --> F[Hitung Skor Confidence]
    E -- Tidak --> G[Lanjut ke Aturan Berikutnya]
    F --> H{Skor >= 3 Gejala?}
    H -- Ya --> I[Confidence = 100%]
    H -- Tidak --> J[Confidence = Count/3 * 100%]
    I --> K[Simpan ke Daftar Hasil Match]
    J --> K
    K --> L{Semua Aturan Selesai?}
    L -- Tidak --> D
    L -- Ya --> M[Urutkan Hasil Berdasarkan Confidence Terbesar]
    M --> N([Kembalikan Array Hasil])
```

## 3. Alur Katalog Penyakit & Gejala
Menjelaskan navigasi pengguna di halaman katalog informasi.

```mermaid
graph TD
    A([Mulai]) --> B[Buka Halaman Katalog]
    B --> C{Pilih Tab Informasi}
    C -- Info Penyakit --> D[Tampilkan Grid Penyakit]
    C -- Info Gejala --> E[Tampilkan Grid Gejala]
    D --> F[Cari Penyakit via Search Bar]
    E --> G[Cari Gejala via Search Bar]
    F --> H[Klik 'Baca Selengkapnya']
    H --> I[Tampilkan Halaman Detail Penyakit]
    I --> J([Selesai])
    G --> J
```

## 4. Alur Riwayat Diagnosa (User)
Menjelaskan bagaimana pengguna mencari dan memfilter data riwayat.

```mermaid
graph TD
    A([Mulai]) --> B[Buka Halaman Riwayat]
    B --> C[Sistem Load Data Riwayat]
    C --> D{Ingin Cari/Filter?}
    D -- Cari Nama --> E[Input Nama Pemilik di Search]
    D -- Filter Penyakit --> F[Pilih Penyakit di Dropdown]
    D -- Tidak --> G[Tampilkan Semua Riwayat]
    E --> H[Sistem Jalankan Query LIKE]
    F --> H
    H --> I[Update Tampilan List Riwayat]
    I --> J[Klik Lihat Detail]
    J --> K[Tampilkan Alert Detail Gejala]
    K --> L([Selesai])
    G --> I
```

## 5. Alur Autentikasi Admin
Proses login untuk masuk ke dashboard admin.

```mermaid
graph TD
    A([Mulai]) --> B[Buka Halaman Login Admin]
    B --> C[Input Username & Password]
    C --> D{Klik Tombol Masuk}
    D --> E{Cek Database / Mock}
    E -- Valid --> F[Set Session admin_id]
    E -- Tidak Valid --> G[Tampilkan Pesan Error]
    F --> H[Redirect ke Dashboard Index]
    G --> B
    H --> I([Selesai])
```

## 6. Pengelolaan Data Gejala (Admin)
Alur CRUD untuk data gejala klinis.

```mermaid
graph TD
    A([Mulai]) --> B[Masuk Menu Kelola Gejala]
    B --> C[Tampilkan Tabel Gejala]
    C --> D{Pilih Aksi}
    D -- Tambah --> E[Klik Tombol Tambah]
    E --> F[Input ID & Nama Gejala]
    F --> G[Klik Simpan]
    G --> H[Simpan ke Tabel gejala]
    H --> I[Refresh Tabel]
    D -- Hapus --> J[Klik Ikon Hapus]
    J --> K{Konfirmasi Hapus?}
    K -- Ya --> L[Hapus dari Tabel gejala]
    K -- Tidak --> C
    L --> I
    I --> M([Selesai])
```

## 7. Pengelolaan Data Penyakit (Admin)
Alur CRUD untuk data penyakit merpati.

```mermaid
graph TD
    A([Mulai]) --> B[Masuk Menu Kelola Penyakit]
    B --> C[Tampilkan Tabel Penyakit]
    C --> D{Pilih Aksi}
    D -- Tambah --> E[Klik Tombol Tambah]
    E --> F[Input ID, Nama, Deskripsi, Solusi, Pencegahan]
    F --> G[Klik Simpan]
    G --> H[Simpan ke Tabel penyakit]
    H --> I[Refresh Tabel]
    D -- Hapus --> J[Klik Ikon Hapus]
    J --> K{Konfirmasi Hapus?}
    K -- Ya --> L[Hapus dari Tabel penyakit]
    K -- Tidak --> C
    L --> I
    I --> M([Selesai])
```

## 8. Pengelolaan Aturan / Rule (Admin)
Menjelaskan cara membuat aturan utama penyakit.

```mermaid
graph TD
    A([Mulai]) --> B[Masuk Menu Kelola Aturan]
    B --> C[Tampilkan Daftar Aturan]
    C --> D[Klik Aturan Baru]
    D --> E[Input ID Aturan & Pilih Penyakit]
    E --> F[Klik Buat]
    F --> G[Simpan ke Tabel aturan]
    G --> H[Refresh Halaman]
    H --> I([Selesai])
```

## 9. Pengelolaan Detail Gejala pada Aturan (Admin)
Menjelaskan bagaimana admin memetakan gejala ke dalam suatu aturan penyakit.

```mermaid
graph TD
    A([Mulai]) --> B[Pilih Card Aturan di Kelola Aturan]
    B --> C{Pilih Aksi}
    C -- Tambah Gejala --> D[Klik Tombol Tambah Gejala]
    D --> E[Pilih Gejala & Input Bobot]
    E --> F[Klik Tambah]
    F --> G[Simpan ke Tabel aturan_detail]
    G --> H[Update Tampilan Tabel Detail]
    C -- Hapus Gejala --> I[Klik Ikon Close pada Baris Gejala]
    I --> J[Hapus dari Tabel aturan_detail]
    J --> H
    H --> K([Selesai])
```

## 10. Navigasi Dashboard Admin
Struktur navigasi internal di dalam panel admin.

```mermaid
graph TD
    A[Dashboard Index] --> B[Link Kelola Gejala]
    A --> C[Link Kelola Penyakit]
    A --> D[Link Kelola Aturan]
    A --> E[Logout]
    B --> A
    C --> A
    D --> A
    E --> F[Halaman Login]
```

## 11. Navigasi Menu Utama Website (Frontend)
Struktur navigasi antar halaman untuk pengguna umum.

```mermaid
graph TD
    A[Beranda/Index] --> B[Konsultasi]
    A --> C[Riwayat]
    A --> D[Katalog]
    A --> E[Tentang Kami]
    B --> F[Hasil Diagnosa]
    F --> B
    F --> C
    D --> G[Detail Penyakit]
    G --> D
    G --> B
```

## 12. Alur Persistensi Data Diagnosa
Bagaimana data dari form dikirim dan disimpan ke database.

```mermaid
graph TD
    A[Form konsultasi.php] -- POST Data --> B[Proses di hasil.php]
    B --> C[Panggil get_diagnosa]
    C --> D{Hasil Ditemukan?}
    D -- Ya --> E[Ambil Penyakit Top Match]
    E --> F[Panggil save_diagnosa]
    F --> G[INSERT INTO diagnosa]
    G --> H[Tampilkan Hasil ke User]
    D -- Tidak --> I[Tampilkan Pesan 'Tidak Ditemukan']
```
