<?php
// pages/struk/index.php
?>
<div class="container animate-fade-in py-3 no-print">
    <!-- Header -->
    <div class="glass-panel p-3 mb-4 d-flex justify-content-between align-items-center bg-gradient-primary">
        <h2 class="h4 fw-bold text-white mb-0 text-uppercase"><i class="fa-solid fa-receipt me-2"></i>Generator Struk Digital</h2>
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
</div>

<div class="container animate-fade-in pb-5">

    <div class="row">
        <!-- Input Form (Left Side) -->
        <div class="col-lg-5 mb-4 no-print">
            <div class="glass-panel p-4 h-100" style="background-color: #13192f; border: 1px solid #1e293b;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="text-white mb-0 fw-bold"><i class="fa-solid fa-file-pen me-2 text-primary"></i> Atur Struk</h4>
                    <a href="/herryfiersh/" class="btn btn-sm btn-outline-secondary no-print">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <!-- Logo Section -->
                <div class="mb-3">
                    <label class="form-label text-white small">Logo Toko (Upload)</label>
                    <input type="file" class="form-control bg-dark border-secondary text-white" id="storeLogoInput" accept="image/*">
                </div>

                <!-- Store Info -->
                <div class="mb-3">
                    <label class="form-label text-white small">Nama Toko *</label>
                    <input type="text" class="form-control bg-dark border-secondary text-white" id="storeName" placeholder="Contoh: TOKO BERKAH">
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label text-white small">No. Struk</label>
                        <input type="text" class="form-control bg-dark border-secondary text-white" id="receiptNo" placeholder="#001">
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label text-white small">Mode Tanggal</label>
                        <select class="form-select bg-dark border-secondary text-white" id="dateMode">
                            <option value="auto">Otomatis (Sekarang)</option>
                            <option value="manual">Manual</option>
                        </select>
                        <input type="datetime-local" class="form-control bg-dark border-secondary text-white mt-2 d-none" id="manualDateInput">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-white small">Alamat Toko</label>
                    <textarea class="form-control bg-dark border-secondary text-white" id="storeAddress" rows="2" placeholder="Alamat lengkap dan nomor telepon"></textarea>
                </div>

                <hr class="border-secondary my-4">

                <!-- Product List -->
                <div class="mb-3">
                    <label class="form-label text-white small">Daftar Produk & Harga</label>
                    <div id="inputItemList" class="d-flex flex-column gap-2 mb-2">
                        <!-- Items will be added here via JS -->
                    </div>
                    
                    <div class="d-flex gap-2 mb-2">
                        <input type="text" class="form-control bg-dark border-secondary text-white" id="newItemName" placeholder="Nama Barang">
                        <input type="number" class="form-control bg-dark border-secondary text-white" id="newItemPrice" placeholder="Harga">
                    </div>
                    <button type="button" class="btn btn-sm btn-primary w-100" onclick="addItem()">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Barang
                    </button>
                </div>

                <hr class="border-secondary my-4">

                <!-- Totals & Payment -->
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label text-white small">Diskon Total (Rp)</label>
                        <input type="number" class="form-control bg-dark border-secondary text-white" id="discountTotal" placeholder="0">
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label text-white small">Pajak/Biaya (Rp)</label>
                        <input type="number" class="form-control bg-dark border-secondary text-white" id="taxTotal" placeholder="0">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-white small">Uang Dibayar (Rp)</label>
                    <input type="number" class="form-control bg-dark border-secondary text-white" id="paidAmount" placeholder="0">
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label text-white small">Status Pelunasan</label>
                        <select class="form-select bg-dark border-secondary text-white" id="paymentStatus">
                            <option value="LUNAS" selected>LUNAS</option>
                            <option value="BELUM LUNAS">BELUM LUNAS</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label text-white small">Metode Pembayaran</label>
                        <select class="form-select bg-dark border-secondary text-white" id="paymentMethod">
                            <option value="TUNAI" selected>TUNAI</option>
                            <option value="TRANSFER">TRANSFER</option>
                            <option value="QRIS">QRIS</option>
                            <option value="KREDIT">KREDIT</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-white small">Ket. Bayar (Nama Bank/Ref)</label>
                    <input type="text" class="form-control bg-dark border-secondary text-white" id="paymentNote" placeholder="Contoh: BCA / Sukses">
                </div>

                <div class="mb-3">
                    <label class="form-label text-white small">Pesan Penutup</label>
                    <textarea class="form-control bg-dark border-secondary text-white" id="footerMessage" rows="2" placeholder="Terima kasih, silakan berkunjung kembali!"></textarea>
                </div>
                
                <!-- Action Buttons -->
                <div class="d-grid gap-2">
                    <button class="btn btn-success py-2 fw-bold" onclick="window.print()">
                        <i class="fa-solid fa-print me-2"></i> CETAK STRUK SEKARANG
                    </button>
                    <button class="btn btn-primary-gradient py-2 fw-bold shadow-sm" onclick="downloadImage()">
                        <i class="fa-solid fa-image me-2"></i> SIMPAN JPG (IMAGE)
                    </button>
                </div>
            </div>
        </div>

        <!-- Receipt Preview (Right Side / Print Area) -->
        <div class="col-lg-7 d-flex justify-content-center bg-transparent no-print-bg">
            <div class="position-sticky" style="top: 100px;">
                <div id="receiptPreview" class="p-3 bg-white text-black shadow-sm" style="width: 380px; min-height: 400px; font-family: 'Courier New', Courier, monospace;">
                    
                    <!-- Receipt Content -->
                    <div class="text-center mb-3">
                        <img id="rLogo" src="" alt="Logo" style="max-height: 80px; display: none;" class="mb-2 mx-auto">
                        <h4 id="rStoreName" class="fw-bold fs-5 mb-1 text-uppercase text-black">TOKO BERKAH</h4>
                        <p id="rStoreAddress" class="small mb-1 text-black" style="white-space: pre-line;">Jl. Mawar No. 123, Jakarta&#10;Telp: 0812-3456-7890</p>
                        <div class="border-bottom border-dark border-2 border-dashed my-2"></div>
                        <div class="d-flex justify-content-between small text-black">
                            <span id="rDate">01/01/2026 12:00</span>
                            <span id="rNo">#001</span>
                        </div>
                    </div>
    
                    <!-- Items Table -->
                    <table class="table table-sm table-borderless small mb-2 w-100 text-black">
                        <tbody id="rItemsList">
                            <!-- Items rendered here -->
                        </tbody>
                    </table>
    
                    <div class="border-top border-dark border-1 border-dashed mb-2"></div>
    
                    <!-- Totals -->
                    <div class="small text-black">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Total Harga</span>
                            <span id="rSubTotal">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1" id="rDiscountRow" style="display:none;">
                            <span>Diskon</span>
                            <span id="rDiscount">- Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1" id="rTaxRow" style="display:none;">
                            <span>Pajak/Biaya</span>
                            <span id="rTax">+ Rp 0</span>
                        </div>
                        <div class="border-top border-dark border-1 border-dashed my-1"></div>
                        <div class="d-flex justify-content-between fw-bold fs-6 mb-2">
                            <span>TOTAL TAGIHAN</span>
                            <span id="rGrandTotal">Rp 0</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-1">
                            <span id="rPaymentStatus">TUNAI</span>
                            <span id="rPaid">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>KEMBALIAN</span>
                            <span id="rChange">Rp 0</span>
                        </div>
                        <div class="mt-2 text-start fst-italic" id="rPaymentNoteRow">
                            Ket: <span id="rPaymentNote"></span>
                        </div>
                    </div>
    
                    <!-- Footer -->
                    <div class="border-top border-dark border-2 border-dashed my-3"></div>
                    <div class="text-center small text-black">
                        <p id="rFooterMessage" class="mb-2" style="white-space: pre-line;">Terima kasih, silakan berkunjung kembali!</p>
                        <p class="mb-0 text-muted" style="font-size: 0.7rem;">Powered by HerryFiersh</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Adjust input list styling */
.item-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(255, 255, 255, 0.05);
    padding: 0.5rem;
    border-radius: 4px;
    margin-bottom: 0.5rem;
}
.item-row span {
    color: var(--text-primary);
    font-size: 0.9rem;
}
.delete-btn {
    color: #ef4444;
    cursor: pointer;
    background: none;
    border: none;
}

/* Force text colors in receipt to be black */
#receiptPreview, #receiptPreview * {
    color: #000000 !important;
}

@media print {
    @page {
        margin: 0;
        size: auto;
    }
    
    body {
        background-color: white !important;
        margin: 0;
        padding: 0;
    }

    /* Hide everything EXCEPT the receipt */
    body > *:not(#receiptPreview),
    header, footer, nav, 
    .no-print, 
    .animate-fade-in > .row > .col-lg-5,
    .no-print-bg {
        display: none !important;
    }
    
    /* Make receipt visible and positioned correctly */
    .animate-fade-in > .row > .col-lg-7 {
        display: block !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    #receiptPreview {
        display: block !important;
        visibility: visible !important;
        width: 100% !important;
        max-width: 100% !important;
        box-shadow: none !important;
        margin: 0 !important;
        padding: 5mm !important;
        position: static !important;
        border: none !important;
    }
}
</style>

<!-- Add html2canvas for Image Download -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // State management
    let items = [];
    
    // Elements
    const elements = {
        storeLogoInput: document.getElementById('storeLogoInput'),
        storeName: document.getElementById('storeName'),
        receiptNo: document.getElementById('receiptNo'),
        storeAddress: document.getElementById('storeAddress'),
        dateMode: document.getElementById('dateMode'),
        manualDateInput: document.getElementById('manualDateInput'),
        newItemName: document.getElementById('newItemName'),
        newItemPrice: document.getElementById('newItemPrice'),
        inputItemList: document.getElementById('inputItemList'),
        discountTotal: document.getElementById('discountTotal'),
        taxTotal: document.getElementById('taxTotal'),
        paidAmount: document.getElementById('paidAmount'),
        paymentStatus: document.getElementById('paymentStatus'),
        paymentMethod: document.getElementById('paymentMethod'),
        paymentNote: document.getElementById('paymentNote'),
        footerMessage: document.getElementById('footerMessage'),
        
        // Receipt Preview Elements
        rLogo: document.getElementById('rLogo'),
        rStoreName: document.getElementById('rStoreName'),
        rStoreAddress: document.getElementById('rStoreAddress'),
        rDate: document.getElementById('rDate'),
        rNo: document.getElementById('rNo'),
        rItemsList: document.getElementById('rItemsList'),
        rSubTotal: document.getElementById('rSubTotal'),
        rDiscount: document.getElementById('rDiscount'),
        rDiscountRow: document.getElementById('rDiscountRow'),
        rTax: document.getElementById('rTax'),
        rTaxRow: document.getElementById('rTaxRow'),
        rGrandTotal: document.getElementById('rGrandTotal'),
        rPaymentStatus: document.getElementById('rPaymentStatus'),
        rPaid: document.getElementById('rPaid'),
        rChange: document.getElementById('rChange'),
        rPaymentNote: document.getElementById('rPaymentNote'),
        rFooterMessage: document.getElementById('rFooterMessage')
    };

    // Format Currency
    const formatRp = (num) => {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(num);
    };

    // Add Item Function
    function addItem() {
        const name = elements.newItemName.value.trim();
        const price = parseFloat(elements.newItemPrice.value);

        if (name && !isNaN(price)) {
            items.push({ name, price });
            elements.newItemName.value = '';
            elements.newItemPrice.value = '';
            elements.newItemName.focus();
            renderReceipt();
        }
    }

    // Remove Item Function
    function removeItem(index) {
        items.splice(index, 1);
        renderReceipt();
    }

    // Main Render Function
    function renderReceipt() {
        // Sync Basic Info
        elements.rStoreName.innerText = elements.storeName.value || 'GANTI NAMA TOKO';
        elements.rStoreAddress.innerText = elements.storeAddress.value || '';
        elements.rNo.innerText = elements.receiptNo.value || '#000';
        elements.rPaymentNote.innerText = elements.paymentNote.value;
        elements.rFooterMessage.innerText = elements.footerMessage.value;
        
        // Date Logic
        if (elements.dateMode.value === 'auto') {
            const now = new Date();
            elements.rDate.innerText = now.toLocaleString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' }).replace('.', ':');
        } else {
            const manualDate = new Date(elements.manualDateInput.value);
            if(!isNaN(manualDate)) {
                 elements.rDate.innerText = manualDate.toLocaleString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' }).replace('.', ':');
            }
        }

        // Render Items
        elements.inputItemList.innerHTML = '';
        elements.rItemsList.innerHTML = '';
        let subtotal = 0;

        items.forEach((item, index) => {
            subtotal += item.price;
            
            // Input List (With Delete Button)
            elements.inputItemList.innerHTML += `
                <div class="item-row">
                    <span>${item.name} - ${formatRp(item.price)}</span>
                    <button class="type="button" delete-btn" onclick="removeItem(${index})"><i class="fa-solid fa-trash"></i></button>
                </div>
            `;

            // Receipt Table
            elements.rItemsList.innerHTML += `
                <tr>
                    <td class="text-start">${item.name}</td>
                    <td class="text-end text-nowrap">${formatRp(item.price)}</td>
                </tr>
            `;
        });

        // Calculations
        const discount = parseFloat(elements.discountTotal.value) || 0;
        const tax = parseFloat(elements.taxTotal.value) || 0;
        const paid = parseFloat(elements.paidAmount.value) || 0;
        
        const grandTotal = subtotal - discount + tax;
        const change = paid - grandTotal;

        // Render Totals
        elements.rSubTotal.innerText = formatRp(subtotal);
        
        elements.rDiscount.innerText = '- ' + formatRp(discount);
        elements.rDiscountRow.style.display = discount > 0 ? 'flex' : 'none';
        
        elements.rTax.innerText = '+ ' + formatRp(tax);
        elements.rTaxRow.style.display = tax > 0 ? 'flex' : 'none';

        elements.rGrandTotal.innerText = formatRp(grandTotal);
        
        // Payment Info
        elements.rPaymentStatus.innerText = (elements.paymentStatus.value === 'LUNAS' ? elements.paymentMethod.value : 'DP / UTANG');
        elements.rPaid.innerText = formatRp(paid);
        elements.rChange.innerText = formatRp(change);
        
        // Change logic color
        elements.rChange.style.color = change < 0 ? 'red' : 'black';
    }

    // Download Image
    function downloadImage() {
        const element = document.getElementById("receiptPreview");
        html2canvas(element, { scale: 2 }).then(canvas => {
            const link = document.createElement("a");
            link.download = "Struk_" + elements.receiptNo.value + ".jpg";
            link.href = canvas.toDataURL("image/jpeg", 0.9);
            link.click();
        });
    }

    // Event Listeners
    const inputs = ['storeName', 'receiptNo', 'storeAddress', 'manualDateInput', 'paymentNote', 'footerMessage', 'discountTotal', 'taxTotal', 'paidAmount'];
    inputs.forEach(id => {
        document.getElementById(id).addEventListener('input', renderReceipt);
    });
    
    // Select listeners
    document.getElementById('dateMode').addEventListener('change', (e) => {
        document.getElementById('manualDateInput').classList.toggle('d-none', e.target.value === 'auto');
        renderReceipt();
    });
    document.getElementById('paymentStatus').addEventListener('change', renderReceipt);
    document.getElementById('paymentMethod').addEventListener('change', renderReceipt);

    // Image Upload
    elements.storeLogoInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                elements.rLogo.src = e.target.result;
                elements.rLogo.style.display = 'block';
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Initial Render
    renderReceipt();

    // --- Realtime Clock ---
    function updateClock() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        const timeStr = `${h}:${m}<span style="font-size:0.5em; color: #fff; vertical-align: top; margin-left:5px;">${s}</span>`;
        const dateStr = now.toLocaleDateString('id-ID', options);
        
        const smallClock = document.getElementById('realtimeClock');
        const bigClock = document.getElementById('bigRealtimeClock');
        const dateDisp = document.getElementById('currentDate');
        
        if(smallClock) smallClock.innerHTML = `${h}:${m} WIB`;
        if(bigClock) bigClock.innerHTML = timeStr;
        if(dateDisp) dateDisp.innerText = dateStr;
    }
    setInterval(updateClock, 1000);
    updateClock();
});
</script>

<style>
.bg-primary-gradient { background: var(--accent-gradient); border: none; }
</style>
