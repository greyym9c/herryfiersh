<div class="container animate-fade-in py-3">
    <!-- Header -->
    <div class="glass-panel p-3 mb-4 d-flex justify-content-between align-items-center bg-gradient-primary">
        <h2 class="h4 fw-bold text-white mb-0 text-uppercase"><i class="fa-solid fa-barcode me-2"></i>Bulk Barcode & Export</h2>
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

    <div class="row g-4">
        <!-- Sidebar Controls -->
        <div class="col-lg-4">
            <div class="glass-panel p-4 h-100" style="background-color: #13192f; border: 1px solid #1e293b;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="h5 mb-0 text-white"><i class="fa-solid fa-sliders me-2 text-primary"></i> Kontrol</h3>
                    <a href="?page=home" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                </div>

                <!-- Excel Upload Section -->
                <div class="mb-4 p-3 rounded-3" style="border: 2px dashed rgba(255,255,255,0.1); background: rgba(0,0,0,0.2);">
                    <label class="form-label small text-info fw-bold mb-2 text-uppercase"><i class="fa-solid fa-file-excel me-1"></i> Impor Data Excel</label>
                    <input type="file" id="excelInput" class="form-control form-control-sm bg-dark text-white border-0" accept=".xlsx, .xls">
                    <div class="mt-2" style="font-size: 0.7rem; color: #94a3b8;">
                        * Gunakan kolom pertama untuk kode barcode atau nama produk.
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label small text-secondary fw-bold">INPUT MANUAL</label>
                        <input type="text" id="barcodeValue" class="form-control bg-dark text-white border-secondary" placeholder="Masukkan Kode...">
                    </div>

                    <div class="col-12">
                        <label class="form-label small text-secondary fw-bold">FORMAT</label>
                        <select id="barcodeFormat" class="form-select bg-dark text-white border-secondary">
                            <option value="CODE128">CODE128 (Auto)</option>
                            <option value="EAN13">EAN13</option>
                            <option value="UPC">UPC</option>
                            <option value="CODE39">CODE39</option>
                        </select>
                    </div>

                    <div class="col-6">
                        <label class="form-label small text-secondary fw-bold">LEBAR</label>
                        <input type="number" id="barcodeWidth" value="2" min="1" max="4" class="form-control bg-dark text-white border-secondary">
                    </div>

                    <div class="col-6">
                        <label class="form-label small text-secondary fw-bold">TINGGI</label>
                        <input type="number" id="barcodeHeight" value="50" min="20" max="150" class="form-control bg-dark text-white border-secondary">
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="displayValue" checked>
                            <label class="form-check-label text-white small" for="displayValue">Tampilkan Teks</label>
                        </div>
                    </div>

                    <div class="col-12 d-grid gap-2 mt-4">
                        <button onclick="addManualBarcode()" class="btn btn-outline-primary fw-bold">
                            <i class="fa-solid fa-plus me-1"></i> TAMBAH BARCODE
                        </button>
                        <button id="downloadPdfBtn" class="btn btn-success fw-bold" disabled>
                            <i class="fa-solid fa-file-pdf me-1"></i> EXPORT REKAPAN PDF
                        </button>
                        <button onclick="clearAll()" class="btn btn-outline-danger btn-sm mt-2">
                            <i class="fa-solid fa-trash-can me-1"></i> BERSIHKAN SEMUA
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Area -->
        <div class="col-lg-8">
            <div class="glass-panel p-4 h-100" style="background-color: #0f1525; border: 1px solid #1e293b; min-height: 500px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="h5 mb-0 text-white"><i class="fa-solid fa-eye me-2 text-warning"></i> Preview Rekapan (<span id="countDisplay">0</span>)</h3>
                </div>

                <div id="barcodeContainer" class="row g-3">
                    <div class="col-12 text-center py-5 text-secondary opacity-50">
                        <i class="fa-solid fa-file-circle-plus display-1 mb-3"></i>
                        <p>Silakan upload Excel atau isi manual untuk mulai.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.5/JsBarcode.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let barcodeData = [];

    // --- Time Logic ---
    function updateClock() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('realtimeClock').innerHTML = `${h}:${m} WIB`;
        document.getElementById('bigRealtimeClock').innerHTML = `${h}:${m}<span style="font-size:0.5em; color: #fff; vertical-align: top; margin-left:5px;">${s}</span>`;
        document.getElementById('currentDate').innerText = now.toLocaleDateString('id-ID', options);
    }
    setInterval(updateClock, 1000);
    updateClock();

    // --- Excel Logic ---
    document.getElementById('excelInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, {type: 'array'});
            const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
            const jsonData = XLSX.utils.sheet_to_json(firstSheet, {header: 1});

            // Extract codes from first column
            const newCodes = jsonData.flat().filter(val => val && val.toString().trim() !== '');
            processCodes(newCodes);
        };
        reader.readAsArrayBuffer(file);
    });

    function processCodes(codes) {
        codes.forEach(code => {
            if (!barcodeData.includes(code.toString())) {
                barcodeData.push(code.toString());
            }
        });
        renderBarcodes();
    }

    window.addManualBarcode = function() {
        const val = document.getElementById('barcodeValue').value.trim();
        if (val) {
            processCodes([val]);
            document.getElementById('barcodeValue').value = '';
        }
    };

    window.clearAll = function() {
        barcodeData = [];
        renderBarcodes();
        document.getElementById('excelInput').value = '';
    };

    function renderBarcodes() {
        const container = document.getElementById('barcodeContainer');
        const downloadBtn = document.getElementById('downloadPdfBtn');
        const countDisplay = document.getElementById('countDisplay');
        
        container.innerHTML = '';
        countDisplay.innerText = barcodeData.length;

        if (barcodeData.length === 0) {
            container.innerHTML = '<div class="col-12 text-center py-5 text-secondary opacity-50"><i class="fa-solid fa-file-circle-plus display-1 mb-3"></i><p>Silakan upload Excel atau isi manual untuk mulai.</p></div>';
            downloadBtn.disabled = true;
            return;
        }

        downloadBtn.disabled = false;
        
        const format = document.getElementById('barcodeFormat').value;
        const width = document.getElementById('barcodeWidth').value;
        const height = document.getElementById('barcodeHeight').value;
        const displayValue = document.getElementById('displayValue').checked;

        barcodeData.forEach((code, idx) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'col-sm-6 col-md-4 col-xl-3';
            wrapper.innerHTML = `
                <div class="p-3 bg-white rounded-3 shadow-sm d-flex justify-content-center align-items-center flex-column overflow-hidden h-100" style="min-height: 160px;">
                    <div class="mb-2" style="max-width: 100%;">
                        <svg id="bc_${idx}"></svg>
                    </div>
                    <div class="d-flex gap-2 w-100 justify-content-center mt-auto pt-2 border-top">
                         <button onclick="downloadSingleImage(${idx}, '${code}')" class="btn btn-sm btn-outline-primary py-1 px-3" title="Download Gambar (PNG)">
                            <i class="fa-solid fa-image me-1"></i> PNG
                         </button>
                         <button onclick="downloadSinglePdf(${idx}, '${code}')" class="btn btn-sm btn-outline-danger py-1 px-3" title="Download PDF (Single)">
                            <i class="fa-solid fa-file-pdf me-1"></i> PDF
                         </button>
                    </div>
                </div>
            `;
            container.appendChild(wrapper);

            try {
                JsBarcode(`#bc_${idx}`, code, {
                    format: format,
                    width: width,
                    height: height,
                    displayValue: displayValue,
                    fontSize: 10,
                    margin: 2
                });
            } catch (e) {
                console.error("Barcode error:", e);
                wrapper.querySelector('svg').innerHTML = `<text y="20" fill="red" font-size="10">Format Salah</text>`;
            }
        });
    }

    // --- Individual Download Functions ---
    window.downloadSingleImage = function(idx, code) {
        const svg = document.getElementById(`bc_${idx}`);
        const wrapper = svg.closest('.bg-white');
        const buttons = wrapper.querySelector('.d-flex');
        
        // Hide buttons temporarily for clean screenshot
        buttons.style.visibility = 'hidden';
        
        html2canvas(wrapper, { scale: 3, backgroundColor: '#ffffff' }).then(canvas => {
            buttons.style.visibility = 'visible';
            const link = document.createElement('a');
            link.download = `Barcode_${code}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
        });
    };

    window.downloadSinglePdf = function(idx, code) {
        const { jsPDF } = window.jspdf;
        const svg = document.getElementById(`bc_${idx}`);
        const wrapper = svg.closest('.bg-white');
        const buttons = wrapper.querySelector('.d-flex');

        buttons.style.visibility = 'hidden';
        
        html2canvas(wrapper, { scale: 3, backgroundColor: '#ffffff' }).then(canvas => {
            buttons.style.visibility = 'visible';
            const imgData = canvas.toDataURL('image/png');
            
            // Format PDF (Small landscape)
            const pdf = new jsPDF('l', 'mm', [100, 60]); 
            pdf.addImage(imgData, 'PNG', 5, 5, 90, 50);
            pdf.save(`Barcode_${code}.pdf`);
        });
    };

    // --- PDF Logic ---
    document.getElementById('downloadPdfBtn').addEventListener('click', async function() {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');
        const container = document.getElementById('barcodeContainer');
        const items = container.querySelectorAll('svg');
        
        const btn = this;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Memproses PDF...';
        btn.disabled = true;

        let xOffset = 10;
        let yOffset = 20;
        const pageWidth = 210;
        const pageHeight = 297;
        const itemWidth = 45;
        const itemHeight = 35;

        pdf.setFontSize(16);
        pdf.text("Rekapan Barcode HerryFiersh", 10, 10);
        pdf.setFontSize(8);
        pdf.text(`Dihasilkan pada: ${new Date().toLocaleString('id-ID')}`, 10, 15);

        for (let i = 0; i < items.length; i++) {
            const svg = items[i];
            
            // Convert SVG to Canvas then to Image
            const canvas = await html2canvas(svg.parentElement, { scale: 3, backgroundColor: '#ffffff' });
            const imgData = canvas.toDataURL('image/png');

            if (xOffset + itemWidth > pageWidth - 10) {
                xOffset = 10;
                yOffset += itemHeight + 5;
            }

            if (yOffset + itemHeight > pageHeight - 10) {
                pdf.addPage();
                yOffset = 20;
                xOffset = 10;
            }

            pdf.addImage(imgData, 'PNG', xOffset, yOffset, itemWidth, itemHeight);
            xOffset += itemWidth + 5;
        }

        pdf.save(`Rekapan_Barcode_${Date.now()}.pdf`);
        btn.innerHTML = '<i class="fa-solid fa-file-pdf me-1"></i> EXPORT REKAPAN PDF';
        btn.disabled = false;
    });

    // Re-render when options change
    ['barcodeFormat', 'barcodeWidth', 'barcodeHeight', 'displayValue'].forEach(id => {
        document.getElementById(id).addEventListener('change', renderBarcodes);
    });
});
</script>

<style>
.bg-primary-gradient { background: var(--accent-gradient); border: none; }
.shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0,0,0,0.06); }
.glass-panel { transition: all 0.3s ease; }
#barcodeContainer svg { max-width: 100%; height: auto !important; }
</style>
