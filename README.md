 # UKK Vanilla

Aplikasi sederhana untuk belajar CRUD (unggah dan daftar lagu) menggunakan PHP murni, SQLite, Bootstrap, dan jQuery — tanpa framework.

## Isi Proyek
- `api/` - Endpoint PHP (mis. `upload.php`, `list.php`, `connection.php`) dan folder `music_files/` untuk file unggahan
- `database/` - File database SQLite
- `public/` - File frontend yang dilayani oleh server PHP (HTML, JS)

## Kebutuhan
- PHP 8+ dengan ekstensi PDO SQLite
- sqlite3 (opsional, untuk mengecek DB secara lokal)
- Browser modern

## Mulai Cepat (development)
1. Dari folder proyek jalankan built-in PHP server dengan `public/` sebagai document root:

```bash
php -S localhost:8000 -t public
```

2. Buka `http://localhost:8000` di browser.

## API (Contoh)
- `api/upload.php` — POST untuk mengunggah file. Form field file yang dipakai oleh aplikasi: `music_file` (enctype `multipart/form-data`).
- `api/list.php` — GET untuk mengambil/men-search daftar lagu (query params: `search`, `page`, `limit`).

Contoh (ambil daftar):

```
http://localhost:8000/api/list.php?search=rock&page=1&limit=10
```

Contoh (unggah melalui FormData di JS):

```js
const fd = new FormData();
fd.append('music_file', fileInput.files[0]);
fd.append('title', 'Judul Lagu');
// POST ke /api/upload.php
```

## Catatan
- File yang diunggah disimpan di `api/music_files/`.
- Database SQLite berada di `database/` — anggap ini file pengembangan lokal. Jika Anda mem-push repo beserta DB/unggahan, file tersebut akan masuk ke history git.
- Validasi tipe file juga dilakukan di server (`upload.php`). `accept` pada input file hanya untuk pengalaman pengguna dan bisa dilewati.

## Langkah Berikutnya
- Rapikan upload.html, list lagu masih belum rapi
- Tambah metadata pagination (total, total_pages) pada hasil `list.php`.
- Tambah otentikasi sederhana atau proteksi untuk endpoint upload.

---
Silakan edit README ini sesuai cara Anda ingin menampilkan proyek di GitHub.
