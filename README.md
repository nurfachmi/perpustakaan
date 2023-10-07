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
|   🔧   | Pustakawan    | Manajemen Buku            |    👍║▌    |
|   ✅   | Pustakawan    | Manajemen Peminjaman Buku |  👍║▌💰📬  |
|   ❌   | Pustakawan    | Cetak Kartu Angota        |   ✨💰📬   |
|   ❌   | Anggota       | Histori Peminjaman Buku   |     👍     |
|   ✅   | _Semua_       | Ubah Profil               |     👍     |
|   ✅   | _Semua_       | Ubah Password             |     👍     |

Keterangan:

✅ = Sudah ada dan mungkin butuh modifikasi lebih baik  
🔧 = Sudah ada dan butuh perbaikan segera
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

-   Pustakawan scan kartu anggota atau input nomor anggota dahulu.
-   Selanjutnya tinggal scan barcode ISBN pada buku.
-   Secara _default_, batas waktu peminjaman adalah tiga (3) hari. Lebih dari itu akan dikenakan biaya Rp 500.
-   Nominal denda diatur di file .env dengan _key_ **DENDA_RUPIAH**.

## Cara menjalankan aplikasi
1. Install [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos) secara global (tanpa docker)
2. Install [Docker](https://docs.docker.com/get-docker/)
3. Salin repositori
    ```sh
    git clone https://github.com/nurfachmi/perpustakaan.git
    ```
4. Setelah repositori disalin, install *dependencies* dengan Composer
    ```sh
    cd perpustakaan
    composer install
    ```
5. salin file `.env.example` dan beri nama `.env`
    ```sh
    cp .env.example .env
    ```
6. Jalankan aplikasi dengan sail
    ```sh
    ./vendor/bin/sail up
    ```
7. Tunggu proses instalasi dengan docker sampai selesai
8. Setelah berhasil, bisa coba akses `http://localhost`
9. Migrate seeder untuk bisa masuk dengan kredensial bawaan
    ```sh
    docker exec -it perpustakaan-laravel.test-1 /bin/bash -c "php artisan db:seed"
    ```
10. Masuk dengan email `admin@nurfachmi.com` dan password `password`


## Kontribusi

Terima kasih atas niatan kontribusinya kepada Sistem Informasi Manajemen Perpustakaan Sedehana ini.

Silahkan ajukan _Pull Request_ jika ada penambahan, pengurangan, atau perbaikan fitur serta ajukan _Issue_ jika menemukan kekeliruan dalam sistem yang ada, khususnya dari demo yang disediakan.

## License

Sistem Informasi Manajemen Pepustakaan Sederhana dibuat dengan [MIT license](https://opensource.org/licenses/MIT).
