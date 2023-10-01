<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Tentang Perpustakaan Sederhana

Sistem Informasi Manajemen Perpustakaan Sederhana ini adalah -seperti namanya- sebuah sistem sederhana untuk mengelola perpustakaan dari manajemen pustakawan, anggota, buku, hingga peminjaman buku yang dibuat dengan sesederhana mungkin agar mudah digunakan.

Sebetulnya dulu sudah pernah ada aplikasinya, tetapi source codenya tidak ada lagi. Adapun videonya bisa dilihat di [YouTube](https://www.youtube.com/watch?v=Chu2aATRjKg).

## Fitur Perpustakaan Sederhana

| Status | Role          | Modul                     | Keterangan |
| :----: | ------------- | ------------------------- | :--------: |
|   ✅   | _Semua_       | Login                     |     👍     |
|   ❌   | _Semua_       | Login dengan Gmail        |     ✨     |
|   ✅   | Administrator | Manajemen Pustakawan      |    👍📬    |
|   ✅   | Pustakawan    | Manajemen Anggota         |    👍📬    |
|   ❌   | Pustakawan    | Manajemen Buku            |    👍║▌    |
|   ❌   | Pustakawan    | Manajemen Peminjaman Buku |   👍💰📬   |
|   ❌   | Pustakawan    | Cetak Kartu Angota        |   ✨💰📬   |
|   ❌   | Anggota       | Histori Peminjaman Buku   |     👍     |
|   ✅   | _Semua_       | Ubah Profil               |     👍     |
|   ✅   | _Semua_       | Ubah Password             |     👍     |

Keterangan:

✅ = Sudah ada dan mungkin butuh modifikasi lebih baik
❌ = Belum ada
⏲️ = Dalam pengerjaan
📬 = Butuh SMTP
║▌ = Butuh barcode scanner (atau logikanya)
💰 = Butuh perhitungan uang
👍 = Wajib ada
✨ = _Nice to have_

> **Administrator juga dapat akses terhadap seluruh aksi yang dapat dilakukan oleh Pustakawan.**

## Alur Bisnis

### Login

-   Seluruh user bisa login setelah melakukan verifikasi email.

### Manajemen Pustakawan

-   Admin menambahkan user pustakawan dari panel (minimal nama dan email).
-   Pustakawan menerima email verifikasi berisi link untuk set password.
-   Pustakawan belum bisa login sebelum melakukan verifikasi di atas.
-   Pustakawan belum bisa melakukan transaksi peminjaman buku sebelum melengkapi seluruh data diri.

### Manajemen Anggota

-   Pustakawan menambahkan user anggota dari panel (minimal nama dan email).
-   Anggota menerima email verifikasi berisi link untuk set password.
-   Anggota belum bisa login sebelum melakukan verifikasi di atas.
-   Anggota belum bisa meminjam buku sebelum melengkapi seluruh data diri.

### Manajemen Buku

-   Proses **_create_** buku adalah sebagai berikut:

    -   Admin menginput ISBN terlebih dahulu, bisa dengan barcode scanner atau tulis manual, kemudian klik tombol "Simpan".
    -   Selanjutnya untuk mengisi data-data buku lainnya.

### Peminjaman Buku

- Pustakawan scan kartu anggota atau input nomor anggota dahulu.
- Selanjutnya tinggal scan barcode ISBN pada buku.
- Secara *default*, batas waktu peminjaman adalah tiga (3) hari. Lebih dari itu akan dikenakan biaya Rp 500.
- Nominal denda diatur di file .env dengan *key* **DENDA_RUPIAH**.

## Kontribusi

Terima kasih atas niatan kontribusinya kepada Sistem Informasi Manajemen Perpustakaan Sedehana ini. 

Silahkan ajukan *Pull Request* jika ada penambahan, pengurangan, atau perbaikan fitur serta ajukan *Issue* jika menemukan kekeliruan dalam sistem yang ada, khususnya dari demo yang disediakan.

## License

Sistem Informasi Manajemen Pepustakaan Sederhana dibuat dengan [MIT license](https://opensource.org/licenses/MIT).