<!-- Include jQuery dan Select2 jika belum -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.produk-select').select2({
            placeholder: "Pilih produk...",
            allowClear: true,
            width: '100%'
        });

        updateHargaDanSubtotal();
    });

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }

    function addProduk() {
        const produkItem = document.querySelector('.produk-item').cloneNode(true);

        produkItem.querySelectorAll('input').forEach(input => {
            input.value = '';
            input.removeAttribute('readonly');
            if (input.name === 'hargas[]' || input.name === 'subtotals[]') {
                input.setAttribute('readonly', true);
            }
        });

        const newSelect = produkItem.querySelector('select');
        newSelect.selectedIndex = 0;
        $(newSelect).select2({
            placeholder: "Cari produk...",
            allowClear: true,
            width: '100%'
        });

        document.getElementById('produk-container').appendChild(produkItem);
    }

    function removeProduk(button) {
        const item = button.closest('.produk-item');
        if (document.querySelectorAll('.produk-item').length > 1) {
            item.remove();
            updateHargaDanSubtotal();
        }
    }

    function updateHargaDanSubtotal() {
        const produkItems = document.querySelectorAll('.produk-item');
        let total = 0;

        produkItems.forEach(item => {
            const select = item.querySelector('select');
            const hargaInput = item.querySelector('input[name="hargas[]"]');
            const qtyInput = item.querySelector('input[name="quantities[]"]');
            const subtotalInput = item.querySelector('input[name="subtotals[]"]');

            const harga = parseInt(select.selectedOptions[0]?.dataset.harga || 0);
            const qty = parseInt(qtyInput.value || 0);
            const subtotal = harga * qty;

            hargaInput.value = harga;
            subtotalInput.value = subtotal;

            hargaInput.previousElementSibling?.remove();
            subtotalInput.previousElementSibling?.remove();

            const hargaLabel = document.createElement('div');
            hargaLabel.className = 'text-sm text-gray-600 mb-1';
            hargaLabel.textContent = formatRupiah(harga);
            hargaInput.parentNode.insertBefore(hargaLabel, hargaInput);

            const subtotalLabel = document.createElement('div');
            subtotalLabel.className = 'text-sm text-gray-600 mb-1';
            subtotalLabel.textContent = formatRupiah(subtotal);
            subtotalInput.parentNode.insertBefore(subtotalLabel, subtotalInput);

            total += subtotal;
        });

        const jumlahBayar = parseInt(document.getElementById('jumlah_bayar')?.value || 0);
        document.getElementById('total_bayar').value = total;
        document.getElementById('kembalian').value = jumlahBayar - total;

        document.getElementById('total_bayar')?.previousElementSibling?.remove();
        document.getElementById('kembalian')?.previousElementSibling?.remove();

        const totalLabel = document.createElement('div');
        totalLabel.className = 'text-sm text-gray-600 mb-1';
        totalLabel.textContent = formatRupiah(total);
        document.getElementById('total_bayar')?.parentNode.insertBefore(totalLabel, document.getElementById(
            'total_bayar'));

        const kembaliLabel = document.createElement('div');
        kembaliLabel.className = 'text-sm text-gray-600 mb-1';
        kembaliLabel.textContent = formatRupiah(jumlahBayar - total);
        document.getElementById('kembalian')?.parentNode.insertBefore(kembaliLabel, document.getElementById(
            'kembalian'));
    }

    document.addEventListener('input', updateHargaDanSubtotal);
    document.addEventListener('change', updateHargaDanSubtotal);
</script>
