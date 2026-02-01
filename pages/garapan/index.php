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
        <div class="d-flex gap-2">
            <button id="trigger-bot-modal" class="btn btn-outline-success border-0 glass-panel py-2 px-3 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#waBotModal">
                <i class="fa-brands fa-whatsapp fs-5 text-success"></i>
                <span class="small fw-bold d-none d-md-inline text-success">Set Bot</span>
            </button>
            <a href="?page=garapan_input" class="btn btn-primary-gradient shadow-sm">
                <i class="fa-solid fa-plus-circle me-2"></i> Tambah Garapan Baru
            </a>
        </div>
    </div>

    <div class="glass-panel p-0 mb-5 overflow-hidden shadow-sm" style="background-color: #13192f; border-radius: 8px; border: 1px solid #1e293b;">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle" style="font-family: 'Inter', sans-serif; background-color: #13192f; --bs-table-bg: #13192f;">
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
            <table class="table table-dark table-hover mb-0 align-middle" style="font-family: 'Inter', sans-serif; background-color: #0f1525; --bs-table-bg: #0f1525;">
                <tbody id="historyTableBody">
                    <!-- Finished items will be injected here -->
                </tbody>
            </table>
        </div>
        <div id="emptyHistory" class="p-4 text-center d-none">
            <small class="text-secondary">Belum ada riwayat garapan selesai.</small>
        </div>
    </div>
    <audio id="alertSound" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" preload="auto"></audio>
</div>

<!-- WhatsApp Bot Config Modal -->
<div class="modal fade" id="waBotModal" tabindex="-1" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white shadow-lg">
            <div class="modal-header border-bottom border-light-10 p-4">
                <h5 class="modal-title d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary-soft p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(56, 189, 248, 0.1);">
                        <i class="fa-brands fa-telegram text-info"></i>
                    </div>
                    Setup Bot Telegram
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-info py-2 small mb-3" style="background: rgba(56, 189, 248, 0.05); border-color: rgba(56, 189, 248, 0.2); color: #94a3b8;">
                    <i class="fa-brands fa-telegram me-2"></i><b>Panduan Singkat:</b><br>
                    1. Masukkan <b>Chat ID</b> Anda (Wajib).<br>
                    2. Untuk tahu Chat ID, chat ke bot <code>@userinfobot</code> di Telegram.<br>
                    3. Centang "Aktifkan" dan Simpan.
                </div>
                
                <div class="mb-3">
                    <label class="form-label small text-secondary fw-bold">BOT TOKEN</label>
                    <input type="text" id="teleBotToken" class="form-control bg-dark text-white border-secondary" value="8114128194:AAH5S2k2kTtigRnjA9zD2YbwN3vA8W3_pjU">
                    <div class="form-text opacity-50 small">Token default HerryFiersh Bot (Jangan diubah jika tidak punya bot sendiri).</div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label small text-secondary fw-bold">CHAT ID (BISA BANYAK)</label>
                    <input type="text" id="teleChatId" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: 123456, 987654">
                    <div class="form-text opacity-50 small">Pisahkan dengan koma (,) jika lebih dari satu.</div>
                </div>
                
                <div class="form-check form-switch p-0 ms-4">
                    <input class="form-check-input" type="checkbox" id="teleBotEnabled" style="cursor: pointer;">
                    <label class="form-check-label small fw-bold text-white-50" for="teleBotEnabled">AKTIFKAN BOT OTOMATIS</label>
                </div>
            </div>
            <div class="modal-footer border-top border-light-10 p-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success px-4" id="saveBotConfig">
                    <i class="fa-solid fa-check-circle me-2"></i> Simpan & Aktifkan
                </button>
            </div>
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
    // Use relative paths to avoid HTTP/HTTPS mix-ups
    const apiPath = 'api/garapan_api.php';
    const configPath = 'api/save_bot_config.php';
    const getConfigPath = 'api/get_bot_config.php';
    
    let activeData = [];
    const defaultTeleToken = '8114128194:AAH5S2k2kTtigRnjA9zD2YbwN3vA8W3_pjU';
    
    let botConfig = {
        teleToken: defaultTeleToken,
        teleChatId: '',
        teleEnabled: false
    };

    // Load Config from Server with Cache Busting
    function loadBotConfig() {
        // Disable fields while loading
        setModalLoading(true);

        const timestamp = new Date().getTime();
        console.log("Fetching bot config...");
        
        fetch(getConfigPath + '?t=' + timestamp)
            .then(res => res.json())
            .then(data => {
                console.log("Bot Config loaded:", data);
                // Only update if we got valid data
                if (data.teleToken !== undefined) botConfig.teleToken = data.teleToken;
                if (data.teleChatId !== undefined) botConfig.teleChatId = data.teleChatId;
                botConfig.teleEnabled = data.teleEnabled === true || data.teleEnabled === "true";
                
                updateModalUI();
            })
            .catch(err => {
                console.error("Error loading bot config:", err);
                // If error, do NOT overwrite with defaults immediately to be safe
                // But we must re-enable UI
            })
            .finally(() => {
                setModalLoading(false);
            });
    }

    function setModalLoading(isLoading) {
        const tokenInput = document.getElementById('teleBotToken');
        const chatInput = document.getElementById('teleChatId');
        const saveBtn = document.getElementById('saveBotConfig');
        
        if (tokenInput) tokenInput.disabled = isLoading;
        if (chatInput) {
            chatInput.disabled = isLoading;
            chatInput.placeholder = isLoading ? "Sedang memuat data..." : "Contoh: 123456, 987654";
        }
        if (saveBtn) saveBtn.disabled = isLoading;
    }

    function updateModalUI() {
        const tokenInput = document.getElementById('teleBotToken');
        const chatInput = document.getElementById('teleChatId');
        const enabledInput = document.getElementById('teleBotEnabled');

        if (tokenInput && botConfig.teleToken) tokenInput.value = botConfig.teleToken;
        if (chatInput && botConfig.teleChatId) chatInput.value = botConfig.teleChatId;
        if (enabledInput) enabledInput.checked = botConfig.teleEnabled;
    }

    // Load on start
    loadBotConfig();

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
        fetch(apiPath + '?t=' + new Date().getTime())
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {
                console.log("Data received:", data);
                
                // Sort by Jam (Ascending) first, then by Priority (Ascending)
                data.sort((a, b) => {
                    const timeA = a.jam || '23:59:59';
                    const timeB = b.jam || '23:59:59';
                    const timeDiff = timeA.localeCompare(timeB);
                    
                    if (timeDiff !== 0) return timeDiff;
                    
                    // If time is same, sort by Priority
                    const prioA = parseInt(a.prioritas || 3);
                    const prioB = parseInt(b.prioritas || 3);
                    return prioA - prioB;
                });
                
                const today = new Date().toISOString().split('T')[0];
                
                // Active: Not manually finished AND (No tgl_selesai OR tgl_selesai hasn't passed)
                let active = data.filter(i => 
                    i.status !== 'finished' && 
                    (!i.tgl_selesai || i.tgl_selesai >= today)
                );
                
                // Sort Active data by countdown
                active = sortActiveData(active);

                // Auto-finish Sekali Jalan items on load
                active.forEach(item => {
                    if (item.periode === 'Sekali Jalan' && item.diff < 0) {
                        finishItem(item.id);
                    }
                });

                // Finished: Manually finished OR deadline passed
                const finished = data.filter(i => 
                    i.status === 'finished' || 
                    (i.tgl_selesai && i.tgl_selesai < today)
                );
                
                renderActive(active);
                renderHistory(finished);
                
                activeData = active; // Store for reminders and sorting
                totalBadge.textContent = active.length;
                historyBadge.textContent = `${finished.length} Item`;
            })
            .catch(err => {
                console.error("Error loading garapan data:", err);
                tableBody.innerHTML = '<tr><td colspan="2" class="text-center py-5 text-danger">Gagal memuat data. Periksa koneksi atau file JSON.</td></tr>';
            });

    }

    function sortActiveData(data) {
        const now = new Date();
        const currentYear = now.getFullYear();
        const currentMonth = now.getMonth();
        const currentDay = now.getDate();

        return data.map(item => {
            if (!item.jam) return { ...item, diff: Infinity };
            const [h, m] = item.jam.split(':').map(Number);
            const targetDate = new Date(currentYear, currentMonth, currentDay, h, m, 0);
            let diff = targetDate - now;
            
            // Harian Logic: If passed, set for tomorrow
            if (item.periode === 'Harian' && diff < 0) {
                diff += 86400000;
            }

            return { ...item, diff };
        }).sort((a, b) => {
            // Sort by nearest countdown (smallest positive diff first)
            // If diff < 0 (passed Sekali Jalan), it goes to the bottom
            if (a.diff > 0 && b.diff > 0) return a.diff - b.diff;
            if (a.diff <= 0 && b.diff <= 0) return a.diff - b.diff; 
            if (a.diff > 0 && b.diff <= 0) return -1;
            if (a.diff <= 0 && b.diff > 0) return 1;
            return 0;
        });
    }

    // --- Countdown Timer Logic ---
    let lastOrder = '';
    function updateRowTimers() {
        const now = new Date();
        const currentYear = now.getFullYear();
        const currentMonth = now.getMonth();
        const currentDay = now.getDate();

        // Check if we need to re-sort
        const sortedActive = sortActiveData(activeData);
        
        // Check for Sekali Jalan auto-finish
        sortedActive.forEach(item => {
            if (item.periode === 'Sekali Jalan' && item.diff < 0) {
                // Auto finish if passed
                console.log(`Auto finishing Sekali Jalan task: ${item.nama_garapan}`);
                finishItem(item.id);
            }
        });

        const currentOrder = sortedActive.map(i => i.id).join(',');
        
        if (currentOrder !== lastOrder) {
            lastOrder = currentOrder;
            renderActive(activeData = sortedActive);
        }

        // Iterate over all active items rows to find countdown spans
        const spans = document.querySelectorAll('.countdown-timer');
        spans.forEach(span => {
            const timeTarget = span.getAttribute('data-time');
            if (!timeTarget) return;

            const [h, m] = timeTarget.split(':').map(Number);
            const targetDate = new Date(currentYear, currentMonth, currentDay, h, m, 0);
            
            let diff = targetDate - now;

            // Check if this is a Harian task that has passed today
            // We need to know the item's periode
            const rowId = span.closest('tr').querySelector('.btn-finish')?.getAttribute('onclick').match(/'([^']+)'/)[1];
            const item = activeData.find(i => i.id === rowId);

            if (item && item.periode === 'Harian' && diff < 0) {
                diff += 86400000; // Point to tomorrow
            }

            let statusClass = 'text-warning';

            if (diff < 0) {
                // This will only happen for "Sekali Jalan" because Harian diff was added 24h above
                statusClass = 'text-secondary opacity-50';
                const absDiff = Math.abs(diff);
                const hh = Math.floor(absDiff / 1000 / 60 / 60);
                const mm = Math.floor((absDiff / 1000 / 60) % 60);
                const ss = Math.floor((absDiff / 1000) % 60);
                span.innerHTML = `<i class="fa-solid fa-clock-rotate-left me-1"></i> Selesai ${hh}j ${mm}m lalu`;
            } else {
                const hh = Math.floor(diff / 1000 / 60 / 60);
                const mm = Math.floor((diff / 1000 / 60) % 60);
                const ss = Math.floor((diff / 1000) % 60);
                
                // If it's for tomorrow, maybe show a small indicator or just the timer
                const tomorrowPrefix = (item && item.periode === 'Harian' && (targetDate - now) < 0) ? '<small class="me-1">Besok</small>' : '';
                
                span.innerHTML = `<i class="fa-solid fa-stopwatch me-1"></i> ${tomorrowPrefix}-${String(hh).padStart(2, '0')}:${String(mm).padStart(2, '0')}:${String(ss).padStart(2, '0')}`;
            }
            span.className = `countdown-timer badge bg-dark border border-secondary ${statusClass} small user-select-none`;
        });
    }
    // Update timers every second
    setInterval(updateRowTimers, 1000);

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
        tableBody.innerHTML = data.map(item => {
            // Determine Border Color based on Priority
            let borderColor = 'border-light-10'; // Default
            let priorityBadge = '';
            
            const prio = parseInt(item.prioritas || 3);
            if(prio === 1) {
                borderColor = 'border-danger'; 
                priorityBadge = '<span class="badge bg-danger text-white ms-2 animate-pulse">URGENT</span>';
            } else if(prio === 2) {
                borderColor = 'border-warning';
                priorityBadge = '<span class="badge bg-warning text-dark ms-2">PENTING</span>';
            } else if(prio === 3) {
                borderColor = 'border-success';
                // priorityBadge = '<span class="badge bg-success text-white ms-2">NORMAL</span>';
            }

            return `
            <tr class="border-bottom ${borderColor}" style="border-width: 1px;">
                <td class="ps-4 py-3" colspan="2" style="${prio === 1 ? 'background: rgba(239, 68, 68, 0.05);' : ''}">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                <span class="fw-bold fs-5 text-white">${item.nama_garapan}</span>
                                ${priorityBadge}
                                <span class="badge bg-primary-gradient px-2 py-1 small" style="font-size: 0.7rem;">${item.periode}</span>
                                
                                <div class="d-inline-flex align-items-center justify-content-center px-3 py-1 mx-2 rounded-pill" 
                                     style="background: rgba(14, 165, 233, 0.15); border: 1px solid rgba(56, 189, 248, 0.3); box-shadow: 0 0 12px rgba(56, 189, 248, 0.15);">
                                    <i class="fa-regular fa-clock me-2 text-info"></i>
                                    <span class="fw-bold text-white" style="font-size: 1.1rem; letter-spacing: 1px; font-family: 'Inter', monospace;">${item.jam}</span>
                                    <span class="small text-info ms-1" style="font-size: 0.7rem; opacity: 0.8;">WIB</span>
                                </div>

                                <span class="countdown-timer badge bg-dark border border-secondary text-warning small user-select-none" data-time="${item.jam}">Loading...</span>
                            </div>
                            <div class="mb-1 d-flex flex-column gap-1">
                                ${item.cashback ? `<div class=""><span class="badge bg-success text-white px-2 py-1 small pulsate-subtle" style="font-size: 0.7rem; background: linear-gradient(135deg, #10b981, #059669);"><i class="fa-solid fa-hand-holding-dollar me-1"></i>CB: Rp ${item.cashback}</span></div>` : ''}
                                <div class="text-white small"><i class="fa-solid fa-calendar-day me-2 text-primary"></i>${formatDate(item.tgl_mulai)} s/d ${formatDate(item.tgl_selesai)}</div>
                            </div>
                            <div class="text-white small opacity-90" style="line-height: 1.4;">${item.keterangan || 'Tidak ada keterangan'}</div>
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
        `}).join('');
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
                <td class="ps-4 py-3" colspan="2">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-solid fa-circle-check text-success"></i>
                            <div>
                                <div class="fw-bold text-white small">${item.nama_garapan}</div>
                                ${item.cashback ? `<div class="mb-1"><span class="badge bg-success text-white px-2 py-1 small" style="font-size: 0.65rem; background: linear-gradient(135deg, #10b981, #059669);"><i class="fa-solid fa-hand-holding-dollar me-1"></i>CB: Rp ${item.cashback}</span></div>` : ''}
                                <div class="text-white opacity-75" style="font-size: 0.75rem;">Selesai: ${formatDate(item.tgl_selesai)}</div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn-action btn-restore" style="width: 32px; height: 32px;" onclick="restoreItem('${item.id}')" title="Pulihkan ke Jadwal Aktif">
                                <i class="fa-solid fa-rotate-left"></i>
                            </button>
                            <button class="btn-action btn-delete" style="width: 32px; height: 32px;" onclick="deleteItem('${item.id}')" title="Hapus Riwayat">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
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

    window.restoreItem = function(id) {
        fetch(apiPath)
            .then(res => res.json())
            .then(data => {
                const item = data.find(i => i.id == id);
                if (item) {
                    item.status = 'active';
                    const today = new Date().toISOString().split('T')[0];
                    if (item.tgl_selesai && item.tgl_selesai < today) {
                        item.tgl_selesai = null;
                    }
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

    // --- Bot Logic (Telegram Only) ---
    function checkReminders() {
        const now = new Date();
        const currentDay = now.toISOString().split('T')[0];
        const currentTime = now.getHours() * 60 + now.getMinutes();
        
        activeData.forEach(item => {
            if (!item.jam) return;
            
            const [h, m] = item.jam.split(':').map(Number);
            const taskTime = h * 60 + m;
            const diff = taskTime - currentTime;
            
            // Trigger 10 minutes before
            if (diff === 10) {
                // Telegram Logic
                if (botConfig.teleEnabled && botConfig.teleToken && botConfig.teleChatId) {
                    const teleKeyStore = `tele_sent_${item.id}_${currentDay}`;
                    if (!localStorage.getItem(teleKeyStore)) {
                        sendTelegram(item);
                        localStorage.setItem(teleKeyStore, 'true');
                    }
                }
            }
        });
    }

    function sendTelegram(item) {
        // 1. Notification Visual & Sound for local monitoring
        const audio = document.getElementById('alertSound');
        if(audio) audio.play().catch(e => console.log("Sound blocked"));
        
        if ("Notification" in window && Notification.permission === "granted") {
            new Notification("🤖 BOT TELEGRAM AKTIF", {
                body: `Mengirim notifikasi otomatis untuk: ${item.nama_garapan}`,
                icon: "https://upload.wikimedia.org/wikipedia/commons/thumb/8/82/Telegram_logo.svg/512px-Telegram_logo.svg.png"
            });
        }

        // 2. Send to Telegram API (Support Multiple IDs)
        const text = `🔔 *PENGINGAT GARAPAN* (10 Menit Lagi)\n\n📌 *Projek:* ${item.nama_garapan}\n⏰ *Jam:* ${item.jam} WIB\n💰 *Promo:* Rp ${item.cashback || '0'}\n📝 *Ket:* ${item.keterangan || '-'}`;
        
        // Split IDs by comma and trim whitespace
        const chatIds = botConfig.teleChatId.split(',').map(id => id.trim()).filter(id => id);

        chatIds.forEach(chatId => {
            const url = `https://api.telegram.org/bot${botConfig.teleToken}/sendMessage?chat_id=${chatId}&text=${encodeURIComponent(text)}&parse_mode=Markdown`;

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if(data.ok) console.log(`Telegram Sent to ${chatId}`);
                    else console.error(`Telegram Error (${chatId}):`, data);
                })
                .catch(err => console.error(`Tele Fetch Error (${chatId}):`, err));
        });
    }

    // Modal Handling
    const saveBtn = document.getElementById('saveBotConfig');
    const triggerBtn = document.getElementById('trigger-bot-modal');

    if (triggerBtn) {
        triggerBtn.addEventListener('click', () => {
            loadBotConfig();
        });
    }

    saveBtn.addEventListener('click', () => {
        const newConfig = {
            teleToken: document.getElementById('teleBotToken').value.trim(),
            teleChatId: document.getElementById('teleChatId').value.trim(),
            teleEnabled: document.getElementById('teleBotEnabled').checked
        };

        if (newConfig.teleEnabled && (!newConfig.teleToken || !newConfig.teleChatId)) {
            alert('Token & Chat ID Telegram wajib diisi jika diaktifkan!');
            return;
        }
        
        // Save to Server (for Cron Job)
        fetch(configPath, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(newConfig)
        }).then(res => res.json())
          .then(data => console.log('Server Config Saved:', data))
          .catch(err => console.error('Save Error:', err));

        // Save Local (for Browser Alert)
        localStorage.setItem('teleBotToken', newConfig.teleToken);
        localStorage.setItem('teleChatId', newConfig.teleChatId);
        localStorage.setItem('teleBotEnabled', newConfig.teleEnabled);
        
        botConfig = newConfig; // Update global config
        
        const modalEl = document.getElementById('waBotModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modalInstance.hide();
        alert('Bot Telegram Berhasil Disimpan (Local & Server)!');
    });

    setInterval(checkReminders, 45000); // Check every 45s
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
.btn-restore:hover { background: #6366f1; border-color: #6366f1; box-shadow: 0 0 15px rgba(99, 102, 241, 0.4); }

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

@keyframes pulsate-subtle {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.02); opacity: 0.9; }
    100% { transform: scale(1); opacity: 1; }
}
.pulsate-subtle { animation: pulsate-subtle 3s infinite ease-in-out; }

@media (max-width: 768px) {
    .container {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }
    .glass-panel {
        padding: 0.75rem !important;
    }
    .btn-action {
        width: 34px;
        height: 34px;
        font-size: 0.85rem;
    }
    .table-responsive {
        border: none !important;
        overflow: visible !important;
    }
    table thead {
        display: none !important;
    }
    table tbody, table tr, table td {
        display: block !important;
        width: 100% !important;
    }
    #garapanTableBody tr, #historyTableBody tr {
        background: rgba(255, 255, 255, 0.03);
        margin-bottom: 1rem;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        padding: 0 !important;
    }
    #garapanTableBody td, #historyTableBody td {
        padding: 1.25rem !important;
        box-sizing: border-box;
    }
}
</style>
