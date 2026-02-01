ALUR KERJA BOT NOTIFIKASI OTOMATIS (HERRYFIERSH)
=================================================

Sistem ini dirancang untuk berjalan otomatis di latar belakang (background) selama halaman web dibuka di komputer/laptop.

1. PENGECEKAN WAKTU (Interval 45 Detik)
   - Sistem browser memantau jam komputer Anda setiap 45 detik.
   - Sistem mencocokkan "Jam Sekarang" dengan "Jam Jadwal Garapan".
   - Rumus: Jam Jadwal - 10 Menit.

2. TRIGGER (Jika Waktu Cocok)
   Misal jadwal jam 10:00, maka pukul 09:50 trigger aktif:
   A. Cek apakah Bot Telegram sudah diaktifkan di menu "Set Bot".
   B. Cek apakah notifikasi untuk ID garapan tersebut sudah dikirim hari ini (agar tidak spam).

3. AKSI LOKAL (Di Komputer Anda)
   - Browser memutar suara notifikasi ("Ting!").
   - Muncul Popup Notifikasi di pojok layar (Windows/Browser Notification).
   - Tujuannya: Memberi tahu Anda jika Anda sedang duduk di depan layar.

4. AKSI REMOTE (Ke HP Anda)
   - Browser mengirim sinyal rahasia (API Request) ke Server Telegram.
   - Server Telegram meneruskan pesan teks ke Chat Telegram di HP Anda.
   - Isi pesan: Nama Garapan, Cashback, dan Keterangan.

3. SYARAT AGAR JALAN:
   - Tab browser HerryFiersh harus terbuka (boleh di-minimize).
   - Koneksi internet harus aktif.
   - Token & Chat ID harus benar.
   - BISA BANYAK PENERIMA: Masukkan beberapa Chat ID dipisahkan koma (contoh: 12345, 67890).

PENTING (HOSTING VS LOCAL):
Meskipun website sudah di-hosting (online), sistem bot ini tetap berbasis "Browser Client". 
Artinya:
- Browser (Chrome/Edge/Firefox) di PC/HP Anda HARUS TETAP TERBUKA membuka halaman ini agar bot jalan.
- Hosting hanya berfungsi agar Anda bisa mengakses halaman ini dari mana saja.
- Hosting TIDAK menjalankan bot secara "Server Side" (Cron Job) melainkan "Client Side".

Jika tab ditutup = Bot MATI.

---
Technical Flow:
Browser (JS Loop) -> Match Time -> Local Sound/Alert -> Fetch(Telegram API) -> User Mobile Device
