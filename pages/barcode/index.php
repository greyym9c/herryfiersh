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
                        <textarea id="barcodeValue" class="form-control bg-dark text-white border-secondary" rows="3" placeholder="Masukkan Kode (Bisa banyak, pisahkan dengan Enter)..."></textarea>
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

    document.getElementById('excelInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, {type: 'array'});
            const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
            const jsonData = XLSX.utils.sheet_to_json(firstSheet, {header: 1});

            // Extract codes from first column and sanitize
            const newCodes = jsonData.flat()
                .filter(val => val !== null && val !== undefined)
                .map(val => val.toString().replace(/[^\x20-\x7E]/g, '').trim())
                .filter(val => val !== '');
                
            processCodes(newCodes);
        };
        reader.readAsArrayBuffer(file);
    });

    function processCodes(codes) {
        codes.forEach(code => {
            const cleanCode = code.toString().replace(/[^\x20-\x7E]/g, '').trim();
            if (cleanCode && !barcodeData.includes(cleanCode)) {
                barcodeData.push(cleanCode);
            }
        });
        renderBarcodes();
    }

    window.addManualBarcode = function() {
        const val = document.getElementById('barcodeValue').value;
        const codes = val.split('\n').map(c => c.replace(/[^\x20-\x7E]/g, '').trim()).filter(c => c !== '');
        if (codes.length > 0) {
            processCodes(codes);
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

        // LIMIT PREVIEW to 50 items to avoid DOM lag
        const previewLimit = Math.min(barcodeData.length, 50);
        const previewData = barcodeData.slice(0, previewLimit);

        previewData.forEach((code, idx) => {
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
                console.warn("Format tidak cocok, mencoba CODE128:", e);
                try {
                    JsBarcode(`#bc_${idx}`, code, {
                        format: "CODE128",
                        width: width,
                        height: height,
                        displayValue: displayValue,
                        fontSize: 10,
                        margin: 2
                    });
                } catch(err2) {
                    wrapper.style.display = 'none';
                }
            }
        });

        if (barcodeData.length > 50) {
            const notice = document.createElement('div');
            notice.className = 'col-12 mt-4 text-center';
            notice.innerHTML = `<div class="alert alert-info border-0 shadow-sm" style="background: rgba(13, 110, 253, 0.1); color: #93c5fd;">
                <i class="fa-solid fa-circle-info me-2"></i> Menampilkan ${previewLimit} preview dari total <strong>${barcodeData.length}</strong> barcode. 
                <br><em>(Membatasi preview agar browser tidak lag. Tenang, semua ${barcodeData.length} barcode tetap masuk ke PDF).</em>
            </div>`;
            container.appendChild(notice);
        }
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
    document.getElementById('downloadPdfBtn').addEventListener('click', function() {
        const btn = this;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Menyiapkan Cetak...';
        btn.disabled = true;

        // Gunakan metode Cetak Browser Native (Browser Print to PDF) karena 100% anti lag & ketajaman SVG sempurna (Vector).
        let iframe = document.getElementById('printIframe');
        if (iframe) iframe.remove();
        
        iframe = document.createElement('iframe');
        iframe.id = 'printIframe';
        iframe.style.position = 'absolute';
        iframe.style.width = '0';
        iframe.style.height = '0';
        iframe.style.border = 'none';
        document.body.appendChild(iframe);

        const idoc = iframe.contentWindow.document;
        idoc.open();
        idoc.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Cetak PDF Barcode - ${new Date().toLocaleString('id-ID')}</title>
            <style>
                @page { size: A4 portrait; margin: 15mm; }
                body { font-family: sans-serif; margin: 0; padding: 0; background: #fff; color: #000; }
                .page { width: 100%; page-break-after: always; display: flex; flex-direction: column; height: 260mm; }
                .header { text-align: left; margin-bottom: 20px; flex-shrink: 0; }
                .header h1 { font-size: 18pt; margin: 0 0 5px 0; }
                .header p { font-size: 10pt; margin: 0; color: #555; }
                .grid { display: grid; grid-template-columns: 1fr 1fr; grid-auto-rows: 40mm; gap: 15px; flex-grow: 1; }
                .barcode-item { display: flex; justify-content: center; align-items: center; padding: 5px; box-sizing: border-box; }
                svg { max-width: 100%; max-height: 100%; }
            </style>
        </head>
        <body>
            <div id="printRoot"></div>
        </body>
        </html>
        `);
        idoc.close();

        const root = idoc.getElementById('printRoot');
        const format = document.getElementById('barcodeFormat').value;
        const displayValue = document.getElementById('displayValue').checked;

        const process = async () => {
            try {
                let pageCount = Math.ceil(barcodeData.length / 10);
                let currentItem = 0;

                for (let p = 0; p < pageCount; p++) {
                    const page = idoc.createElement('div');
                    page.className = 'page';
                    
                    const header = idoc.createElement('div');
                    header.className = 'header';
                    header.innerHTML = `<h1>Rekapan Barcode HerryFiersh</h1><p>Dihasilkan pada: ${new Date().toLocaleString('id-ID')}</p>`;
                    page.appendChild(header);

                    const grid = idoc.createElement('div');
                    grid.className = 'grid';

                    for (let i = 0; i < 10; i++) {
                        if (currentItem >= barcodeData.length) break;
                        
                        if (currentItem % 10 === 0) {
                            let pct = Math.round((currentItem/barcodeData.length)*100);
                            btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin me-2"></i> Merender SVG... ${pct}%`;
                            await new Promise(r => setTimeout(r, 0));
                        }

                        const code = barcodeData[currentItem];
                        const itemDiv = idoc.createElement('div');
                        itemDiv.className = 'barcode-item';
                        
                        // Gunakan idoc.createElementNS agar konteks dokumennya sama
                        const svg = idoc.createElementNS("http://www.w3.org/2000/svg", "svg");
                        
                        try {
                            JsBarcode(svg, code, { format: format, width: 2, height: 60, displayValue: displayValue, fontSize: 16, margin: 5 });
                        } catch (e) {
                            try {
                                JsBarcode(svg, code, { format: "CODE128", width: 2, height: 60, displayValue: displayValue, fontSize: 16, margin: 5 });
                            } catch (err2) {
                                // Jika benar-benar gagal (misal karakter tidak valid), lewati dan buat tanda merah
                                const errorText = idoc.createElement('div');
                                errorText.style.color = "red";
                                errorText.style.fontSize = "12px";
                                errorText.innerText = "Error: " + code;
                                itemDiv.appendChild(errorText);
                            }
                        }

                        if (!itemDiv.hasChildNodes() || itemDiv.firstChild !== svg) {
                            // If it wasn't replaced by error text
                            itemDiv.appendChild(svg);
                        }
                        
                        grid.appendChild(itemDiv);
                        currentItem++;
                    }
                    page.appendChild(grid);
                    root.appendChild(page);
                }

                btn.innerHTML = '<i class="fa-solid fa-print me-1"></i> Membuka Print Dialog...';
                
                setTimeout(() => {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                    btn.innerHTML = '<i class="fa-solid fa-file-pdf me-1"></i> EXPORT REKAPAN PDF';
                    btn.disabled = false;
                }, 500);
            } catch (fatalErr) {
                console.error("Fatal error res:", fatalErr);
                btn.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> Error Render';
                btn.disabled = false;
            }
        };
        
        process();
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
