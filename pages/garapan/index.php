<div class="container animate-fade-in py-3">
    <!-- Header -->
    <div class="glass-panel p-3 mb-4 d-flex justify-content-between align-items-center bg-gradient-primary">
        <h2 class="h4 fw-bold text-white mb-0 text-uppercase"><i class="fa-solid fa-list-check me-2"></i>Daftar Jadwal Garapan</h2>
        <div class="text-white fw-bold d-flex align-items-center gap-2">
            <span id="realtimeClock" class="text-white fw-bold" style="font-size: 20pt; line-height: 1;">Loading...</span>
        </div>
    </div>

    <!-- Aesthetic Big Clock -->
    <div class="glass-panel text-center mb-4 py-4 position-relative overflow-hidden animate-fade-in" style="border: 1px solid rgba(255,255,255,0.08);">
        <div class="position-relative" style="z-index: 2;">
            <div class="text-secondary small text-uppercase mb-2 fw-bold" style="letter-spacing: 4px; font-size: 0.7rem;">Jakarta, Indonesia (WIB)</div>
            <div id="bigRealtimeClock" class="fw-bold lh-1 time-is-font" style="font-size: 4.5rem; letter-spacing: -2px;">Loading...</div>
            <div id="currentDate" class="text-secondary mt-2 fw-medium" style="font-size: 1.1rem;">-</div>
        </div>
        <div class="position-absolute top-50 start-50 translate-middle" style="width: 200px; height: 200px; background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%); z-index: 1; filter: blur(40px);"></div>
    </div>

    <!-- Active List -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="h5 mb-0 text-white"><i class="fa-solid fa-fire me-2 text-warning"></i>Jadwal Aktif: <span id="totalGarapan" class="text-primary-gradient">0</span></h3>
        <a href="?page=garapan_input" class="btn btn-primary-gradient shadow-sm">
            <i class="fa-solid fa-plus-circle me-2"></i> Tambah Garapan Baru
        </a>
    </div>

    <div class="glass-panel p-0 mb-5 overflow-hidden shadow-sm" style="background-color: #13192f; border-radius: 8px; border: 1px solid #1e293b;">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle mobile-card-table" style="font-family: 'Inter', sans-serif; background-color: #13192f; --bs-table-bg: #13192f;">
                <thead>
                    <tr class="text-secondary fw-bold small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px; background-color: #0f1525;">
                        <th class="py-3 ps-4" style="background-color: #0f1525;">DETAIL GARAPAN AKTIF</th>
                        <th class="py-3 text-end pe-4" style="width: 180px; background-color: #0f1525;">AKSI</th>
                    </tr>
                </thead>
                <tbody id="garapanTableBody">
                    <tr><td colspan="2" class="text-center py-5 text-muted"><i class="fa-solid fa-spinner fa-spin me-2"></i> Memuat Data...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- History List -->
    <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
        <h3 class="h5 mb-0 text-white opacity-75"><i class="fa-solid fa-clock-rotate-left me-2 text-secondary"></i>History Selesai</h3>
        <span class="badge bg-secondary opacity-75" id="totalHistory">0 Item</span>
    </div>

    <div class="glass-panel p-0 mb-4 overflow-hidden shadow-sm" style="background-color: #0f1525; border-radius: 8px; border: 1px solid #1e293b; opacity: 0.8;">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle mobile-card-table" style="font-family: 'Inter', sans-serif; background-color: #0f1525; --bs-table-bg: #0f1525;">
                <tbody id="historyTableBody">
                    <!-- Finished items will be injected here -->
                </tbody>
            </table>
        </div>
        <div id="emptyHistory" class="p-4 text-center d-none">
            <small class="text-secondary">Belum ada riwayat garapan selesai.</small>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.getElementById('garapanTableBody');
    const historyBody = document.getElementById('historyTableBody');
    const totalBadge = document.getElementById('totalGarapan');
    const historyBadge = document.getElementById('totalHistory');
    const emptyHistory = document.getElementById('emptyHistory');
    const apiPath = '<?php echo $base_url; ?>api/garapan_api.php';

    function updateClock() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        const timeStr = `${h}:${m}<span style="font-size:0.5em; color: #fff; vertical-align: top; margin-left:5px;">${s}</span>`;
        const dateStr = now.toLocaleDateString('id-ID', options);
        document.getElementById('realtimeClock').innerHTML = `${h}:${m} WIB`;
        document.getElementById('bigRealtimeClock').innerHTML = timeStr;
        document.getElementById('currentDate').innerText = dateStr;
    }
    setInterval(updateClock, 1000);
    updateClock();

    function loadData() {
        console.log("Fetching from:", apiPath);
        fetch(apiPath)
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {
                console.log("Data received:", data);
                data.sort((a, b) => (a.jam || '').localeCompare(b.jam || ''));
                
                const today = new Date().toISOString().split('T')[0];
                
                // Active: Not manually finished AND (No tgl_selesai OR tgl_selesai hasn't passed)
                const active = data.filter(i => 
                    i.status !== 'finished' && 
                    (!i.tgl_selesai || i.tgl_selesai >= today)
                );
                
                // Finished: Manually finished OR deadline passed
                const finished = data.filter(i => 
                    i.status === 'finished' || 
                    (i.tgl_selesai && i.tgl_selesai < today)
                );
                
                renderActive(active);
                renderHistory(finished);
                
                totalBadge.textContent = active.length;
                historyBadge.textContent = `${finished.length} Item`;
            })
            .catch(err => {
                console.error("Error loading garapan data:", err);
                tableBody.innerHTML = '<tr><td colspan="2" class="text-center py-5 text-danger">Gagal memuat data. Periksa koneksi atau file JSON.</td></tr>';
            });
    }

    function formatDate(dateStr) {
        if (!dateStr) return '-';
        const [year, month, day] = dateStr.split('-');
        return `${day}/${month}/${year}`;
    }

    function renderActive(data) {
        if (data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="2" class="text-center py-5 text-muted">Belum ada jadwal aktif.</td></tr>';
            return;
        }
        tableBody.innerHTML = data.map(item => `
            <tr class="border-bottom border-light-10">
                <td class="ps-4 py-3" colspan="2">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                <span class="fw-bold fs-5 text-white">${item.nama_garapan}</span>
                                <span class="badge bg-primary-gradient px-2 py-1 small" style="font-size: 0.7rem;">${item.periode}</span>
                                <span class="text-info small fw-bold"><i class="fa-regular fa-clock me-1"></i>${item.jam}</span>
                            </div>
                            <div class="mb-1">
                                <span class="text-secondary small"><i class="fa-solid fa-calendar-day me-1"></i>${formatDate(item.tgl_mulai)} s/d ${formatDate(item.tgl_selesai)}</span>
                            </div>
                            <div class="text-secondary small opacity-75" style="line-height: 1.4;">${item.keterangan || 'Tidak ada keterangan'}</div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn-action btn-finish" onclick="finishItem('${item.id}')" title="Selesai">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <a href="?page=garapan_input&edit_id=${item.id}" class="btn-action btn-edit" title="Edit">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <button class="btn-action btn-delete" onclick="deleteItem('${item.id}')" title="Hapus">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    function renderHistory(data) {
        if (data.length === 0) {
            historyBody.innerHTML = '';
            emptyHistory.classList.remove('d-none');
            return;
        }
        emptyHistory.classList.add('d-none');
        historyBody.innerHTML = data.map(item => `
            <tr class="border-bottom border-light-10 opacity-75">
                <td class="ps-4 py-2" colspan="2">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-solid fa-circle-check text-success"></i>
                            <div>
                                <div class="fw-bold text-white-50 small">${item.nama_garapan}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">Selesai pada: ${formatDate(item.tgl_selesai)}</div>
                            </div>
                        </div>
                        <button class="btn-action btn-delete" style="width: 32px; height: 32px;" onclick="deleteItem('${item.id}')" title="Hapus Riwayat">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    window.finishItem = function(id) {
        fetch(apiPath)
            .then(res => res.json())
            .then(data => {
                const item = data.find(i => i.id == id);
                if (item) {
                    item.status = 'finished';
                    fetch(apiPath, {
                        method: 'POST',
                        body: JSON.stringify(item)
                    })
                    .then(res => res.json())
                    .then(res => { if (res.success) loadData(); });
                }
            });
    };

    window.deleteItem = function(id) {
        if (confirm('Hapus data ini?')) {
            fetch(`${apiPath}?id=${id}`, { method: 'DELETE' })
                .then(res => res.json())
                .then(res => { if (res.success) loadData(); });
        }
    };

    loadData();
});
</script>

<style>
.border-light-10 { border-color: rgba(255, 255, 255, 0.05) !important; }
.text-primary-gradient { background: var(--accent-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 800; }
.bg-primary-gradient { background: var(--accent-gradient); border: none; }

/* Precise Action Buttons */
.btn-action {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.05);
    color: white;
    transition: all 0.2s ease;
    cursor: pointer;
    text-decoration: none;
    font-size: 0.9rem;
}

.btn-action:hover {
    transform: translateY(-2px);
    border-color: rgba(255,255,255,0.2);
    color: white;
}

.btn-finish:hover { background: #10b981; border-color: #10b981; box-shadow: 0 0 15px rgba(16, 185, 129, 0.4); }
.btn-edit:hover { background: #0ea5e9; border-color: #0ea5e9; box-shadow: 0 0 15px rgba(14, 165, 233, 0.4); }
.btn-delete:hover { background: #ef4444; border-color: #ef4444; box-shadow: 0 0 15px rgba(239, 68, 68, 0.4); }

.btn-delete-sm {
    width: 28px;
    height: 28px;
    background: transparent;
    border: none;
    color: #94a3b8;
    font-size: 0.8rem;
}

.btn-delete-sm:hover {
    color: #ef4444;
    background: rgba(239, 68, 68, 0.1);
}

@media (max-width: 768px) {
    .btn-action {
        width: 34px;
        height: 34px;
        font-size: 0.85rem;
    }
    .table-responsive {
        border: none !important;
        overflow: visible !important;
    }
    .mobile-card-table {
        width: 100% !important;
        display: block;
    }
    #garapanTableBody, #historyTableBody {
        display: block;
        width: 100%;
    }
    #garapanTableBody tr, #historyTableBody tr {
        display: block;
        width: 100% !important;
        background: rgba(255, 255, 255, 0.03);
        margin-bottom: 1rem;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }
    #garapanTableBody td, #historyTableBody td {
        display: block;
        width: 100% !important;
        padding: 1.25rem !important;
        box-sizing: border-box;
    }
}
</style>
