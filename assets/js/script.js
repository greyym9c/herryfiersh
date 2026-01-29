/* Main Script */

document.addEventListener('DOMContentLoaded', () => {
    // Shared Logic: Rupiah Formatter
    const rupiahInputs = document.querySelectorAll('.format-rupiah');
    rupiahInputs.forEach(input => {
        input.addEventListener('keyup', function (e) {
            this.value = formatRupiah(this.value, 'Rp. ');
        });
    });
});

/* --- Utilities --- */
function formatRupiah(angka, prefix) {
    let number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
}

function cleanRupiah(uang) {
    return parseInt(uang.replace(/[^0-9]/g, '')) || 0;
}

/* --- Barcode Page --- */
function initBarcodePage() {
    const inputs = ['barcodeValue', 'barcodeFormat', 'barcodeWidth', 'barcodeHeight', 'displayValue'];
    inputs.forEach(id => {
        document.getElementById(id).addEventListener('input', generateBarcode);
        document.getElementById(id).addEventListener('change', generateBarcode);
    });

    // Initial generation
    generateBarcode();
}

function generateBarcode() {
    const value = document.getElementById('barcodeValue').value;
    const format = document.getElementById('barcodeFormat').value;
    const width = document.getElementById('barcodeWidth').value;
    const height = document.getElementById('barcodeHeight').value;
    const displayValue = document.getElementById('displayValue').checked;

    if (!value) return;

    try {
        JsBarcode("#barcode", value, {
            format: format === 'CODE128' ? undefined : format, // undefined defaults to CODE128 auto
            width: parseInt(width),
            height: parseInt(height),
            displayValue: displayValue,
            lineColor: "#000",
            background: "#fff",
            margin: 10
        });
    } catch (e) {
        // Handle invalid input for format
        console.error("Barcode generation error", e);
    }
}

function downloadBarcode() {
    const svg = document.getElementById('barcode');
    const serializer = new XMLSerializer();
    const source = serializer.serializeToString(svg);

    // Create a canvas to convert SVG to PNG
    const canvas = document.createElement("canvas");
    const img = new Image();

    // Convert SVG to base64
    const svg64 = btoa(source);
    const b64Start = 'data:image/svg+xml;base64,';
    const image64 = b64Start + svg64;

    img.onload = function () {
        canvas.width = img.width;
        canvas.height = img.height;
        const ctx = canvas.getContext("2d");
        ctx.fillStyle = "#fff"; // Background
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0);

        const a = document.createElement("a");
        a.download = "barcode.png";
        a.href = canvas.toDataURL("image/png");
        a.click();
    };
    img.src = image64;
}

/* --- Gold Page --- */
function initGoldPage() {
    // Inputs are already processed by shared Formatters, 
    // we just need the calculation function trigger via button
}

function calculateGold() {
    const weight = parseFloat(document.getElementById('goldWeight').value) || 0;
    const buyPrice = cleanRupiah(document.getElementById('buyPrice').value);
    const currentPrice = cleanRupiah(document.getElementById('currentPrice').value);

    const totalModal = weight * buyPrice;
    const totalValue = weight * currentPrice;
    const profit = totalValue - totalModal;

    // Formatting
    document.getElementById('totalModal').innerText = formatRupiah(totalModal.toString(), 'Rp. ');
    document.getElementById('totalValue').innerText = formatRupiah(totalValue.toString(), 'Rp. ');

    const profitElement = document.getElementById('profitLoss');
    const percentageElement = document.getElementById('percentage');

    profitElement.innerText = formatRupiah(profit.toString(), 'Rp. ');

    // Color logic
    if (profit > 0) {
        profitElement.style.color = '#4ade80'; // Green
        percentageElement.style.background = 'rgba(74, 222, 128, 0.2)';
        percentageElement.style.color = '#4ade80';
    } else if (profit < 0) {
        profitElement.style.color = '#f87171'; // Red
        percentageElement.style.background = 'rgba(248, 113, 113, 0.2)';
        percentageElement.style.color = '#f87171';
    } else {
        profitElement.style.color = 'white';
        percentageElement.style.background = 'rgba(255, 255, 255, 0.1)';
        percentageElement.style.color = 'white';
    }

    // Percentage
    let percent = 0;
    if (totalModal > 0) {
        percent = ((profit / totalModal) * 100).toFixed(2);
    }
    percentageElement.innerText = (profit >= 0 ? '+' : '') + percent + '%';
}

/* --- Receipt Page --- */
let receiptItems = [];

function initReceiptPage() {
    // Initial Render (Empty)
    updateReceipt();
}

function updateReceipt() {
    // Info
    document.getElementById('rStoreName').innerText = document.getElementById('storeName').value;
    document.getElementById('rStoreAddress').innerText = document.getElementById('storeAddress').value;
    document.getElementById('rNo').innerText = document.getElementById('receiptNo').value;

    // Items
    const tbody = document.getElementById('rItems');
    tbody.innerHTML = '';

    let total = 0;
    receiptItems.forEach((item, index) => {
        total += item.price;
        const row = `
            <tr>
                <td style="padding: 5px 0;">${item.name}</td>
                <td style="padding: 5px 0; text-align: right;">${formatRupiah(item.price.toString(), 'Rp')}</td>
            </tr>
        `;
        tbody.innerHTML += row;
    });

    document.getElementById('rTotal').innerText = formatRupiah(total.toString(), 'Rp ');

    // Also update the edit list
    const listDiv = document.getElementById('itemsList');
    listDiv.innerHTML = '';
    receiptItems.forEach((item, index) => {
        const div = document.createElement('div');
        div.style.cssText = 'display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.05); padding: 0.5rem; border-radius: 4px;';
        div.innerHTML = `
            <span style="font-size: 0.9rem;">${item.name} - ${formatRupiah(item.price.toString(), 'Rp')}</span>
            <button onclick="removeItem(${index})" style="background: var(--text-secondary); color: white; border: none; padding: 2px 6px; border-radius: 4px; cursor: pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        `;
        listDiv.appendChild(div);
    });
}

function addItem() {
    const name = document.getElementById('itemName').value;
    const price = parseInt(document.getElementById('itemPrice').value) || 0;

    if (name && price) {
        receiptItems.push({ name, price });
        document.getElementById('itemName').value = '';
        document.getElementById('itemPrice').value = '';
        updateReceipt();
    }
}

function removeItem(index) {
    receiptItems.splice(index, 1);
    updateReceipt();
}

/* --- Zakat Page --- */
function initZakatPage() {
    // Listeners are inline in HTML for simplicity or add here
}

function calcZakatProfesi() {
    const income = cleanRupiah(document.getElementById('income').value);
    const bonus = cleanRupiah(document.getElementById('bonus').value);
    const totalMonth = income + bonus;

    // Nishab Zakat Penghasilan (Analogous to 85gr gold / year approx 85jt / 12 = ~7jt/month)
    // Using a simplistic static threshold for demo.
    const nishab = 7000000;

    let zakat = 0;
    const info = document.getElementById('nishabInfo');

    if (totalMonth >= nishab) {
        zakat = totalMonth * 0.025;
        info.innerHTML = `<span style="color: #4ade80;">Wajib Zakat</span>. Penghasilan Anda di atas Nishab (Rp 7.000.000).`;
    } else {
        info.innerHTML = `<span style="color: var(--text-secondary);">Belum Wajib Zakat</span>. Penghasilan di bawah Nishab.`;
    }

    document.getElementById('zakatResult').innerText = formatRupiah(zakat.toString(), 'Rp ');
}

function calcZakatMal() {
    const savings = cleanRupiah(document.getElementById('savings').value);
    const gold = cleanRupiah(document.getElementById('goldValue').value);
    const assets = cleanRupiah(document.getElementById('assets').value);
    const debts = cleanRupiah(document.getElementById('debts').value);

    const netWorth = (savings + gold + assets) - debts;

    // Nishab Zakat Mal (85gr Emas x 1.000.000 approx = 85.000.000 per year)
    const nishab = 85000000;

    let zakat = 0;
    const info = document.getElementById('nishabInfo');

    if (netWorth >= nishab) {
        zakat = netWorth * 0.025;
        info.innerHTML = `<span style="color: #4ade80;">Wajib Zakat</span>. Harta Bersih Anda di atas Nishab (Rp 85.000.000).`;
    } else {
        info.innerHTML = `<span style="color: var(--text-secondary);">Belum Wajib Zakat</span>. Harta bersih di bawah Nishab.`;
    }

    document.getElementById('zakatResult').innerText = formatRupiah(zakat.toString(), 'Rp ');
}
