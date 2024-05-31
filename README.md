# Petunjutk Instalasi sistem APTATOLA

## Persyaratan
- PHP 7.5 atau lebih
- Sudah terpasang Composer
- Sudah terpasang XAMPP
- Disarankan menggunakan VS Code

## Langkah-langah memasang APTATOLA
1. Lakukan clone repository ini / downlaod file zipnya
2. buka terminal di VS Code CTRL+` (pastikan berada di directori folder project)
3. jalankan perintah "composer install" (pastikan tidak ada yang error)
4. buat database dengan nama aptatola
5. selanjutnya, jalankan perintah "php spark migrate". ini untuk membuat tabel-tabel pada database
6. jalankan perintah "php spark serve" untuk menjalankan aplikasinya.

## akun untuk masuk APTATOLA
username : admin
password : admin

## Tambahan 
untuk teman-teman jika ingin mengganti nomer whatsapp untuk mengirim invoice bisa daftar akun di https://ultramsg.com/ lalu buat instace baru dan nanti tokennya diubah ya di bagian controllernya.
