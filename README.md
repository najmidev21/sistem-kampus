# App Pelatihan — Sistem Informasi Akademik Sederhana

Aplikasi web berbasis **PHP native + MySQL/MariaDB** untuk mengelola data akademik: mahasiswa, dosen, mata kuliah, semester, jadwal kuliah, dan KRS (Kartu Rencana Studi). Tampilan memakai template **SB Admin 2** (Bootstrap 4), dan semua operasi CRUD berjalan lewat **AJAX** tanpa reload halaman.

## Fitur

- **Login & logout** berbasis session
- **Dashboard** berisi ringkasan jumlah data tiap modul
- **Master Data**
  - Mahasiswa (NIM, nama, alamat, jurusan)
  - Dosen (kode dosen, nama, alamat)
  - Mata Kuliah (kode, nama, SKS)
  - Semester
- **Transaksi**
  - Jadwal (dosen + mata kuliah + waktu + ruang)
  - KRS (mahasiswa + jadwal + semester)
- **Manajemen User** (tambah, ubah, hapus akun login)
- Validasi error database dengan pesan yang ramah, misalnya kode/NIM duplikat atau data yang masih dipakai tabel lain tidak bisa dihapus

## Teknologi

| Bagian     | Teknologi                                      |
|------------|------------------------------------------------|
| Backend    | PHP 7.4+ (kompatibel PHP 8), ekstensi `mysqli` |
| Database   | MySQL / MariaDB 10.4+                          |
| Frontend   | Bootstrap 4 (SB Admin 2), jQuery, Font Awesome |
| Lainnya    | DataTables, Chart.js (bawaan template)         |

## Struktur Folder

```
app_pelatihan/
├── asset/              # CSS, JS, gambar, dan library vendor (SB Admin 2)
├── dosen/              # Modul CRUD dosen
├── jadwal/             # Modul CRUD jadwal
├── krs/                # Modul CRUD KRS
├── mahasiswa/          # Modul CRUD mahasiswa
├── matkul/             # Modul CRUD mata kuliah
├── semester/           # Modul CRUD semester
├── user/               # Modul CRUD user
├── dashboard.php       # Halaman utama setelah login (layout + loader AJAX)
├── db.php              # Class koneksi database
├── db_pelatihan.sql    # Dump database (struktur + data awal)
├── index.php           # Redirect ke login.php
├── login.php           # Halaman login
└── logout.php          # Menghapus session lalu kembali ke login
```

Setiap folder modul punya empat file dengan pola yang sama:

| File         | Fungsi                                                     |
|--------------|------------------------------------------------------------|
| `list.php`   | Menampilkan tabel data beserta tombol Tambah/Edit/Hapus    |
| `form.php`   | Form tambah/edit (mode edit jika menerima parameter `key`) |
| `simpan.php` | Memproses INSERT/UPDATE, membalas `ok` atau pesan error    |
| `hapus.php`  | Memproses DELETE berdasarkan `key`, membalas `ok`/error    |

## Struktur Database

Database: `db_pelatihan`

| Tabel           | Kolom                                         | Keterangan                    |
|-----------------|-----------------------------------------------|-------------------------------|
| `tbl_user`      | `id`, `username`, `password`                  | Akun login                    |
| `tbl_mahasiswa` | `nim` (PK), `nama`, `alamat`, `jurusan`       |                               |
| `tbl_dosen`     | `kd_dosen` (PK), `nama`, `alamat`             |                               |
| `tbl_matkul`    | `kd_matkul` (PK), `nama`, `sks`               |                               |
| `tbl_semester`  | `kd_semester` (PK), `semester`                |                               |
| `tbl_jadwal`    | `id` (PK), `kd_dosen`, `kd_matkul`, `waktu`, `ruang` | FK ke dosen & matkul   |
| `tbl_krs`       | `id` (PK), `nim`, `id_jadwal`, `kd_semester`  | FK ke mahasiswa, jadwal, semester |

Relasi:

```
tbl_dosen ──┐
            ├──> tbl_jadwal ──┐
tbl_matkul ─┘                 │
tbl_mahasiswa ────────────────┼──> tbl_krs
tbl_semester ─────────────────┘
```

## Instalasi (XAMPP)

1. Salin folder project ke `htdocs`, misalnya `C:\xampp\htdocs\app_pelatihan`.
2. Jalankan **Apache** dan **MySQL** dari XAMPP Control Panel.
3. Buka **phpMyAdmin** (`http://localhost/phpmyadmin`), buat database baru bernama `db_pelatihan`.
4. Import file `db_pelatihan.sql` ke database tersebut.
5. Jika konfigurasi MySQL berbeda dari default, sesuaikan koneksi di [db.php](db.php):
   ```php
   $this->koneksi = new mysqli("localhost", "root", "", "db_pelatihan");
   ```
6. Buka aplikasi di browser: `http://localhost/app_pelatihan`

## Login Default

| Username | Password |
|----------|----------|
| `admin`  | `admin`  |

Segera ganti password default lewat menu **User** setelah login pertama.

## Cara Kerja Singkat

- `dashboard.php` menjadi satu-satunya halaman penuh. Klik menu di sidebar memanggil fungsi JavaScript `loadPage(modul, file, params)`, yang memuat `modul/list.php` atau `modul/form.php` ke area konten lewat `$.get`.
- Form dengan class `.form-ajax` dikirim lewat `$.post` ke `simpan.php`. Jika balasannya `ok`, daftar data dimuat ulang; jika bukan, pesan error ditampilkan.
- Tombol hapus memanggil `hapusData(modul, key)`, yang mengirim POST ke `modul/hapus.php`.
- Semua file modul mengecek `$_SESSION['status']`. Akses tanpa login ditolak.
- Query memakai **prepared statement** (`mysqli::prepare`) untuk mencegah SQL injection, dan output ditampilkan dengan `htmlspecialchars`.

## Catatan Keamanan

Project ini dibuat untuk keperluan pelatihan. Sebelum dipakai di lingkungan produksi, perhatikan hal berikut:

- Password user masih disimpan sebagai **teks biasa**. Sebaiknya gunakan `password_hash()` dan `password_verify()`.
- Kredensial database ditulis langsung di `db.php`.
- Belum ada proteksi CSRF pada form.

## Pembuat

Nur Najmi Laila Putri
