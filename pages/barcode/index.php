<div class="container animate-fade-in" style="padding: 2rem 0;">
    <div style="margin-bottom: 2rem;">
        <a href="/" style="color: var(--text-secondary); display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
        <h1 style="font-size: 2.5rem;">Generator Barcode</h1>
        <p style="color: var(--text-secondary);">Buat barcode produk Anda dengan mudah dan cepat.</p>
    </div>

    <div class="glass-panel" style="padding: 2rem; max-width: 600px; margin: 0 auto;">
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            
            <!-- Input -->
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <label style="font-weight: 500;">Isi Barcode</label>
                <input type="text" id="barcodeValue" placeholder="Contoh: 12345678" 
                       style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); padding: 1rem; border-radius: 8px; color: white; outline: none; transition: all 0.3s;">
            </div>

            <!-- Format -->
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <label style="font-weight: 500;">Format Barcode</label>
                <select id="barcodeFormat" 
                        style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); padding: 1rem; border-radius: 8px; color: white; outline: none;">
                    <option value="CODE128">CODE128 (Auto)</option>
                    <option value="EAN13">EAN13</option>
                    <option value="UPC">UPC</option>
                    <option value="CODE39">CODE39</option>
                    <option value="ITF14">ITF14</option>
                    <option value="MSI">MSI</option>
                    <option value="pharmacode">Pharmacode</option>
                </select>
            </div>

            <!-- Options -->
            <div style="display: flex; gap: 1rem;">
                <div style="flex: 1; display: flex; flex-direction: column; gap: 0.5rem;">
                    <label>Lebar</label>
                    <input type="number" id="barcodeWidth" value="2" min="1" max="4"
                           style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); padding: 0.75rem; border-radius: 8px; color: white;">
                </div>
                <div style="flex: 1; display: flex; flex-direction: column; gap: 0.5rem;">
                    <label>Tinggi</label>
                    <input type="number" id="barcodeHeight" value="100" min="10" max="150"
                           style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); padding: 0.75rem; border-radius: 8px; color: white;">
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" id="displayValue" checked style="width: 1.2rem; height: 1.2rem;">
                <label for="displayValue">Tampilkan Text</label>
            </div>

            <!-- Output -->
            <div style="background: white; padding: 2rem; border-radius: 12px; display: flex; justify-content: center; align-items: center; min-height: 150px; margin-top: 1rem;">
                <svg id="barcode"></svg>
            </div>

            <button onclick="downloadBarcode()" class="btn-primary" style="width: 100%; display: flex; justify-content: center; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-download"></i> Download Barcode
            </button>
        </div>
    </div>
</div>

<script>
    // Initialize specific page logic in a clean way if needed, 
    // or rely on the main script.js for event listeners.
    // For simplicity, we can also put page-specific initialization here.
    
    document.addEventListener('DOMContentLoaded', function() {
        if(typeof initBarcodePage === 'function') initBarcodePage();
    });
</script>
