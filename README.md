# Narria

**Narria** adalah platform baca novel online berbasis CodeIgniter 4 yang memungkinkan pembaca menjelajahi berbagai novel, dan penulis (role **Author**) dapat mengunggah karya mereka sendiri.

##  Fitur Utama

- 🔐 **Autentikasi**: Login & pendaftaran pengguna (reader & author)
- 📚 **Daftar Novel**: Halaman utama menampilkan daftar novel
- 📖 **Detail Novel**: Halaman informasi novel lengkap dengan daftar bab
- 🔍 **Pencarian & Filter**: Cari dan filter novel berdasarkan judul, penulis, atau kategori
- 👤 **Profil Pengguna**: Halaman profil pengguna (reader/author)
- 🛠 **Dashboard**:
  - **Admin**: Kelola pengguna, novel, dan kategori
  - **Author**: Kelola novel karya sendiri

##  Teknologi

- **Backend**: CodeIgniter 4  
- **Frontend**:
  - Bootstrap 4 (menggunakan Stisla Admin Template)
  - Tailwind CSS
- **Database**: MySQL

##  Instalasi & Setup

Ikuti langkah-langkah berikut untuk menjalankan proyek di lingkungan lokal:

1. Clone repositori:
   ```bash
   git clone https://github.com/Naaufal/narria.git
   cd narria

2. Install dependencies:

```bash
composer install
```

3. Salin file environment dan setting konfigurasi:

```bash 
cp env .env
```

  - Buka file .env, sesuaikan:
      - app.baseURL dengan URL aplikasi (misal http://localhost:8080/)
      - Pengaturan database (hostname, database, username, password)

4. Terapkan migrasi dan (opsional) seed data:

```bash
php spark migrate
# Jika ada, jalankan seed:
# php spark db:seed SomeSeeder
```

5. Atur web server agar root mengarah ke folder public/, atau gunakan built-in server:
```bash
php spark serve --host=localhost --port=8080
```

6. Buka di browser:

    http://localhost:8080

Aturan Web Server & index.php

Pastikan web server kamu mengarah ke folder public/, sebab index.php sudah dipindahkan kesana demi keamanan dan struktur yang baik—sesuai praktik di CodeIgniter 4
GitHub+1
.
Prasyarat Server

Pastikan sistem memenuhi prasyarat berikut:

    PHP ≥ 8.1

    Ekstensi PHP: intl, mbstring, json (aktif secara default), mysqlnd, dan libcurl (jika menggunakan HTTP/CURLRequest)
    GitHub
    .

Screenshot

Halaman utama Narria:
Lisensi

Lisensi proyek ini adalah MIT License, seperti terdapat di repositori. Silakan cek file LICENSE untuk detail lengkap.
