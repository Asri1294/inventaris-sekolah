
# Sistem Inventaris Sekolah

Aplikasi web untuk mengelola inventaris sekolah, khususnya pencatatan peminjaman dan pengembalian barang. Sistem ini dikembangkan untuk menggantikan pencatatan manual menggunakan buku dengan pengelolaan data yang lebih terstruktur, memudahkan pencarian barang, memantau peminjaman, serta menyimpan riwayat aktivitas.

Aplikasi dibangun menggunakan Laravel 11, Blade, Laravel Breeze, dan MySQL.

## Fitur Aplikasi

### Administrator
- Mengelola kategori barang.
- Mengelola data barang, termasuk kode barang unik, stok, dan kondisi barang.
- Mengelola data pengguna.
- Memverifikasi pengajuan peminjaman dengan menyetujui atau menolak pengajuan.
- Mencatat peminjaman secara langsung.
- Mencatat dan memverifikasi pengembalian barang.
- Melihat riwayat aktivitas sistem, meliputi aktivitas tambah, ubah, hapus, masuk, dan keluar akun.
- Melihat dashboard ringkasan informasi inventaris dan peminjaman.
- Menghapus kategori, barang, dan riwayat peminjaman memakai soft delete (penghapusan lunak), sehingga data tidak langsung hilang permanen dari database.

### Pengguna
- Melihat daftar barang yang tersedia untuk dipinjam.
- Mengajukan peminjaman barang.
- Melihat riwayat peminjaman pribadi.
- Mencari dan memfilter riwayat peminjaman berdasarkan status.
- Melihat dashboard ringkasan peminjaman pribadi.

### Fitur Umum
- Autentikasi pengguna melalui fitur login dan register Laravel Breeze.
- Pembagian hak akses administrator dan pengguna.
- Menu dan akses halaman disesuaikan berdasarkan peran pengguna.
- Formulir Register memakai Form Request (`RegisterRequest`). Formulir login dan kata sandi (ubah, lupa, reset) memakai validasi bawaan Breeze.
- Pencarian, filter, dan pagination pada tabel data sesuai halaman.
- Perhitungan status keterlambatan berdasarkan tanggal jatuh tempo.
- Format tanggal dan angka yang disesuaikan dengan standar Indonesia.
- Tampilan responsif yang mendukung perangkat ponsel, tablet, dan komputer.

## Teknologi yang Digunakan

| Teknologi | Keterangan |
|---|---|
| Laravel 11 | Framework pengembangan aplikasi web |
| PHP | Bahasa pemrograman sisi server |
| Blade | Template engine Laravel untuk tampilan |
| Laravel Breeze | Fitur autentikasi |
| MySQL | Sistem pengelolaan basis data |
| Tailwind CSS | Framework CSS untuk antarmuka |
| Alpine.js | Mendukung interaksi antarmuka ringan |
| Vite | Pengelolaan dan pembangunan aset frontend |
| Composer | Pengelolaan dependensi PHP |
| NPM | Pengelolaan dependensi frontend |
| Git | Pengelolaan versi kode |

## Persyaratan Instalasi

Pastikan perangkat telah memiliki:
- PHP 8.2 atau lebih baru.
- Composer.
- Node.js versi LTS (disarankan versi 18 atau lebih baru).
- NPM.
- MySQL.
- Git.
- XAMPP atau lingkungan lain yang menyediakan MySQL.

## Instalasi dan Menjalankan Aplikasi

### 1. Clone Repository

Buka terminal, kemudian jalankan:

```bash
git clone https://github.com/Asri1294/inventaris-sekolah.git
```

Masuk ke direktori proyek:

```bash
cd inventaris-sekolah
```

### 2. Instal Dependensi PHP

Jalankan perintah berikut untuk memasang dependensi Laravel:

```bash
composer install
```

### 3. Instal Dependensi Frontend

Pasang dependensi frontend menggunakan NPM:

```bash
npm install
```

### 4. Konfigurasi Environment

Buat file `.env` berdasarkan file `.env.example`.

Untuk Windows CMD:

```bash
copy .env.example .env
```

Untuk PowerShell:

```powershell
Copy-Item .env.example .env
```

Buka file `.env`, kemudian sesuaikan konfigurasi database:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_inventaris
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan konfigurasi MySQL pada perangkat masing-masing.

Pastikan konfigurasi bahasa aplikasi menggunakan:

```dotenv
APP_LOCALE=id
```

### 5. Membuat Database

Pastikan MySQL sudah berjalan. Jika menggunakan XAMPP, klik **Start** pada baris MySQL di XAMPP Control Panel.

Buka phpMyAdmin melalui alamat:

```text
http://localhost/phpmyadmin/
```

Buat database baru dengan nama:

```text
db_inventaris
```

### 6. Generate Application Key

Jalankan perintah berikut untuk membuat application key:

```bash
php artisan key:generate
```

### 7. Menjalankan Migrasi dan Seeder

Jalankan perintah berikut untuk membuat tabel database sekaligus mengisi data awal aplikasi:

```bash
php artisan migrate --seed
```

### 8. Menjalankan Aset Frontend

Jalankan Vite menggunakan perintah:

```bash
npm run dev
```

Biarkan terminal ini tetap terbuka selama aplikasi dijalankan.

### 9. Menjalankan Server Laravel

Buka terminal baru (terminal kedua), lalu jalankan perintah:

```bash
php artisan serve
```

### 10. Membuka Aplikasi

Setelah server Laravel berjalan, buka browser dan akses alamat berikut:

```text
http://127.0.0.1:8000
```

## Akun Pengguna Seeder

Aplikasi menyediakan beberapa akun awal yang dapat digunakan untuk mencoba fitur berdasarkan peran masing-masing.

| Peran | Email | Kata Sandi |
|---|---|---|
| Administrator | admin@sekolah.test | password |
| Pengguna | maya@sekolah.test | password |
| Pengguna | ratih@sekolah.test | password |

Akun tersebut merupakan akun pengujian yang dibuat melalui seeder. Untuk penggunaan di lingkungan sebenarnya, gunakan akun dan kata sandi yang sesuai.

## Ketentuan dan Perilaku Sistem

- Barang dapat dipinjam selama stok tersedia dan kondisi barang bukan rusak berat.
- Stok barang berkurang ketika pengajuan peminjaman disetujui, atau ketika administrator mencatat peminjaman langsung.
- Stok barang bertambah kembali setelah pengembalian diverifikasi oleh administrator, kecuali jika kondisi barang saat dikembalikan rusak berat.
- Status peminjaman meliputi diajukan, dipinjam, dikembalikan, terlambat, dan ditolak. Status diajukan dan ditolak ditambahkan di luar brief untuk melengkapi alur persetujuan.
- Status terlambat dihitung dari tanggal jatuh tempo setiap kali halaman terkait dibuka, bukan berjalan terjadwal di latar belakang. Penjadwalan otomatis dengan scheduler Laravel dicatat sebagai pengembangan lanjutan.
- Riwayat peminjaman berstatus dikembalikan atau ditolak dapat dihapus menggunakan soft delete.
- Akun yang masih memiliki data peminjaman (termasuk yang sudah dihapus lunak (soft delete)) atau riwayat aktivitas tidak dapat dihapus.
- Fitur hapus akun sendiri pada halaman Profil ditiadakan, dan administrator tidak dapat menghapus akunnya sendiri dari daftar pengguna.
- Akun yang dibuat administrator melalui menu Pengguna tidak berstatus email terverifikasi, namun tetap dapat masuk.
- Percobaan login yang gagal tidak dicatat di log aktivitas.
- Kondisi barang dicatat per jenis barang, bukan per unit.
- Kartu "Sedang Dipinjam" di dashboard menghitung peminjaman berstatus dipinjam saja.
- Singkatan bulan Agustus tampil sebagai "Agt" (bawaan Carbon).
- Pada formulir ubah akun oleh administrator, kata sandi yang dikosongkan berarti kata sandi lama tidak diganti.
- Fitur lupa dan reset kata sandi bawaan Breeze tersedia, tetapi pengiriman email belum dikonfigurasi (email hanya ditulis ke log), sehingga tautan reset tidak terkirim ke kotak masuk.
- Dashboard administrator dan pengguna menampilkan ringkasan informasi yang berbeda sesuai hak akses.
- Tabel data menyediakan pagination, pencarian, dan filter sesuai halaman.
- Format tanggal, angka, dan pesan validasi disesuaikan dengan bahasa Indonesia.
- Halaman tertentu menggunakan breadcrumb sebagai penunjuk lokasi navigasi, Dashboard sengaja tanpa breadcrumb.
- Halaman utama (`/`) mengarahkan pengguna ke halaman login.

## Struktur Pengelolaan Data

Aplikasi menggunakan beberapa tabel utama dalam database:

| Tabel | Keterangan |
|---|---|
| `users` | Menyimpan data akun administrator dan pengguna |
| `categories` | Menyimpan kategori barang |
| `items` | Menyimpan data inventaris barang |
| `loans` | Menyimpan data transaksi peminjaman |
| `return_logs` | Menyimpan catatan pengembalian barang |
| `activity_logs` | Menyimpan riwayat aktivitas pengguna dalam sistem |

Pengelolaan data menggunakan Eloquent ORM dari Laravel untuk mengatur hubungan antartabel dan mempermudah proses pengambilan maupun pengolahan data.

## Catatan

- Aplikasi dikembangkan dengan Laravel 11 sesuai brief (Laravel 11+). Berdasarkan tabel dukungan resmi Laravel, masa dukungan keamanan Laravel 11 berakhir pada 12 Maret 2026, sehingga untuk penggunaan jangka panjang disarankan melakukan upgrade ke versi yang masih didukung.
- Konfigurasi lingkungan pengembangan dapat berbeda pada setiap perangkat, terutama pada pengaturan PHP, MySQL, dan kredensial database.
- Folder `vendor` dan `node_modules` tidak disertakan dalam repository. Keduanya dapat dibuat kembali dengan menjalankan `composer install` dan `npm install`.
- Font antarmuka dimuat dari fonts.bunny.net (CDN). Jika koneksi internet terputus, tampilan tetap berjalan dengan font cadangan. Gambar logo, favicon, dan ikon disimpan di dalam proyek.

## Catatan Keamanan

Pemeriksaan paket dijalankan pada 26 Nov 2026.

- `composer audit` melaporkan 5 catatan keamanan pada `laravel/framework`. Perbaikannya hanya tersedia di Laravel 12 ke atas, sedangkan proyek ini memakai Laravel 11. Laravel 11 tidak dinaikkan versinya karena brief meminta Laravel 11 atau lebih baru dan perubahan versi besar berisiko mengubah fitur yang sudah berjalan. Sebelum dipakai di server sungguhan, disarankan naik ke Laravel 12.
- `npm audit` melaporkan 2 catatan (1 sedang, 1 tinggi) pada `esbuild` dan `vite`. Catatan ini hanya berlaku saat server pengembangan menyala (`npm run dev`). Jangan menjalankan `npm audit fix --force` karena memaksa naik ke versi besar yang dapat merusak tampilan. Hentikan `npm run dev` saat tidak dipakai.
- `APP_ENV=local` dan `APP_DEBUG=true` hanya untuk pengembangan. Untuk server sungguhan gunakan `APP_ENV=production` dan `APP_DEBUG=false`.

## Repository

Source code aplikasi dapat diakses melalui GitHub:

https://github.com/Asri1294/inventaris-sekolah
