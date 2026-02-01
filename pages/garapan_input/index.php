<div class="container animate-fade-in py-3">
    <!-- Header -->
    <div class="glass-panel p-3 mb-4 d-flex justify-content-between align-items-center bg-gradient-primary">
        <h2 class="h4 fw-bold text-white mb-0 text-uppercase"><i class="fa-solid fa-plus-circle me-2"></i>Input Jadwal Garapan</h2>
        <div class="text-white fw-bold d-flex align-items-center gap-2">
            <span id="realtimeClock" class="text-white fw-bold" style="font-size: 20pt; line-height: 1;">Loading...</span>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="glass-panel p-4" style="background-color: #13192f; border: 1px solid #1e293b;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="h5 mb-0 text-white">
                        <i class="fa-solid fa-file-pen me-2 text-primary"></i>
                        <span id="formTitle">Form Entry Data</span>
                    </h3>
                    <a href="?page=garapan" class="btn btn-sm btn-outline-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                
                <form id="garapanForm">
                    <input type="hidden" id="garapanId" name="id" value="<?php echo $_GET['edit_id'] ?? ''; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label small text-secondary fw-bold">NAMA GARAPAN</label>
                        <input type="text" class="form-control bg-dark text-white border-secondary py-2" id="nama_garapan" required placeholder="Contoh: Projek Website">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small text-secondary fw-bold">JAM</label>
                            <input type="time" class="form-control bg-dark text-white border-secondary py-2" id="jam" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small text-secondary fw-bold">PERIODE</label>
                            <select class="form-select bg-dark text-white border-secondary py-2" id="periode" required>
                                <option value="Harian">Harian</option>
                                <option value="Mingguan">Mingguan</option>
                                <option value="Bulanan">Bulanan</option>
                                <option value="Sekali Jalan">Sekali Jalan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small text-secondary fw-bold">TANGGAL MULAI</label>
                            <input type="date" class="form-control bg-dark text-white border-secondary py-2" id="tgl_mulai">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small text-secondary fw-bold">TANGGAL SELESAI</label>
                            <input type="date" class="form-control bg-dark text-white border-secondary py-2" id="tgl_selesai">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small text-secondary fw-bold">CASHBACK / DISKON</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-secondary border-secondary">Rp</span>
                            <input type="text" class="form-control bg-dark text-white border-secondary py-2" id="cashback" placeholder="Contoh: 50.000">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label small text-secondary fw-bold">KETERANGAN / DETAIL</label>
                        <textarea class="form-control bg-dark text-white border-secondary" id="keterangan" rows="5" placeholder="Masukkan detail atau catatan mengenai garapan ini..."></textarea>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary-gradient py-3 fw-bold">
                            <i class="fa-solid fa-save me-2"></i> SIMPAN JADWAL SEKARANG
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('garapanForm');
    const garapanId = document.getElementById('garapanId').value;
    const apiPath = '<?php echo $base_url; ?>api/garapan_api.php';

    // --- Realtime Clock ---
    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const smallClock = document.getElementById('realtimeClock');
        if(smallClock) smallClock.innerHTML = `${h}:${m} WIB`;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // If edit mode
    if (garapanId) {
        fetch(apiPath)
            .then(res => {
                if (!res.ok) throw new Error('Gagal mengambil data untuk di-edit');
                return res.json();
            })
            .then(data => {
                const item = data.find(i => i.id == garapanId);
                if (item) {
                    document.getElementById('nama_garapan').value = item.nama_garapan;
                    document.getElementById('jam').value = item.jam;
                    document.getElementById('periode').value = item.periode;
                    document.getElementById('tgl_mulai').value = item.tgl_mulai || '';
                    document.getElementById('tgl_selesai').value = item.tgl_selesai || '';
                    document.getElementById('cashback').value = item.cashback || '';
                    document.getElementById('keterangan').value = item.keterangan;
                    document.getElementById('formTitle').textContent = 'Edit Data Garapan';
                }
            })
            .catch(err => console.error("Error loading edit data:", err));
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const payload = {
            id: document.getElementById('garapanId').value,
            nama_garapan: document.getElementById('nama_garapan').value,
            jam: document.getElementById('jam').value,
            periode: document.getElementById('periode').value,
            tgl_mulai: document.getElementById('tgl_mulai').value,
            tgl_selesai: document.getElementById('tgl_selesai').value,
            cashback: document.getElementById('cashback').value,
            keterangan: document.getElementById('keterangan').value,
            status: 'active' // Default status
        };

        fetch(apiPath, {
            method: 'POST',
            body: JSON.stringify(payload)
        })
        .then(res => {
            if (!res.ok) throw new Error('Gagal menyimpan data ke server');
            return res.json();
        })
        .then(res => {
            if (res.success) {
                window.location.href = '?page=garapan';
            } else {
                alert('Gagal menyimpan: ' + (res.error || 'Terjadi kesalahan tidak diketahui'));
            }
        })
        .catch(err => {
            console.error("Error saving garapan:", err);
            alert('Kesalahan jaringan atau server. Pastikan folder API memiliki izin tulis.');
        });
    });
});
</script>

<style>
.form-control:focus, .form-select:focus {
    background-color: #1e293b !important;
    border-color: #a855f7 !important;
    color: white !important;
    box-shadow: 0 0 0 0.25rem rgba(168, 85, 247, 0.25);
}

.bg-primary-gradient {
    background: var(--accent-gradient);
}
</style>
