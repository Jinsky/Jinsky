# Dokumentasi Pengujian Sistem - Klinik Merpati

Tabel di bawah ini merinci pengujian sistem menggunakan metode *Black-Box Testing* untuk memastikan fungsionalitas aplikasi Klinik Merpati berjalan sesuai dengan spesifikasi yang diharapkan.

## Tabel 4. 9 Pengujian Sistem Dengan *Black-Box Testing*

| No | Pengujian | Deskripsi | Hasil Yang Diharapkan | Hasil Pengujian | Keterangan |
|:---:|:---|:---|:---|:---|:---:|
| 1 | **Login Admin** | Melakukan login ke dashboard admin dengan username dan password yang benar. | Sistem berhasil memvalidasi akun dan mengalihkan ke dashboard admin. | Admin diarahkan ke halaman `admin/index.php`. | Berhasil |
| 2 | **Login Admin (Gagal)** | Melakukan login dengan kredensial (username/password) yang salah. | Sistem menampilkan pesan error dan tetap berada di halaman login. | Muncul notifikasi "Username atau password salah!" | Berhasil |
| 3 | **Logout Admin** | Mengakhiri sesi admin dengan menekan tombol logout. | Sistem menghapus sesi dan mengalihkan kembali ke halaman login. | Admin keluar dan diarahkan ke `admin/login.php`. | Berhasil |
| 4 | **Tambah Gejala** | Menambahkan data gejala baru melalui modal "Tambah Gejala". | Data gejala tersimpan ke database dan muncul di tabel daftar gejala. | Muncul pesan "Gejala berhasil ditambahkan." | Berhasil |
| 5 | **Edit Gejala** | Mengubah nama atau kode gejala yang sudah ada. | Perubahan data gejala tersimpan dan diperbarui pada tabel. | Muncul pesan "Gejala berhasil diperbarui." | Berhasil |
| 6 | **Hapus Gejala** | Menghapus data gejala dari sistem. | Data gejala terhapus dari database dan hilang dari tabel daftar. | Muncul pesan "Gejala berhasil dihapus." | Berhasil |
| 7 | **Tambah Penyakit** | Menambahkan data penyakit baru beserta deskripsi dan solusi. | Data penyakit baru muncul dalam daftar kelola penyakit. | Muncul pesan "Penyakit berhasil ditambahkan." | Berhasil |
| 8 | **Edit Penyakit** | Memperbarui informasi deskripsi, solusi, atau pencegahan penyakit. | Informasi terbaru tersimpan dan ditampilkan dengan benar. | Muncul pesan "Penyakit berhasil diperbarui." | Berhasil |
| 9 | **Hapus Penyakit** | Menghapus data penyakit dari sistem. | Data penyakit dihapus dan tidak lagi muncul di daftar atau katalog. | Muncul pesan "Penyakit berhasil dihapus." | Berhasil |
| 10 | **Tambah Aturan** | Membuat relasi baru antara penyakit dan kumpulan gejala (aturan baru). | Aturan baru terbentuk dan siap ditambahkan detail gejalanya. | Muncul pesan "Aturan berhasil dibuat." | Berhasil |
| 11 | **Detail Aturan** | Menambahkan gejala spesifik dan bobotnya ke dalam suatu aturan. | Gejala terpilih muncul di bawah aturan terkait dengan bobot yang sesuai. | Muncul pesan "Gejala ditambahkan ke aturan." | Berhasil |
| 12 | **Hapus Detail** | Menghapus salah satu gejala dari daftar detail aturan. | Gejala tersebut hilang dari daftar detail aturan terkait. | Muncul pesan "Gejala dihapus dari aturan." | Berhasil |
| 13 | **Konsultasi** | Mengisi nama pemilik dan memilih beberapa gejala pada form konsultasi. | Sistem menerima input dan siap melakukan proses diagnosa. | Input diterima dan tombol diagnosa aktif. | Berhasil |
| 14 | **Hasil Diagnosa** | Menjalankan diagnosa dengan gejala yang memiliki kecocokan di aturan. | Sistem menampilkan nama penyakit, persentase kecocokan, dan solusi. | Muncul halaman hasil dengan detail penyakit yang sesuai. | Berhasil |
| 15 | **Diagnosa Gagal** | Menjalankan diagnosa dengan gejala yang tidak terdaftar di aturan manapun. | Sistem memberikan informasi bahwa diagnosa tidak ditemukan. | Muncul pesan "Diagnosis Tidak Ditemukan." | Berhasil |
| 16 | **Cari Riwayat** | Mencari data hasil diagnosa berdasarkan nama pemilik merpati. | Tabel riwayat menampilkan baris yang sesuai dengan nama yang dicari. | Baris data tersaring sesuai input pencarian. | Berhasil |
| 17 | **Filter Riwayat** | Menyaring riwayat diagnosa berdasarkan jenis penyakit tertentu. | Sistem menampilkan daftar riwayat hanya untuk penyakit yang dipilih. | Data riwayat terfilter sesuai pilihan dropdown. | Berhasil |
| 18 | **Cari Katalog** | Mencari informasi penyakit atau gejala di halaman katalog. | Grid katalog menampilkan kartu informasi yang relevan dengan kata kunci. | Hasil pencarian muncul secara real-time/setelah submit. | Berhasil |
| 19 | **Detail Katalog** | Menekan "Baca Selengkapnya" pada kartu penyakit di katalog. | Sistem mengarahkan ke halaman detail penyakit yang lengkap. | Muncul halaman `detail_penyakit.php` dengan data lengkap. | Berhasil |
