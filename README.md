# AI Sales Page Generator

Mini SaaS untuk membuat landing page produk secara otomatis dan mempublikasikannya ke Netlify.

Aplikasi ini dibuat untuk membantu pemilik produk membuat sales page modern hanya dengan mengisi detail produk, lalu menghasilkan konten marketing AI-driven, memilih template, dan menerbitkannya dengan sekali klik.

## Fitur Utama

- Buat dan kelola produk dengan informasi lengkap
- Generate konten sales page otomatis menggunakan AI
- Pilih template landing page yang siap pakai
- Publikasi otomatis ke Netlify dengan setiap produk mendapatkan satu situs khusus
- Regenerate sales page tanpa membuat situs baru
- Hapus produk dengan cleanup Netlify site otomatis

## Mengapa aplikasi ini keren

- Elegan: UI sederhana namun profesional untuk manajemen produk dan halaman landing
- Cepat: otomatisasi pembuatan konten dan publikasi di Netlify
- Terisolasi: setiap produk punya site Netlify sendiri, sehingga tidak bercampur
- Praktis: cukup klik `Generate`, lalu `Publish`; sistem menangani sisanya

## Teknologi

- Laravel 12
- React + Inertia
- Tailwind CSS
- SQLite untuk environment ringan
- Docker dan Docker Compose untuk deployment
- Netlify API untuk publishing

## Jalankan secara teknis

### 1. Persiapan lokal

1. Clone repositori:
   ```bash
   git clone <repo-url>
   cd ai_sales_page_gen
   ```
2. Salin `.env.example` ke `.env` lalu isi konfigurasi:
   ```bash
   cp .env.example .env
   ```
3. Instal dependensi PHP dan JavaScript:
   ```bash
   composer install
   npm install
   ```
4. Generate app key dan migrasi database:
   ```bash
   php artisan key:generate
   php artisan migrate
   ```
5. Jalankan build frontend:
   ```bash
   npm run build
   ```
6. Jalankan server lokal:
   ```bash
   php artisan serve
   ```

Aplikasi akan tersedia di `http://127.0.0.1:8000`.

### 2. Konfigurasi Netlify

Isi variabel berikut di `.env`:

```env
NETLIFY_TOKEN=token_netlify_anda
NETLIFY_SITE_ID=
```

Aplikasi akan membuat site Netlify baru untuk setiap produk saat pertama kali publish, dan menyimpan `site_id` serta `site_url` per produk.

### 3. Jalankan dengan Docker Compose

Aplikasi juga sudah siap berjalan dengan Docker Compose:

```bash
docker compose up --build -d
```

Setelah container jalan, akses `http://localhost:8000`.

### 4. Deployment otomatis

Repositori sudah dilengkapi workflow GitHub Actions untuk deploy ke VPS lewat SSH saat push ke `main`.
Pastikan secret GitHub berikut sudah terpasang:

- `VPS_HOST`
- `VPS_USER`
- `VPS_SSH_KEY`

Workflow akan melakukan pull kode terbaru dan restart Docker Compose di VPS.

## Struktur Singkat

- `app/` - backend Laravel
- `resources/views/` - Blade views dan template landing page
- `resources/js/` - frontend React/Inertia
- `Dockerfile` - container image build
- `docker-compose.yml` - deployment stack
- `.github/workflows/deploy.yml` - GitHub Actions deploy

## Catatan

- Aplikasi ini cocok untuk prototype mini SaaS landing page generator.
- Semua produk dapat memiliki landing page yang terpublish secara otomatis dengan route sederhana.
- Jika ingin memperluas, tambahkan autentikasi user lebih lengkap, metode publish lain, atau fitur custom domain.
