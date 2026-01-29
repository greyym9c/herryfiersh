<div class="container animate-fade-in py-3">
    <!-- Header -->
    <!-- Header -->
    <div class="glass-panel p-3 mb-4 d-flex justify-content-between align-items-center bg-gradient-primary">
        <h2 class="h4 fw-bold text-white mb-0 text-uppercase"><i class="fa-solid fa-chart-line me-2"></i>Monitoring Harga Emas Treasury</h2>
        <div class="text-white fw-bold d-flex align-items-center gap-2">
            <span id="realtimeClock" class="text-white fw-bold" style="font-size: 20pt; line-height: 1;">Loading...</span>
        </div>
    </div>

    <!-- Transaction History Table -->
    <!-- Dark theme container with Custom Navy Background -->
    <div class="glass-panel p-0 mb-4 overflow-hidden shadow-sm" style="background-color: #13192f; border-radius: 8px; border: 1px solid #1e293b;">
        <div class="p-3 border-bottom border-secondary d-flex justify-content-between align-items-center" style="background-color: #13192f;">
            <h5 class="fw-bold mb-0 text-white">Riwayat Transaksi (Update Per Menit)</h5>
            <small class="text-secondary" style="font-size: 0.75rem;">Data from diiniindulu.up.railway.app</small>
        </div>
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-dark table-hover mb-0 align-middle text-center" style="font-family: 'Inter', sans-serif; background-color: #13192f; --bs-table-bg: #13192f;">
                <thead class="sticky-top" style="background-color: #0f1525;">
                    <tr class="text-secondary fw-bold small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <th class="py-4 ps-3" style="width: 15%; background-color: #0f1525;">WAKTU</th>
                        <th class="py-4" style="width: 25%; background-color: #0f1525;">HARGA PASAR</th>
                        <th class="py-3" style="background-color: #0f1525;">EST. PEMBELIAN<br><span style="font-size:0.85rem">20 JUTA</span></th>
                        <th class="py-3" style="background-color: #0f1525;">EST. PEMBELIAN<br><span style="font-size:0.85rem">30 JUTA</span></th>
                        <th class="py-3" style="background-color: #0f1525;">EST. PEMBELIAN<br><span style="font-size:0.85rem">40 JUTA</span></th>
                        <th class="py-3" style="background-color: #0f1525;">EST. PEMBELIAN<br><span style="font-size:0.85rem">50 JUTA</span></th>
                    </tr>
                </thead>
                <tbody id="historyTableBody">
                    <!-- Rows will be injected here -->
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-spinner fa-spin me-2"></i> Memuat Data...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart & Info Section -->
    <div class="row g-4">
        <!-- Left Sidebar: Info & USD List -->
        <div class="col-lg-4">
            <!-- Info Card -->
            <div class="glass-panel p-4 mb-4">
                <h5 class="text-white fw-bold mb-3">Sekilas Ingfo Treasury</h5>
                <ul class="list-unstyled text-secondary small mb-0 d-flex flex-column gap-2">
                    <li class="d-flex justify-content-between">
                        <span>Min. Beli Emas</span>
                        <span class="text-white fw-bold">Rp 5.000</span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span>Spread</span>
                        <span class="text-white fw-bold">~3.5%</span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span>Jam Operasional</span>
                        <span class="text-success fw-bold">24 Jam / 7 Hari</span>
                    </li>
                    <li class="border-top border-white-10 my-1"></li>
                     <li>
                        <i class="fa-brands fa-telegram me-2 text-info"></i>
                        <a href="#" class="text-info text-decoration-none">Join Grup Diskusi</a>
                    </li>
                </ul>
            </div>

            <!-- USD/IDR Rates -->
             <div class="glass-panel p-4 mb-4">
                 <h5 class="text-white fw-bold mb-3"><i class="fa-solid fa-money-bill-1-wave me-2 text-success"></i>Kurs USD/IDR</h5>
                 <!-- TradingView Mini Chart for USDIDR -->
                 <div class="tradingview-widget-container">
                    <div class="tradingview-widget-container__widget"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                    {
                    "symbol": "FX_IDC:USDIDR",
                    "width": "100%",
                    "height": 220,
                    "locale": "id",
                    "dateRange": "1D",
                    "colorTheme": "dark",
                    "isTransparent": true,
                    "autosize": false,
                    "largeChartUrl": ""
                    }
                    </script>
                </div>
             </div>
        </div>

        <!-- Right Main: Gold Chart & Calendar -->
        <div class="col-lg-8">
            <!-- TradingView Chart -->
            <div class="glass-panel p-1 mb-4" style="height: 500px;">
                <!-- TradingView Widget BEGIN -->
                <div class="tradingview-widget-container" style="height:100%;width:100%">
                    <div class="tradingview-widget-container__widget" style="height:100%;width:100%"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                    {
                    "autosize": true,
                    "symbol": "OANDA:XAUUSD",
                    "interval": "5",
                    "timezone": "Asia/Jakarta",
                    "theme": "dark",
                    "style": "1",
                    "locale": "id",
                    "enable_publishing": false,
                    "hide_top_toolbar": false,
                    "allow_symbol_change": true,
                    "save_image": false,
                    "calendar": false,
                    "hide_volume": true,
                    "support_host": "https://www.tradingview.com"
                    }
                    </script>
                </div>
                <!-- TradingView Widget END -->
            </div>

            <!-- Economic Calendar -->
            <div class="glass-panel p-1" style="height: 400px;">
                  <!-- TradingView Widget BEGIN -->
                <div class="tradingview-widget-container" style="height:100%;width:100%">
                    <div class="tradingview-widget-container__widget" style="height:100%;width:100%"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-events.js" async>
                    {
                    "width": "100%",
                    "height": "100%",
                    "colorTheme": "dark",
                    "isTransparent": true,
                    "locale": "id",
                    "importanceFilter": "0,1",
                    "currencyFilter": "USD,IDR"
                    }
                    </script>
                </div>
                <!-- TradingView Widget END -->
            </div>
        </div>
    </div>
</div>

<script>
    // System Config
    const WS_URL = 'wss://diiniindulu.up.railway.app/ws';
    let socket;
    let reconnectTimer = null;
    let hasReceivedWSData = false;

    // --- 1. Realtime Clock & Sync ---
    function updateClock() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        let dateStr = now.toLocaleDateString('id-ID', options);
        dateStr = dateStr.replace(/:/g, '.'); // Replace colons with dots
        
        document.getElementById('realtimeClock').innerText = dateStr + ' WIB';
    }
    setInterval(updateClock, 1000);
    updateClock();

    // --- 2. Initial Fallback (Proxy) ---
    // REMOVED: No longer fetching from api/treasury_proxy.php


    // --- 3. WebSocket Connection ---
    function connectWebSocket() {
        // Show loading initially
        const tbody = document.getElementById('historyTableBody');
        if(!hasReceivedWSData) {
             tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-spinner fa-spin me-2"></i> Menghubungkan ke Realtime Server...
                    </td>
                </tr>`;
        }

        socket = new WebSocket(WS_URL);
        socket.binaryType = 'arraybuffer'; // IMPORTANT: Match server expectation

        let pingInterval;
        let lastPong = Date.now();

        socket.onopen = function(e) {
            console.log("Connected to Realtime Reference WS");
            lastPong = Date.now();
            
            // Setup Ping Loop to keep connection alive
            if (pingInterval) clearInterval(pingInterval);
            pingInterval = setInterval(function(){
                if (socket && socket.readyState === WebSocket.OPEN) {
                    if (Date.now() - lastPong > 45000) {
                        console.warn("Connection stale, closing...");
                        socket.close();
                        return;
                    }
                    try { socket.send('ping'); } catch(e) {}
                }
            }, 20000);
        };

        socket.onmessage = function(event) {
            lastPong = Date.now();
            try {
                let data;
                if (event.data instanceof ArrayBuffer) {
                    const text = new TextDecoder().decode(event.data);
                    data = JSON.parse(text);
                } else {
                    data = JSON.parse(event.data);
                }

                if (data.pong) return; // Ignore pong messages

                if (data.history && Array.isArray(data.history)) {
                    hasReceivedWSData = true;
                    // Sort Newest
                    data.history.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                    renderTable(data.history);
                }
            } catch (e) { console.error("WS Parse Error", e); }
        };

        socket.onclose = function(event) {
            console.log("WS Closed. Reconnecting...");
            if (pingInterval) clearInterval(pingInterval);
            if (reconnectTimer) clearTimeout(reconnectTimer);
            reconnectTimer = setTimeout(connectWebSocket, 3000); 
        };
        
        socket.onerror = function(err) {
            console.error("WS Error", err);
            socket.close();
        };
    }

    // --- 4. Render Table (Dark Theme) ---
    function renderTable(history) {
        const tbody = document.getElementById('historyTableBody');
        tbody.innerHTML = ''; 

        const rows = history.slice(0, 20); 

        rows.forEach((item, index) => {
            const tr = document.createElement('tr');
            // Default bootstrap dark stripes, no explicit white/border
            
            // 1. Waktu (Format: "Kamis 11:45:02")
            // Parse item.created_at or Use Current if it's new
            let dateObj = new Date(item.created_at);
            // Fallback if invalid
            if (isNaN(dateObj.getTime())) dateObj = new Date();
            
            const dayName = dateObj.toLocaleDateString('id-ID', {weekday: 'long'});
            let timeStr = dateObj.toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit', second:'2-digit'});
            timeStr = timeStr.replace(/\./g, ':'); // Ensure colons
            
            const finalTimeDisplay = `${dayName} ${timeStr}`;

            const icon = `<i class="fa-solid fa-rocket text-success mt-1 d-block" style="font-size:0.8rem"></i>`;
            
            // Text White
            const col1 = `<td class="py-3">
                <div class="fw-bold fs-5 text-white time-display" style="font-family:monospace; letter-spacing:-0.5px;">${finalTimeDisplay}</div>
                ${icon}
            </td>`;
            
            // 2. Harga Pasar (+Diff Calculation)
            let diff = 0;
            // Compare with the *next* item in the list (which is the *older* record)
            if (index < history.length - 1) {
                const currentPrice = parsePrice(item.buying_rate);
                const prevPrice = parsePrice(history[index + 1].buying_rate);
                diff = currentPrice - prevPrice;
            }
            
            let diffHtml = '';
            if (diff !== 0) {
                const color = diff > 0 ? 'text-success' : 'text-danger';
                const sign = diff > 0 ? '+' : '';
                const icon = diff > 0 ? 'fa-arrow-up' : 'fa-arrow-down';
                diffHtml = `<span class="${color} small fw-bold ms-2"><i class="fa-solid ${icon} me-1"></i>${sign}Rp${formatNum(diff)}</span>`;
            } else {
                 diffHtml = `<span class="text-secondary small fw-bold ms-2"><i class="fa-solid fa-minus me-1"></i>Rp0</span>`;
            }

            const col2 = `<td class="py-3 text-start ps-5">
                <div class="fw-bold text-white fs-5 d-flex align-items-center">
                    Rp${item.buying_rate}
                    ${diffHtml}
                </div>
                <div class="text-secondary small mt-1">Jual: Rp${item.selling_rate}</div>
            </td>`;
            
            // 3. Estimations
            const priceSell = parsePrice(item.selling_rate); // Use parsed price for calc
            const col20 = renderEstCell(item.jt20, priceSell, 20);
            const col30 = renderEstCell(item.jt30, priceSell, 30);
            const col40 = renderEstCell(item.jt40, priceSell, 40);
            const col50 = renderEstCell(item.jt50, priceSell, 50);

            tr.innerHTML = col1 + col2 + col20 + col30 + col40 + col50;
            tbody.appendChild(tr);
        });
    }

    function renderEstCell(profit, sellPrice, million) {
        let pVal = profit !== undefined ? profit : 0;
        // User requested: "jangan merah, tapi hijau" for all rows
        let pColor = 'text-success'; 
        let pSign = pVal > 0 ? '+' : '';
        let grams = ((million * 1000000) / sellPrice).toFixed(3) + 'g'; 
        
        // Dark Pill: bg-dark text-white border-secondary
        return `<td class="py-3">
            <div class="${pColor} fw-bold mb-1" style="font-size:1.1rem">${pSign}Rp${formatNum(pVal)}</div>
            <div class="d-inline-block px-3 py-1 bg-dark text-white border border-secondary rounded-3 small fw-bold">${grams}</div>
        </td>`;
    }

    const parsePrice = (n) => {
        if (typeof n === 'string') {
             // Remove thousands separator (.) and replace decimal separator (,) with (.)
             return parseFloat(n.trim().replace(/\./g, '').replace(',', '.'));
        }
        return parseFloat(n);
    };

    const formatNum = (n) => {
        if (n === null || n === undefined) return '0';
        const val = parsePrice(n);
        // User requested exact price, no rounding (default is 3 digits)
        return isNaN(val) ? '0' : new Intl.NumberFormat('id-ID', { maximumFractionDigits: 8 }).format(val);
    };

    // Start
    connectWebSocket();
</script>