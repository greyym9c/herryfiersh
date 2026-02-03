<!DOCTYPE html>
<html>
<head>
    <title>Test Webhook Manual</title>
</head>
<body>
    <h2>Test Webhook Manual</h2>
    <p>Klik tombol di bawah untuk mengirim data POST palsu ke <b>webhook_mpwa.php</b>.</p>
    
    <form action="webhook_mpwa.php" method="POST">
        <!-- Simulasi data dari MPWA (fallback $_POST) -->
        <input type="hidden" name="remote_jid" value="120363405072231013@g.us">
        <input type="hidden" name="text" value="/add TestManual | 11:11 | Cek dari UI">
        <input type="hidden" name="simulate" value="true">
        
        <button type="submit" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">
            Kirim Test Manual (POST)
        </button>
    </form>
    
    <hr>
    
    <h3>Cara Cek:</h3>
    <ol>
        <li>Klik tombol diatas.</li>
        <li>Jika sukses, halaman akan menampilkan respon JSON dari webhook.</li>
        <li>Cek log lagi: <b>webhook_log.txt</b>, seharusnya muncul "Method: POST".</li>
        <li>Cek grup WA, apakah bot merespon?</li>
    </ol>
</body>
</html>
