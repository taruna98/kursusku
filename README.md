# Dokumentasi Aplikasi Kursus Online

Platform kursus online berbasis Laravel 12 yang menghubungkan Siswa, Mentor, dan Admin dalam satu ekosistem pembelajaran. Mendukung kursus gratis maupun berbayar (via Midtrans Sandbox), dengan materi video YouTube + PDF, kuis pilihan ganda auto-grade, dan sistem review.

---

## 🚀 Fitur Utama

### 🔐 Autentikasi
* **Pendaftaran:** Register sebagai siswa atau mentor (tanpa verifikasi email).
* **Akses Masuk:** Login / logout.
* **Hak Akses:** Redirect otomatis sesuai role setelah login.

### 👨‍🎓 Fitur Siswa
* **Eksplorasi:** Browse & search kursus dengan filter kategori dan status gratis/berbayar.
* **Detail Kursus:** Deskripsi, list materi, dan review.
* **Pendaftaran Kursus:**
  * **Kursus Gratis:** Langsung terdaftar (instant enrollment).
  * **Kursus Berbayar:** Beli kursus via Midtrans Snap.
* **Pembelajaran:** Akses materi berupa video YouTube embed + download PDF.
* **Evaluasi:** Kerjakan kuis pilihan ganda dengan *auto-grade* dan langsung lihat score.
* **Ulasan:** Tulis review & rating (1-5) untuk kursus yang sudah di-enroll.
* **Dashboard:** Daftar kursus saya + riwayat transaksi.
* **Navigasi:** Fitur *prev/next* antar materi belajar.

### 👨‍🏫 Fitur Mentor
* **Verifikasi:** Wajib diverifikasi admin sebelum bisa membuat kursus.
* **Manajemen Kursus:** CRUD kursus (judul, deskripsi, harga, thumbnail, status draft/published).
* **Manajemen Materi:** CRUD materi per kursus (YouTube URL + upload PDF + atur urutan).
* **Manajemen Kuis:** CRUD kuis & soal pilihan ganda (4 opsi + kunci jawaban) per kursus.
* **Monitoring:** Lihat daftar peserta per kursus dan lihat review dari siswa.
* **Dashboard:** Memantau statistik perkembangan kursus dan jumlah peserta.

### ⚡ Fitur Admin
* **Dashboard:** Statistik jumlah user, kursus, transaksi, dan enrollment.
* **Manajemen User:** List, search, filter role, ubah role, dan hapus user.
* **Verifikasi Mentor:** Approve / reject pendaftar akun mentor.
* **Kategori:** CRUD kategori kursus.
* **Keuangan:** Monitoring transaksi masuk di seluruh platform.

---

## 🛠️ Tech Stack

| Komponen | Teknologi |
| :--- | :--- |
| **Framework** | Laravel 12.x |
| **PHP** | ^8.2 |
| **Database** | MySQL (default project) |
| **Frontend** | Blade + Tailwind CSS 3.x + Alpine.js |
| **Build Tool** | Vite 7 |
| **Authentication** | Laravel Breeze |
| **Authorization** | Spatie Laravel Permission |
| **Payment Gateway** | Midtrans Snap (Sandbox) |
| **Testing** | PHPUnit 11 |

---

## 📦 Instalasi

### Prasyarat
Pastikan perangkat Anda sudah terpasang komponen berikut:
* PHP >= 8.2
* Composer
* Node.js & NPM
* MySQL (atau MariaDB)
* Akun Midtrans Sandbox *(untuk simulasi payment gateway)*

### Langkah Instalasi

1. **Clone repository & masuk folder:**
   ```bash
   git clone <repository-url>
   cd kursusku
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database di `.env`:**
   Sesuaikan konfigurasi database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kursusku
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *Setelah itu, buat database baru dengan nama `kursusku` di MySQL Anda.*

5. **Konfigurasi Midtrans Sandbox di `.env`:**
   ```env
   MIDTRANS_SERVER_KEY=your-sandbox-server-key
   MIDTRANS_CLIENT_KEY=your-sandbox-client-key
   MIDTRANS_IS_PRODUCTION=false
   ```

6. **Migrasi dan seeding:**
   ```bash
   php artisan migrate --seed
   ```

7. **Build frontend & jalankan server:**
   ```bash
   npm run build
   php artisan serve
   ```
   Aplikasi dapat diakses melalui link: **[http://localhost:8000](http://localhost:8000)**

---

## 💻 Development

### Menjalankan Semua Service Sekaligus (Hot Reload)
Perintah ini akan menjalankan web server, queue worker, log viewer (pail), dan Vite dev server secara bersamaan:
```bash
composer run dev
```

### Pengujian (Testing)
```bash
php artisan test
# atau
vendor/bin/phpunit
```

### Code Style Check
```bash
vendor/bin/pint
```

### Artisan Commands Berguna
* `php artisan migrate:fresh --seed` : Reset database dan isi seed ulang
* `php artisan route:list` : Melihat seluruh daftar route aplikasi
* `php artisan storage:link` : Membuat symlink storage (untuk upload PDF/thumbnail)
* `php artisan tinker` : Masuk ke mode interactive shell Laravel

---

## 📁 Struktur Project

```text
kursusku/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/             # Dashboard, User, Category, MentorVerification, Transaction
│   │   │   ├── Mentor/            # Dashboard, Course, Lesson, Quiz, Question
│   │   │   ├── Siswa/             # Dashboard, Learning, Quiz, Review
│   │   │   ├── Auth/              # Breeze auth controllers
│   │   │   ├── CourseController.php       # Publik: browse & detail
│   │   │   ├── EnrollmentController.php   # Enroll gratis
│   │   │   ├── TransactionController.php  # Midtrans integration
│   │   │   └── HomeController.php         # Landing page
│   │   └── Middleware/
│   │       ├── RoleMiddleware.php
│   │       └── VerifiedMentorMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Course.php
│       ├── Category.php
│       ├── Lesson.php
│       ├── Quiz.php
│       ├── Question.php
│       ├── QuizAttempt.php
│       ├── Enrollment.php
│       ├── Transaction.php
│       └── Review.php
├── database/
│   ├── migrations/                # 10 domain tables + 5 Spatie tables
│   ├── seeders/                   # CourseSeeder, PermissionSeeder, DatabaseSeeder
│   └── factories/
├── resources/
│   └── views/                     # Blade templates
├── routes/
│   ├── web.php                    # Route utama (public + per role)
│   ├── auth.php                   # Breeze auth routes
│   └── console.php
├── tests/
│   ├── Feature/                   # Auth, Profile, Registration, dll
│   └── Unit/
├── config/
│   ├── midtrans.php
│   └── permission.php
├── docs/
│   ├── prd.md                     # Product Requirements Document
│   ├── erd.dbml                   # Entity Relationship Diagram
│   └── design.md                  # Design system Upskill
└── public/
    └── css/welcome.css            # CSS landing page
```

---

## 🗄️ Database Schema

Aplikasi ini menggunakan **10 tabel domain utama** ditambah **5 tabel bawaan** dari package Spatie Laravel Permission.

### Domain Tables

| Tabel | Deskripsi |
| :--- | :--- |
| `users` | Menyimpan data user dengan field role (admin/mentor/siswa), is_verified, avatar, dan bio. |
| `categories` | Menyimpan data kategori kursus dengan slug unik. |
| `courses` | Data kursus yang berisi relasi mentor, kategori, harga (0 = gratis), thumbnail, dan status draft/published. |
| `lessons` | Data materi pembelajaran: youtube_url, pdf_path (opsional), dan order (urutan). |
| `enrollments` | Menyimpan relasi siswa-kursus (diatur unique: 1 siswa hanya bisa 1 enroll per kursus). |
| `transactions` | Catatan pembayaran Midtrans: menyimpan midtrans_order_id dan status pending/paid/failed/expired. |
| `quizzes` | Menyimpan data kuis yang tersedia per kursus. |
| `questions` | Soal pilihan ganda: pilihan opsi a/b/c/d + correct_answer. |
| `quiz_attempts` | Mencatat hasil pengerjaan kuis: score, total_questions, dan waktu completed_at. |
| `reviews` | Menyimpan rating 1-5 + komentar siswa (unique: 1 siswa hanya bisa memberikan 1 review per kursus). |

### Spatie Tables
Tabel pengelolaan hak akses: `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`.

---

## 🔐 Role & Hak Akses

| Role | Prefix Route | Middleware | Status Akses |
| :--- | :--- | :--- | :--- |
| **Admin** | `/admin/*` | `auth`, `role:admin` | Langsung aktif setelah login |
| **Mentor** | `/mentor/*` | `auth`, `role:mentor` | Butuh status `verified_mentor` untuk akses dashboard & buat kursus |
| **Siswa** | `/siswa/*` | `auth`, `role:siswa` | Langsung aktif setelah login |

> 📌 **Catatan:** Mentor yang baru melakukan registrasi otomatis berstatus `is_verified = false` dan akan di-redirect ke halaman `mentor.pending` sampai disetujui (*approve*) oleh Admin.

---

## 💳 Payment Flow (Midtrans Sandbox)

```text
Siswa klik "Beli Kursus"
   │
   ▼
Backend membuat transaction (status: pending) + request Snap token ke Midtrans
   │
   ▼
Frontend menampilkan Midtrans Snap popup modal
   │
   ▼
Siswa melakukan pembayaran (menggunakan test credentials / simulator)
   │
   ▼
Midtrans mengirimkan callback notifikasi ke /api/midtrans/callback
   │
   ▼
Backend melakukan update status -> Jika paid (sukses), sistem otomatis membuat data enrollment
   │
   ▼
Siswa secara resmi terdaftar dan bisa mengakses materi kursus
```

* **Kursus Gratis:** Klik "Daftar Gratis" -> langsung bypass ke proses Pembuatan Enrollment, tanpa melalui transaksi.
* **Kursus Berbayar:** Harus melewati alur *flow* integrasi Midtrans di atas.
* **Transaksi Tertunda:** Jika status transaksi masih *pending* atau *expired*, siswa dapat melanjutkan/mengulang pembayaran melalui halaman **Riwayat Transaksi**.

---

## 🎨 Design System

Halaman beranda (*landing page*) menggunakan desain sederhana dengan fokus pada UX dan aksesibilitas. Berikut beberapa elemen desain utama:
* **Font:** Inter (ketebalan 400, 500, 600, 700, 800)

• Warna Utama: Primary: #2563eb (biru), CTA gradient: #1e40af -> #2563eb -> #1d4ed8
• Warna Aksen: Orange #f97316 (badge Beginner), Yellow #fde047 (highlight), Star #f59e0b
• Layout: Max width container: 1200px, dengan padding 24px
• Responsivitas: Breakpoints di 1024px, 900px, 600px (menggunakan pendekatan mobile-first)
• File CSS Aset: public/css/welcome.css

---

## 🎨 Pembagian Halaman Aplikasi

🌐 Halaman Publik (Tanpa Login)

• Landing page (hero section, kursus populer, kategori)
• Daftar kursus (disertai fitur search & filter)
• Detail informasi kursus
• Autentikasi (Halaman Login & Register)

👨‍🎓 Halaman Siswa (Auth required)

• Dashboard siswa
• Halaman belajar utama (pemutar video + sidebar navigasi materi)
• Halaman quiz
• Halaman hasil score kuis
• Halaman riwayat transaksi pembayaran

👨‍🏫 Halaman Mentor (Auth + Verified required)

• Halaman tunggu/pending (jika akun baru didaftarkan dan belum diverifikasi admin)
• Dashboard mentor
• Halaman CRUD pembuatan kursus
• Halaman kelola materi pembelajaran & kuis

⚡ Halaman Admin (Auth required)

• Dashboard utama admin
• Kelola user, verifikasi akun mentor, dan CRUD kategori
• Monitoring rekapan data transaksi

---

## 🎨 Akun untuk Pengujian (Uji Coba)

| Email | Password | Role |
| :--- | :--- | :--- |
| siswa@kursusku.test | password | Siswa |
| siswa2@kursusku.test | password | Siswa |
| siswa3@kursusku.test | password | Siswa |
| mentor@kursusku.test | password | Mentor |
| mentor3@kursusku.test | password | Mentor |
| admin@kursusku.test | password | Admin |

---

## Terimakasih ##