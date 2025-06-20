<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Montserrat:wght@600&family=Poppins:wght@700&display=swap');
        body {
            background: #f5f5f5 !important;
            font-family: 'Poppins', Arial, sans-serif;
            font-size: 10px;
        }
        .order-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 0 32px rgba(0,0,0,0.10);
            padding: 36px 24px;
            margin: 48px auto;
            max-width: 540px;
            width: 100%;
        }
        .section-card {
            border: 1.5px solid #f0f0f0;
            border-radius: 12px;
            padding: 22px 18px 12px 18px;
            margin-bottom: 32px;
            background: #fff;
        }
        .section-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #A67C52;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .form-label {
            color: #A67C52;
            font-weight: 600;
            font-size: 1rem;
        }
        .input-group-text {
            background: #f9f9f9;
            color: #A67C52;
            border: none;
            font-size: 1.1rem;
        }
        input.form-control, select.form-select, textarea.form-control {
            border-radius: 0.7rem !important;
            background: #f9f9f9 !important;
            border: 1px solid #e0e0e0 !important;
            color: #333;
            font-size: 1.08rem;
            padding: 0.9rem 0.9rem 0.9rem 2.5rem;
            transition: border 0.2s, box-shadow 0.2s;
        }
        input.form-control:focus, select.form-select:focus, textarea.form-control:focus {
            border-color: #A67C52 !important;
            box-shadow: 0 0 0 2px #FFD70022;
            outline: none;
        }
        input::placeholder, textarea::placeholder {
            color: #bdbdbd !important;
            opacity: 1;
        }
        select.form-select {
            height: 48px !important;
        }
        textarea.form-control {
            min-height: 48px;
            height: auto;
            resize: vertical;
        }
        .btn-primary {
            background: #A67C52 !important;
            color: #fff !important;
            border: none !important;
            border-radius: 0.7rem !important;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 0.9rem 2.5rem;
            transition: background 0.2s, transform 0.2s;
            letter-spacing: 0.03em;
        }
        .btn-primary:hover {
            background: #FFD700 !important;
            color: #A67C52 !important;
            transform: scale(1.03);
        }
        .btn-outline-secondary {
            border-radius: 0.7rem !important;
            font-weight: 600;
            padding: 0.9rem 2.5rem;
            font-size: 1.1rem;
        }
        .summary-card {
            background: #f8fafc;
            border-radius: 10px;
            padding: 18px 16px;
            margin-bottom: 24px;
            font-size: 1rem;
            color: #333;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
        }
        @media (max-width: 600px) {
            .order-card { padding: 14px 4px; max-width: 98vw; }
            .btn-primary, .btn-outline-secondary { width: 100%; margin-bottom: 10px; }
        }
        .order-title {
            font-weight: 800;
            font-size: 2.1rem;
            color: #A67C52;
            margin-bottom: 30px;
            text-align: center;
            letter-spacing: 0.5px;
            background: #fff7ed;
            border-radius: 1.2rem 1.2rem 0 0;
            padding: 24px 0 18px 0;
            box-shadow: 0 2px 8px #a67c5222;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
        }
        .order-title i {
            font-size: 2.2rem;
            color: #A67C52;
        }
    </style>
    
    <div class="container">
        <div class="order-card">
            <h1 class="order-title">
                <i class="bi bi-receipt-cutoff"></i>
                Form Pemesanan
            </h1>
            <form action="{{ route('orders.store') }}" method="POST" id="orderForm" novalidate>
                @csrf
    
                <!-- Identitas Pelanggan -->
                <div class="section-card">
                    <div class="section-title"><i class="bi bi-person-circle"></i> Identitas Pelanggan</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="customer_name" class="form-label">Nama Lengkap *</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" required placeholder="cth: John Doe">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="customer_phone" class="form-label">Nomor HP/WA *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required placeholder="08xxxxxxxxxx">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="customer_email" class="form-label">Email (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="customer_email" name="customer_email" placeholder="cth: nama@email.com">
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Detail Pesanan -->
                <div class="section-card">
                    <div class="section-title"><i class="bi bi-basket3"></i> Detail Pesanan</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="menu_item" class="form-label">Menu *</label>
                            <select class="form-select" id="menu_item" name="menu_item_id" required>
                                <option value="">-- Pilih Menu --</option>
                                @foreach($menus as $menu)
                                    <option value="{{ $menu->id }}" data-image="{{ $menu->image_url }}">{{ $menu->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Jumlah *</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" required placeholder="1">
                        </div>
                    </div>
                </div>
    
                <!-- Tipe Order & Pembayaran -->
                <div class="section-card">
                    <div class="section-title"><i class="bi bi-credit-card"></i> Tipe & Pembayaran</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="order_type" class="form-label">Tipe Order *</label>
                            <select name="order_type" id="order_type" class="form-select" required onchange="toggleOrderFields()">
                                <option value="">Pilih Tipe Order</option>
                                <option value="dine-in">Dine-in</option>
                                <option value="takeaway">Takeaway</option>
                                <option value="delivery">Delivery</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="payment_method" class="form-label">Metode Pembayaran *</label>
                            <select name="payment_method" id="payment_method" class="form-select" required>
                                <option value="">Pilih Metode</option>
                                <option value="cash">Cash</option>
                                <option value="qris">QRIS</option>
                                <option value="transfer">Transfer</option>
                                <option value="ewallet">E-wallet</option>
                            </select>
                        </div>
                        <div class="col-12" id="table_number_field" style="display:none;">
                            <label for="table_number" class="form-label">Nomor Meja</label>
                            <input type="text" class="form-control" id="table_number" name="table_number" placeholder="Nomor meja (jika dine-in)">
                        </div>
                        <div class="col-12" id="address_field" style="display:none;">
                            <label for="address" class="form-label">Alamat Pengantaran</label>
                            <textarea class="form-control" id="address" name="address" rows="2" placeholder="Alamat lengkap"></textarea>
                        </div>
                    </div>
                </div>
    
                <!-- Biaya Tambahan -->
                <div class="section-card">
                    <div class="section-title"><i class="bi bi-cash-coin"></i> Biaya Tambahan</div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="discount" class="form-label">
                                Diskon (Rp)
                                <span data-bs-toggle="tooltip" title="Potongan harga dalam rupiah">
                                    <i class="bi bi-info-circle"></i>
                                </span>
                            </label>
                            <input type="number" class="form-control" id="discount" name="discount" min="0" value="0" placeholder="0">
                        </div>
                        <div class="col-md-4">
                            <label for="tax_percent" class="form-label">
                                Pajak (%)
                                <span data-bs-toggle="tooltip" title="Persentase pajak dari subtotal">
                                    <i class="bi bi-info-circle"></i>
                                </span>
                            </label>
                            <input type="number" class="form-control" id="tax_percent" name="tax_percent" min="0" value="10" placeholder="0">
                        </div>
                        <div class="col-md-4">
                            <label for="service_charge" class="form-label">
                                Service Charge
                                <span data-bs-toggle="tooltip" title="Biaya layanan tambahan">
                                    <i class="bi bi-info-circle"></i>
                                </span>
                            </label>
                            <input type="number" class="form-control" id="service_charge" name="service_charge" min="0" value="0" placeholder="0">
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label for="queue_number" class="form-label">Nomor Antrian</label>
                            <input type="number" class="form-control" id="queue_number" name="queue_number" min="1" placeholder="Nomor urut">
                        </div>
                    </div>
                </div>
    
                <!-- Catatan -->
                <div class="section-card">
                    <div class="section-title"><i class="bi bi-chat-left-text"></i> Catatan</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="notes" class="form-label">Catatan Pesanan</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Catatan untuk seluruh pesanan"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="item_notes" class="form-label">Catatan Khusus per Item</label>
                            <textarea class="form-control" id="item_notes" name="item_notes" placeholder="Catatan untuk menu tertentu"></textarea>
                        </div>
                    </div>
                </div>
    
                <!-- Summary Pesanan (Bonus UX) -->
                <div class="summary-card" id="orderSummary" style="display:none;">
                    <div class="summary-row"><span><b>Menu:</b></span> <span id="summaryMenu"></span></div>
                    <div class="summary-row"><span><b>Jumlah:</b></span> <span id="summaryQty"></span></div>
                    <div class="summary-row"><span><b>Subtotal:</b></span> <span id="summarySubtotal"></span></div>
                    <div class="summary-row"><span><b>Diskon:</b></span> <span id="summaryDiscount"></span></div>
                    <div class="summary-row"><span><b>Pajak:</b></span> <span id="summaryTax"></span></div>
                    <div class="summary-row"><span><b>Service Charge:</b></span> <span id="summaryService"></span></div>
                    <div class="summary-row" style="font-size:1.1em;"><span><b>Total:</b></span> <span id="summaryTotal"></span></div>
                </div>
    
                <div class="d-flex flex-wrap justify-content-end mt-4 gap-2">
                    <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="bi bi-printer"></i> Cetak Struk
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="bi bi-send-check"></i> Pesan Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
    function toggleOrderFields() {
        var type = document.getElementById('order_type').value;
        document.getElementById('table_number_field').style.display = (type === 'dine-in') ? 'block' : 'none';
        document.getElementById('address_field').style.display = (type === 'delivery') ? 'block' : 'none';
    }
    document.addEventListener('DOMContentLoaded', function() {
        toggleOrderFields();
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
    </script>
    <script>
    $(document).ready(function() {
        // Select2 untuk menu (jika ingin gambar)
        function formatState (state) {
            if (!state.id) return state.text;
            var img = $(state.element).data('image');
            if(img) {
                return $('<span><img src="'+img+'" style="width:30px; margin-right:10px;"/> ' + state.text + '</span>');
            }
            return state.text;
        }
        $('#menu_item').select2({
            templateResult: formatState,
            templateSelection: formatState,
            width: '100%'
        });
    
        // Loading effect on submit
        $('#orderForm').on('submit', function() {
            $('#submitBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Mengirim...');
        });
    
        // Bonus: Preview summary pesanan (dummy, bisa dihubungkan ke backend)
        $('#menu_item, #quantity, #discount, #tax_percent, #service_charge').on('change keyup', function() {
            // Dummy data, ganti dengan perhitungan backend jika perlu
            let menu = $('#menu_item option:selected').text();
            let qty = $('#quantity').val();
            let price = 20000; // contoh harga
            let subtotal = price * qty;
            let discount = parseInt($('#discount').val() || 0);
            let tax = parseInt($('#tax_percent').val() || 0);
            let service = parseInt($('#service_charge').val() || 0);
            let pajak = ((subtotal - discount) * tax / 100);
            let total = subtotal - discount + pajak + service;
            $('#summaryMenu').text(menu);
            $('#summaryQty').text(qty);
            $('#summarySubtotal').text('Rp ' + subtotal.toLocaleString());
            $('#summaryDiscount').text('Rp ' + discount.toLocaleString());
            $('#summaryTax').text('Rp ' + pajak.toLocaleString());
            $('#summaryService').text('Rp ' + service.toLocaleString());
            $('#summaryTotal').text('Rp ' + total.toLocaleString());
            $('#orderSummary').show();
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    </x-app-layout>