==============================================
PANDUAN MENJALANKAN APLIKASI CUAN MANIA CLONE
==============================================

PROGRAM INI DIBUAT DENGAN:
- Bahasa: Native PHP (Tanpa Framework)
- Tampilan: CSS Modern (Glassmorphism + Dark Mode)
- Database: Tidak menggunakan database (Stateless)

------------------------------------------------------------------
CARA 1: MENJALANKAN DI LOCALHOST (WINDOWS) - PALING MUDAH
------------------------------------------------------------------
Jika Anda sudah menginstall PHP di komputer Anda (lewat XAMPP atau install manual):

1. Buka folder project ini.
2. Klik kanan di area kosong, pilih "Open Terminal here" atau "Git Bash Here".
3. Ketik perintah berikut lalu Enter:
   
   php -S localhost:8000

4. Buka browser (Chrome/Edge) dan akses: http://localhost:8000
5. Selesai.

------------------------------------------------------------------
CARA 2: MENGGUNAKAN XAMPP / LARAGON
------------------------------------------------------------------
1. Copy folder "herryfiersh" ini ke dalam folder "htdocs" di instalan XAMPP (biasanya C:\xampp\htdocs\).
2. Nyalakan module Apache di XAMPP Control Panel.
3. Buka browser dan akses: http://localhost/herryfiersh/

------------------------------------------------------------------
PANDUAN HOSTING GRATIS DI RAILWAY.APP
------------------------------------------------------------------
Railway adalah layanan hosting modern yang mudah digunakan. Karena aplikasi ini stateless (tidak pakai database), hostingnya sangat mudah.

LANGKAH PERSIAPAN:
1. Pastikan Anda punya akun GitHub (https://github.com).
2. Upload/Push folder project ini ke repository GitHub baru Anda.
   (Jika belum paham Git, Anda bisa download "GitHub Desktop" untuk upload folder ini).

LANGKAH DEPLOY DI RAILWAY:
1. Buka https://railway.app/ dan Login (pilih Login with GitHub).
2. Klik tombol "+ New Project".
3. Pilih "Deploy from GitHub repo".
4. Pilih repository yang baru saja Anda upload.
5. Klik "Deploy Now".

6. Railway akan otomatis mendeteksi bahwa ini adalah aplikasi PHP.
   Tunggu proses "Building" dan "Deploying" sampai statusnya hijau (Active).

7. SETTING DOMAIN (Agar bisa diakses publik):
   - Klik kartu project Anda di dashboard Railway.
   - Pergi ke tab "Settings".
   - Scroll ke bagian "Networking" atau "Public Networking".
   - Klik "Generate Domain".
   - Railway akan memberikan link (contoh: project-kamu.up.railway.app).
   - Klik link tersebut, dan website Anda sudah online!

------------------------------------------------------------------
CATATAN TAMBAHAN UNTUK RAILWAY
------------------------------------------------------------------
Jika Railway tidak otomatis mengenali file index.php sebagai entry point (jarang terjadi), buat file baru bernama "Procfile" (tanpa ekstensi) di folder utama project, lalu isi dengan teks berikut:

web: php -S 0.0.0.0:$PORT

Lalu upload ulang ke GitHub.
