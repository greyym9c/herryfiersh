<div class="container animate-fade-in py-3">
    <!-- Header: Crypto Market -->
    <div class="glass-panel p-3 mb-4 bg-gradient-primary">
        <h2 class="h4 fw-bold text-white mb-0 text-uppercase d-flex align-items-center gap-2">
            <i class="fa-brands fa-bitcoin"></i> 
            <span>Pasar Crypto (Bitcoin & Altcoins)</span>
        </h2>
    </div>

    <div class="row g-4">
        <!-- Main Content: Widgets -->
        <div class="col-lg-8">
            <!-- Bitcoin Advanced Chart -->
            <div class="glass-panel p-1 mb-4" style="height: 500px;">
                <!-- TradingView Widget BEGIN -->
                <div class="tradingview-widget-container" style="height:100%;width:100%">
                    <div class="tradingview-widget-container__widget" style="height:100%;width:100%"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                    {
                    "autosize": true,
                    "symbol": "BINANCE:BTCUSDT",
                    "interval": "D",
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

            <!-- Crypto Screener -->
            <div class="glass-panel p-1" style="height: 600px;">
                <!-- TradingView Widget BEGIN -->
                <div class="tradingview-widget-container" style="height:100%;width:100%">
                    <div class="tradingview-widget-container__widget" style="height:100%;width:100%"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-screener.js" async>
                    {
                    "width": "100%",
                    "height": "100%",
                    "defaultColumn": "overview",
                    "defaultScreen": "general",
                    "market": "crypto",
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
            <div class="glass-panel p-4 sticky-top" style="top: 20px; border: 1px solid rgba(247, 147, 26, 0.3); box-shadow: 0 0 20px rgba(247, 147, 26, 0.1);">
                <h4 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-calculator text-warning"></i> 
                    Kalkulator Crypto
                </h4>
                <p class="text-secondary small mb-4">Hitung estimasi modal pembelian Token/Koin.</p>
                
                <form id="cryptoCalcForm">
                    <div class="mb-3">
                        <label class="form-label text-white fw-bold small text-uppercase">Harga Koin (IDR)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-secondary">Rp</span>
                            <input type="text" id="cryptoPrice" class="form-control bg-dark text-white border-secondary format-rupiah" placeholder="0" autocomplete="off">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-white fw-bold small text-uppercase">Jumlah Koin</label>
                        <input type="number" id="cryptoAmount" class="form-control bg-dark text-white border-secondary" placeholder="0.0001" step="any">
                    </div>

                    <div class="d-grid mb-4">
                        <button type="button" id="calcCryptoBtn" class="btn btn-primary-gradient fw-bold" style="background: linear-gradient(135deg, #f7931a 0%, #ffc107 100%); border:none;">
                            <i class="fa-solid fa-calculator me-2"></i> Hitung
                        </button>
                    </div>

                    <div class="p-3 rounded-3" style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255,255,255,0.05);">
                        <label class="d-block text-secondary small text-uppercase mb-1">Estimasi Total</label>
                        <div class="h3 fw-bold text-warning mb-0" id="cryptoTotal">Rp 0</div>
                        <div class="small text-muted mt-1" id="cryptoDetails">0 Coin</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
