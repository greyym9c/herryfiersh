<div class="container animate-fade-in py-3">
    <!-- Header: IHSG Overview -->
    <div class="glass-panel p-3 mb-4 bg-gradient-primary">
        <h2 class="h4 fw-bold text-white mb-0 text-uppercase d-flex align-items-center gap-2">
            <i class="fa-solid fa-chart-area"></i> 
            <span>Pasar Saham Indonesia (IHSG)</span>
        </h2>
    </div>

    <div class="row g-4">
        <!-- Main Content: Widgets -->
        <div class="col-lg-8">
            <!-- IHSG Ticker -->
            <div class="glass-panel p-1 mb-4" style="height: 100px;">
                <!-- TradingView Widget BEGIN -->
                <div class="tradingview-widget-container">
                    <div class="tradingview-widget-container__widget"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
                    {
                    "symbols": [
                        {
                        "proName": "IDX:COMPOSITE",
                        "title": "IHSG"
                        },
                        {
                        "proName": "IDX:LQ45",
                        "title": "LQ45"
                        },
                        {
                        "description": "BBCA",
                        "proName": "IDX:BBCA"
                        },
                        {
                        "description": "BBRI",
                        "proName": "IDX:BBRI"
                        },
                        {
                        "description": "BMRI",
                        "proName": "IDX:BMRI"
                        },
                        {
                        "description": "TLKM",
                        "proName": "IDX:TLKM"
                        }
                    ],
                    "showSymbolLogo": true,
                    "colorTheme": "dark",
                    "isTransparent": true,
                    "displayMode": "adaptive",
                    "locale": "id"
                    }
                    </script>
                </div>
                <!-- TradingView Widget END -->
            </div>

            <!-- Stock Screener / Hotlist -->
            <div class="glass-panel p-1" style="height: 600px;">
                <!-- TradingView Widget BEGIN -->
                <div class="tradingview-widget-container" style="height:100%;width:100%">
                    <div class="tradingview-widget-container__widget" style="height:100%;width:100%"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-screener.js" async>
                    {
                    "width": "100%",
                    "height": "100%",
                    "defaultColumn": "overview",
                    "defaultScreen": "most_capitalized",
                    "market": "indonesia",
                    "showToolbar": true,
                    "colorTheme": "dark",
                    "locale": "id",
                    "isTransparent": true
                    }
                    </script>
                </div>
                <!-- TradingView Widget END -->
            </div>
        </div>

        <!-- Sidebar: Calculator -->
        <div class="col-lg-4">
            <div class="glass-panel p-4 sticky-top" style="top: 20px; border: 1px solid rgba(168, 85, 247, 0.3); box-shadow: 0 0 20px rgba(168, 85, 247, 0.1);">
                <h4 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-calculator text-primary"></i> 
                    Kalkulator Lot
                </h4>
                <p class="text-secondary small mb-4">Hitung modal pembelian saham (1 Lot = 100 Lembar).</p>
                
                <form id="stockCalcForm">
                    <div class="mb-3">
                        <label class="form-label text-white fw-bold small text-uppercase">Harga Saham (Per Lembar)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-secondary">Rp</span>
                            <input type="text" id="stockPrice" class="form-control bg-dark text-white border-secondary format-rupiah" placeholder="0" autocomplete="off">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-white fw-bold small text-uppercase">Jumlah Lot</label>
                        <input type="number" id="stockLot" class="form-control bg-dark text-white border-secondary" placeholder="1" value="1" min="1">
                    </div>

                    <div class="d-grid mb-4">
                        <button type="button" id="calcStockBtn" class="btn btn-primary-gradient fw-bold">
                            <i class="fa-solid fa-calculator me-2"></i> Hitung Modal
                        </button>
                    </div>

                    <div class="p-3 rounded-3" style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255,255,255,0.05);">
                        <label class="d-block text-secondary small text-uppercase mb-1">Estimasi Total Modal</label>
                        <div class="h3 fw-bold text-success mb-0" id="stockTotal">Rp 0</div>
                        <div class="small text-muted mt-1" id="stockDetails">0 Lembar</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
