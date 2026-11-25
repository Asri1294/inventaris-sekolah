
# Sistem Inventaris Sekolah

Aplikasi web untuk mengelola inventaris sekolah, khususnya pencatatan peminjaman dan pengembalian barang. Sistem ini dikembangkan untuk menggantikan pencatatan manual menggunakan buku dengan pengelolaan data yang lebih terstruktur, memudahkan pencarian barang, memantau peminjaman, serta menyimpan riwayat.

Aplikasi dibangun menggunakan Laravel 11, Blade, Laravel Breeze, dan MySQL.

## Fitur Aplikasi

### Administrator

- Mengelola kategori barang.
- Mengelola data barang, termasuk kode barang unik, stok, dan kondisi barang.
- Mengelola data pengguna.
- Memverifikasi pengajuan peminjaman dengan menyetujui atau menolak pengajuan.
- Mencatat dan memverifikasi pengembalian barang.
- Melihat riwayat aktivitas sistem, meliputi aktivitas tambah, ubah, hapus, masuk, dan keluar akun.
- Melihat dashboard ringkasan informasi inventaris dan peminjaman.
- Mengelola data menggunakan mekanisme soft delete (penghapusan lunak) pada data tertentu, sehingga data tidak langsung dihapus secara permanen dari database.

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
- Pencarian, filter, dan pagination pada tabel data.
- Perhitungan status keterlambatan berdasarkan tanggal jatuh tempo.
- Validasi input pada formulir.
- Format tanggal dan angka yang disesuaikan dengan standar Indonesia.
- Tampilan responsif yang mendukung perangkat ponsel, tablet, dan komputer.


