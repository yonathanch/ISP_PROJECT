

##  Cara Menjalankan Project

### 1. Clone Repository

Clone project dari GitHub ke komputer lokal:

```bash
git clone [URL_GITHUB]
```

### 2. Install Dependencies PHP

```bash
composer install
```

### 3. Setup File Environment

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Konfigurasi Database

Sesuaikan konfigurasi database di file `.env`, lalu jalankan migration:

```bash
php artisan migrate dan php artisan db:seed
```

### 6. Install Dependencies Frontend

Install dependency JavaScript menggunakan npm:

```bash
npm install
```

### 7. Jalankan Server Laravel

Start server Laravel:

```bash
php artisan serve
```

### 8. Jalankan Vite Development Server

Jalankan Vite untuk development frontend:

```bash
npm run dev
```
