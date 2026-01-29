<div class="container animate-fade-in" style="padding: 2rem 0;">
    <div style="margin-bottom: 2rem;">
        <a href="/" style="color: var(--text-secondary); display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
        <h1 style="font-size: 2.5rem;">Kalkulator Emas</h1>
        <p style="color: var(--text-secondary);">Hitung estimasi nilai emas dan keuntungan investasi Anda.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        
        <!-- Calculator Form -->
        <div class="glass-panel" style="padding: 2rem;">
            <h3 style="margin-bottom: 1.5rem; color: #a855f7;">Input Data</h3>
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                <div class="input-group">
                    <label style="margin-bottom: 0.5rem; display: block;">Berat Emas (gram)</label>
                    <input type="number" id="goldWeight" placeholder="0" step="0.01"
                           style="width: 100%; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); padding: 1rem; border-radius: 8px; color: white;">
                </div>

                <div class="input-group">
                    <label style="margin-bottom: 0.5rem; display: block;">Harga Beli (per gram)</label>
                    <input type="text" id="buyPrice" class="format-rupiah" placeholder="Rp 0"
                           style="width: 100%; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); padding: 1rem; border-radius: 8px; color: white;">
                </div>

                <div class="input-group">
                    <label style="margin-bottom: 0.5rem; display: block;">Harga Saat Ini / Jual (per gram)</label>
                    <input type="text" id="currentPrice" class="format-rupiah" placeholder="Rp 0"
                           style="width: 100%; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); padding: 1rem; border-radius: 8px; color: white;">
                </div>

                <button onclick="calculateGold()" class="btn-primary" style="margin-top: 1rem;">
                    Hitung Keuntungan
                </button>
            </div>
        </div>

        <!-- Result -->
        <div class="glass-panel" style="padding: 2rem; display: flex; flex-direction: column; justify-content: center;">
            <h3 style="margin-bottom: 1.5rem; color: #6366f1;">Analisa Keuntungan</h3>
            
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: flex; justify-content: space-between; padding-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <span style="color: var(--text-secondary);">Total Modal</span>
                    <span id="totalModal" style="font-weight: 600;">Rp 0</span>
                </div>

                <div style="display: flex; justify-content: space-between; padding-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <span style="color: var(--text-secondary);">Nilai Saat Ini</span>
                    <span id="totalValue" style="font-weight: 600;">Rp 0</span>
                </div>

                <div style="background: rgba(0,0,0,0.2); padding: 1.5rem; border-radius: 12px; text-align: center;">
                    <span style="color: var(--text-secondary); display: block; margin-bottom: 0.5rem;">Estimasi Profit / Loss</span>
                    <span id="profitLoss" style="font-size: 2rem; font-weight: 800; color: white;">Rp 0</span>
                    <br>
                    <span id="percentage" style="font-size: 0.9rem; padding: 0.25rem 0.5rem; border-radius: 4px; display: inline-block; margin-top: 0.5rem;">0%</span>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if(typeof initGoldPage === 'function') initGoldPage();
    });
</script>
