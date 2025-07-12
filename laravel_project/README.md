# Cafe Menu App

Aplikasi manajemen menu dan pemesanan untuk cafe, dibangun menggunakan Laravel.

## Fitur

- Manajemen Kategori Menu
- Manajemen Item Menu
- Manajemen Promosi
- Manajemen Meja
- Pemesanan dan Riwayat Pesanan
- Review Pelanggan
- Laporan Harian
- Autentikasi Pengguna (Login, Register, Reset Password)
- Dashboard Admin & Customer

## Demo

Demo aplikasi dapat diakses di:  
[https://cafe-menu-app-demo.example.com](https://cafe-menu-app-demo.example.com)  
*(Ganti link di atas dengan link demo Anda jika tersedia)*

Akun demo:
- **Admin**  
  Email: admin@demo.com  
  Password: password

- **Customer**  
  Email: customer@demo.com  
  Password: password

## API Endpoint

Berikut adalah beberapa endpoint utama yang tersedia pada aplikasi ini:

| Method | Endpoint                  | Deskripsi                        | Auth |
|--------|--------------------------|----------------------------------|------|
| GET    | /api/menu-items          | List semua menu                  | No   |
| GET    | /api/menu-items/{id}     | Detail menu item                 | No   |
| POST   | /api/orders              | Buat pesanan baru                | Yes  |
| GET    | /api/orders              | List pesanan user                | Yes  |
| POST   | /api/reviews             | Kirim review menu                | Yes  |
| GET    | /api/promotions          | List promosi aktif               | No   |
| POST   | /api/login               | Login user                       | No   |
| POST   | /api/register            | Register user baru               | No   |

**Catatan:**  
- Endpoint di atas hanya contoh, sesuaikan dengan implementasi di `routes/api.php` Anda.
- Endpoint yang membutuhkan autentikasi (`Auth: Yes`) harus mengirimkan token Bearer pada header.

## Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/username/Cafe_Menu_App.git
   cd Cafe_Menu_App/laravel_project
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Copy file environment**
   ```bash
   cp .env.example .env
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Atur konfigurasi database**  
   Edit file `.env` dan sesuaikan pengaturan database Anda.

6. **Jalankan migrasi dan seeder**
   ```bash
   php artisan migrate --seed
   ```

7. **Build assets frontend**
   ```bash
   npm run build
   ```

8. **Jalankan server**
   ```bash
   php artisan serve
   ```

## Struktur Folder

- `app/Http/Controllers` — Controller aplikasi
- `app/Models` — Model Eloquent
- `resources/views` — Blade templates
- `routes/web.php` — Routing web
- `database/migrations` — Migrasi database

## Kontribusi

Pull request sangat diterima! Untuk perubahan besar, silakan buka issue terlebih dahulu untuk mendiskusikan apa yang ingin Anda ubah.

## Lisensi

[MIT](LICENSE)