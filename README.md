# Narria 📚

**Narria** adalah platform baca novel online berbasis **CodeIgniter 4** yang memungkinkan pembaca menjelajahi berbagai novel, dan penulis (role Author) dapat mengunggah karya mereka sendiri.

<img width="1919" height="950" alt="Cuplikan layar 2025-07-13 192111" src="https://github.com/user-attachments/assets/67dc0dfc-bbd7-451c-b160-60eeb991804a" />

## ✨ Fitur Utama

- 🔐 **Autentikasi**: Login & pendaftaran pengguna (reader & author)
- 📚 **Daftar Novel**: Halaman utama menampilkan daftar novel dengan desain yang menarik
- 📖 **Detail Novel**: Halaman informasi novel lengkap dengan daftar bab
- 🔍 **Pencarian & Filter**: Cari dan filter novel berdasarkan judul, penulis, atau kategori
- 👤 **Profil Pengguna**: Halaman profil pengguna (reader/author)
- 🛠 **Dashboard Multi-Role**:
  - **Admin**: Kelola pengguna, novel, dan kategori
  - **Author**: Kelola novel karya sendiri

## 🛠 Teknologi yang Digunakan

- **Backend**: CodeIgniter 4
- **Frontend**: 
  - Bootstrap 4 (menggunakan Stisla Admin Template)
  - Tailwind CSS
- **Database**: MySQL

## 📋 Prasyarat

Pastikan sistem memenuhi prasyarat berikut:

- **PHP** ≥ 8.1
- **Ekstensi PHP**: 
  - `intl`
  - `mbstring`
  - `json` (aktif secara default)
  - `mysqlnd`
  - `libcurl` (jika menggunakan HTTP/CURLRequest)
- **MySQL/MariaDB**
- **Composer**

## 🚀 Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di lingkungan lokal:

### 1. Clone Repositori
```bash
git clone https://github.com/Naaufal/narria.git
cd narria
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Konfigurasi Environment
```bash
cp env .env
```

Buka file `.env` dan sesuaikan konfigurasi:
- `app.baseURL` dengan URL aplikasi (misal `http://localhost:8080/`)
- Pengaturan database (hostname, database, username, password)

### 4. Setup Database
```bash
# Terapkan migrasi database
php spark migrate

# Jika ada seed data, jalankan:
# php spark db:seed SomeSeeder
```

### 5. Jalankan Aplikasi
```bash
# Menggunakan built-in server CodeIgniter
php spark serve --host=localhost --port=8080
```

### 6. Akses Aplikasi
Buka browser dan kunjungi: `http://localhost:8080`

## ⚙️ Konfigurasi Web Server

**Penting**: Pastikan web server kamu mengarah ke folder `public/`, sebab `index.php` sudah dipindahkan kesana demi keamanan dan struktur yang baik—sesuai praktik terbaik di CodeIgniter 4.

### Apache
```apache
DocumentRoot /path/to/narria/public
```

### Nginx
```nginx
root /path/to/narria/public;
index index.php index.html;
```

## 📸 Screenshot

![Halaman Utama](screenshot.png)
*Halaman utama Narria menampilkan daftar novel dengan desain yang clean dan modern*

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan:

1. Fork repositori ini
2. Buat branch fitur baru (`git checkout -b feature/amazing-feature`)
3. Commit perubahan (`git commit -m 'Add some amazing feature'`)
4. Push ke branch (`git push origin feature/amazing-feature`)
5. Buka Pull Request

## 📝 Lisensi

Proyek ini dilisensikan di bawah **MIT License**. Lihat file [LICENSE](LICENSE) untuk detail lengkap.

## 👨‍💻 Developer

Dikembangkan dengan ❤️ oleh [naaufal](https://github.com/naaufal)

---

⭐ **Jangan lupa berikan star jika proyek ini membantu!**
