<div class="container animate-fade-in" style="padding: 2rem 0;">
    <div style="margin-bottom: 2rem;">
        <a href="/" style="color: var(--text-secondary); display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
        <h1 style="font-size: 2.5rem;">Kalkulator Zakat</h1>
        <p style="color: var(--text-secondary);">Hitung kewajiban zakat mal dan profesi Anda.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        
        <!-- Input -->
        <div class="glass-panel" style="padding: 2rem;">
            
            <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1);">
                <button onclick="switchTab('zakatProfesi')" id="tab-zakatProfesi" class="tab-btn active" 
                        style="padding: 0.5rem 1rem; background: transparent; border: none; color: white; border-bottom: 2px solid #a855f7; cursor: pointer;">
                    Zakat Penghasilan
                </button>
                <button onclick="switchTab('zakatMal')" id="tab-zakatMal" class="tab-btn" 
                        style="padding: 0.5rem 1rem; background: transparent; border: none; color: var(--text-secondary); cursor: pointer;">
                    Zakat Maal
                </button>
            </div>

            <div id="form-zakatProfesi">
                <div class="input-group" style="margin-bottom: 1rem;">
                    <label style="margin-bottom: 0.5rem; display: block;">Penghasilan per Bulan</label>
                    <input type="text" id="income" class="format-rupiah" placeholder="Rp 0" onkeyup="calcZakatProfesi()"
                           style="width: 100%; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); padding: 1rem; border-radius: 8px; color: white;">
                </div>
                <div class="input-group" style="margin-bottom: 1rem;">
                    <label style="margin-bottom: 0.5rem; display: block;">Bonus / THR / Lainnya</label>
                    <input type="text" id="bonus" class="format-rupiah" placeholder="Rp 0" onkeyup="calcZakatProfesi()"
                           style="width: 100%; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); padding: 1rem; border-radius: 8px; color: white;">
                </div>
            </div>

            <div id="form-zakatMal" style="display: none;">
                <div class="input-group" style="margin-bottom: 1rem;">
                    <label style="margin-bottom: 0.5rem; display: block;">Nilai Tabungan / Uang Tunai</label>
                    <input type="text" id="savings" class="format-rupiah" placeholder="Rp 0" onkeyup="calcZakatMal()"
                           style="width: 100%; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); padding: 1rem; border-radius: 8px; color: white;">
                </div>
                <div class="input-group" style="margin-bottom: 1rem;">
                    <label style="margin-bottom: 0.5rem; display: block;">Nilai Emas / Logam Mulia</label>
                    <input type="text" id="goldValue" class="format-rupiah" placeholder="Rp 0" onkeyup="calcZakatMal()"
                           style="width: 100%; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); padding: 1rem; border-radius: 8px; color: white;">
                </div>
                <div class="input-group" style="margin-bottom: 1rem;">
                    <label style="margin-bottom: 0.5rem; display: block;">Aset Investasi (Saham, dll)</label>
                    <input type="text" id="assets" class="format-rupiah" placeholder="Rp 0" onkeyup="calcZakatMal()"
                           style="width: 100%; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); padding: 1rem; border-radius: 8px; color: white;">
                </div>
                <div class="input-group" style="margin-bottom: 1rem;">
                    <label style="margin-bottom: 0.5rem; display: block;">Hutang Jatuh Tempo (Pengurang)</label>
                    <input type="text" id="debts" class="format-rupiah" placeholder="Rp 0" onkeyup="calcZakatMal()"
                           style="width: 100%; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); padding: 1rem; border-radius: 8px; color: white;">
                </div>
            </div>

        </div>

        <!-- Result -->
        <div class="glass-panel" style="padding: 2rem; display: flex; flex-direction: column; justify-content: center;">
            <div style="text-align: center;">
                <span id="zakatTitle" style="color: var(--text-secondary); display: block; margin-bottom: 1rem;">Jumlah Zakat Yang Harus Dikeluarkan</span>
                <span id="zakatResult" style="font-size: 2.5rem; font-weight: 800; color: #a855f7;">Rp 0</span>
                <p id="nishabInfo" style="margin-top: 1rem; font-size: 0.9rem; color: var(--text-secondary); background: rgba(0,0,0,0.2); padding: 1rem; border-radius: 8px;">
                    Nishab Zakat Penghasilan setara dengan 85 gram emas per tahun (approx. Rp 7.000.000/bulan).
                </p>
            </div>
        </div>

    </div>
</div>

<script>
   function switchTab(tab) {
       document.getElementById('form-zakatProfesi').style.display = tab === 'zakatProfesi' ? 'block' : 'none';
       document.getElementById('form-zakatMal').style.display = tab === 'zakatMal' ? 'block' : 'none';
       
       document.getElementById('tab-zakatProfesi').style.borderBottom = tab === 'zakatProfesi' ? '2px solid #a855f7' : 'none';
       document.getElementById('tab-zakatProfesi').style.color = tab === 'zakatProfesi' ? 'white' : 'var(--text-secondary)';
       
       document.getElementById('tab-zakatMal').style.borderBottom = tab === 'zakatMal' ? '2px solid #a855f7' : 'none';
       document.getElementById('tab-zakatMal').style.color = tab === 'zakatMal' ? 'white' : 'var(--text-secondary)';

       // Reset
       document.getElementById('zakatResult').innerText = 'Rp 0';
   }

   document.addEventListener('DOMContentLoaded', function() {
        if(typeof initZakatPage === 'function') initZakatPage();
   });
</script>
