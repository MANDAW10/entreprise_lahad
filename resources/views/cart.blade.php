@extends('layouts.app')

@section('title', 'Panier')

@section('content')
    <div class="container">
    <h1 class="page-title">Panier</h1>
    <div id="cart-content">
        <p>Chargement...</p>
    </div>
    <div id="cart-checkout" style="display: none;">
        <div class="cart-layout">
            <div class="cart-items-col">
                <h2 style="margin: 0 0 1rem;">Articles</h2>
                <div id="cart-items-list"></div>
            </div>
            <aside class="cart-sidebar">
                <h3>Résumé de facturation</h3>
                <div class="summary-row"><span>Sous-total</span><span id="summary-subtotal">0 CFA</span></div>
                <div class="summary-row"><span>Frais de livraison</span><span id="summary-shipping">500 CFA</span></div>
                <div class="summary-row summary-total"><span>Total à payer</span><span id="cart-total">0 CFA</span></div>

                <h3 style="margin-top: 1.5rem; margin-bottom: 1rem;">Paiement Sécurisé</h3>
                <div class="payment-methods-grid" style="grid-template-columns: 1fr;">
                    <label class="payment-card payment-wave selected" style="cursor: default;">
                        <input type="radio" name="payment_method_choice" value="wave" checked class="d-none">
                        <div class="payment-icon">
                            <svg width="28" height="28" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                <rect width="200" height="200" rx="50" fill="#1cbbff"/>
                                <path d="M40 120 C 65 120 80 75 100 75 C 120 75 135 120 160 120" stroke="white" stroke-width="24" stroke-linecap="round" fill="none"/>
                            </svg>
                        </div>
                        <span class="payment-name">Wave Business</span>
                        <div class="payment-check"><i class="fas fa-check-circle"></i></div>
                    </label>
                </div>

                <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--border);">
                    <h3 style="margin: 0 0 0.75rem;">Coordonnées et livraison</h3>
                    <div class="form-group">
                        <label>Nom complet</label>
                        <input type="text" id="customer_name" class="form-control" value="{{ auth()->user()->name ?? '' }}" placeholder="Votre nom">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="customer_email" class="form-control" value="{{ auth()->user()->email ?? '' }}" placeholder="email@exemple.com">
                    </div>
                    <div class="form-group">
                        <label>Téléphone</label>
                        <input type="text" id="customer_phone" class="form-control" value="{{ auth()->user()->phone ?? '' }}" placeholder="Optionnel">
                    </div>
                    <div class="form-group">
                        <label>Adresse de livraison</label>
                        <textarea id="shipping_address" class="form-control" placeholder="Adresse complète">{{ auth()->user()->address ?? '' }}</textarea>
                    </div>
                    <button type="submit" form="checkout-form" class="btn btn-primary w-100">Valider la commande</button>
                    @guest
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.5rem;">
                            <a href="{{ route('register') }}">Créer un compte</a> ou <a href="{{ route('login') }}">se connecter</a> pour retrouver vos commandes.
                        </p>
                    @endguest
                </div>
            </aside>
        </div>

        <form id="checkout-form" style="display:none;" action="{{ route('order.store') }}" method="post">
            @csrf
            <input type="hidden" name="items" id="items-input">
            <input type="hidden" name="customer_name" id="customer_name_h">
            <input type="hidden" name="customer_email" id="customer_email_h">
            <input type="hidden" name="customer_phone" id="customer_phone_h">
            <input type="hidden" name="shipping_address" id="shipping_address_h">
            <input type="hidden" name="payment_method" id="payment_method" value="wave">
            <input type="hidden" name="payment_phone" id="payment_phone_h">
            <input type="hidden" name="transaction_id" id="transaction_id_h">
        </form>
    <!-- Payment Modal -->
    <div class="payment-modal-overlay" id="payment-modal">
        <div class="payment-modal theme-wave" id="payment-modal-content">
            <div class="payment-modal-header">
                <button type="button" class="close-btn" id="close-payment-modal">&times;</button>
                <div class="payment-modal-icon" id="payment-modal-icon" style="background: transparent; box-shadow: none;">
                    <svg width="60" height="60" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" style="box-shadow: 0 8px 24px rgba(28,187,255,0.4); border-radius: 16px;">
                        <rect width="200" height="200" rx="50" fill="#1cbbff"/>
                        <path d="M40 120 C 65 120 80 75 100 75 C 120 75 135 120 160 120" stroke="white" stroke-width="24" stroke-linecap="round" fill="none"/>
                    </svg>
                </div>
                <h3 class="payment-modal-title" id="payment-modal-title">Paiement avec Wave Business</h3>
                <p class="payment-modal-subtitle" id="payment-modal-subtitle">Veuillez suivre les instructions ci-dessous</p>
            </div>
            
            <div class="payment-modal-body">
                <div class="form-group" id="wave-instructions" style="text-align:center; margin-bottom: 2rem;">
                    <p style="font-weight: 600; font-size: 1.1rem; color: #1cbbff; margin-bottom: 0.2rem;">Vous allez être redirigé confimer l'achat de :</p>
                    <p><span id="modal-amount-display" style="font-size: 1.8rem; font-weight: 800; color: var(--text);">0 CFA</span></p>
                    <p style="font-size: 0.95rem; color: var(--text-muted); margin-top: 0.5rem;">Cliquez sur le bouton ci-dessous pour valider votre commande et ouvrir l'application Wave (au 78 357 74 31).</p>
                </div>

                <button type="button" class="btn btn-confirm w-100" id="confirm-payment-btn" style="margin-top: 1rem; padding: 1rem; font-size: 1.1rem; border-radius: 12px; font-weight: 700;">
                    <i class="fas fa-mobile-alt" style="margin-right: 0.5rem;"></i> Valider la commande et Payer
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
(function() {
    var key = 'lahad_cart';
    var SHIPPING = 500;
    function loadCart() {
        var cart = [];
        try { cart = JSON.parse(localStorage.getItem(key) || '[]'); } catch (e) {}
        var content = document.getElementById('cart-content');
        var checkout = document.getElementById('cart-checkout');
        var listEl = document.getElementById('cart-items-list');
        var totalEl = document.getElementById('cart-total');
        var subtotalEl = document.getElementById('summary-subtotal');
        if (!cart.length) {
            content.innerHTML = '<div class="empty-state"><div class="empty-state-icon"><i class="fas fa-shopping-basket"></i></div><h2>Votre panier est vide</h2><p>Découvrez nos produits frais locaux et remplissez votre panier avec ce qu\'il y a de meilleur.</p><a href="{{ route("products.index") }}" class="btn btn-primary" style="padding: 0.9rem 2rem; font-size: 1.1rem; border-radius: 12px; font-weight: 700; box-shadow: 0 8px 20px rgba(232, 93, 4, 0.25);">Parcourir les produits</a></div>';
            if (checkout) checkout.style.display = 'none';
            return;
        }
        content.innerHTML = '';
        if (checkout) checkout.style.display = 'block';
        var total = 0;
        var html = '';
        cart.forEach(function(item) {
            var lineTotal = item.price * item.quantity;
            total += lineTotal;
            html += '<div class="cart-item-card" data-id="' + item.id + '">';
            html += '<div class="item-thumb-placeholder">Img</div>';
            html += '<div class="item-info">';
            html += '<div class="item-name">' + (item.name || '') + ' - ' + (item.unit || '') + '</div>';
            html += '<p class="item-farm">Lahad Enterprise</p>';
            html += '<span class="item-price">' + (item.price || 0) + ' CFA</span>';
            html += '<div class="item-qty" style="margin-top: 0.5rem;">';
            html += '<button type="button" class="qty-btn qty-minus" data-id="' + item.id + '">−</button>';
            html += '<span class="qty-value">' + (item.quantity || 0) + '</span>';
            html += '<button type="button" class="qty-btn orange qty-plus" data-id="' + item.id + '" data-stock="' + (item.stock || 999) + '">+</button>';
            html += '</div></div>';
            html += '<div class="item-total">' + Math.round(lineTotal) + ' CFA</div>';
            html += '<button type="button" class="item-remove remove-cart" data-id="' + item.id + '" title="Retirer"><i class="fas fa-trash-alt"></i></button>';
            html += '</div>';
        });
        if (listEl) listEl.innerHTML = html;
        var grandTotal = total + SHIPPING;
        if (totalEl) totalEl.textContent = Math.round(grandTotal) + ' CFA';
        if (subtotalEl) subtotalEl.textContent = Math.round(total) + ' CFA';
        document.getElementById('items-input').value = JSON.stringify(cart.map(function(i) { return { product_id: i.id, quantity: i.quantity }; }));
        syncHiddenFields();
        document.querySelectorAll('.remove-cart').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id = this.dataset.id;
                cart = cart.filter(function(i) { return String(i.id) !== String(id); });
                localStorage.setItem(key, JSON.stringify(cart));
                if (window.lahadCartCount) window.lahadCartCount();
                loadCart();
            });
        });
        document.querySelectorAll('.qty-minus').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id = this.dataset.id;
                var i = cart.findIndex(function(x) { return String(x.id) === String(id); });
                if (i >= 0 && cart[i].quantity > 1) { cart[i].quantity--; localStorage.setItem(key, JSON.stringify(cart)); loadCart(); }
            });
        });
        document.querySelectorAll('.qty-plus').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id = this.dataset.id, stock = parseInt(this.dataset.stock, 10) || 999;
                var i = cart.findIndex(function(x) { return String(x.id) === String(id); });
                if (i >= 0 && cart[i].quantity < stock) { cart[i].quantity++; localStorage.setItem(key, JSON.stringify(cart)); loadCart(); }
            });
        });
    }
    function syncHiddenFields() {
        var n = document.getElementById('customer_name'), e = document.getElementById('customer_email'), p = document.getElementById('customer_phone'), a = document.getElementById('shipping_address');
        var nh = document.getElementById('customer_name_h'), eh = document.getElementById('customer_email_h'), ph = document.getElementById('customer_phone_h'), ah = document.getElementById('shipping_address_h');
        if (nh && n) nh.value = n.value;
        if (eh && e) eh.value = e.value;
        if (ph && p) ph.value = p.value;
        if (ah && a) ah.value = a.value;
    }
    loadCart();

    document.querySelectorAll('.payment-card').forEach(function(lbl) {
        lbl.addEventListener('click', function() {
            document.querySelectorAll('.payment-card').forEach(function(b) { b.classList.remove('selected'); });
            this.classList.add('selected');
            var val = this.querySelector('input').value;
            document.getElementById('payment_method').value = val;
        });
    });

    // Payment Modal Logic
    var paymentModal = document.getElementById('payment-modal');
    var paymentModalContent = document.getElementById('payment-modal-content');
    var closePaymentModalBtn = document.getElementById('close-payment-modal');
    var confirmPaymentBtn = document.getElementById('confirm-payment-btn');
    var formDataCache = null;

    function closePaymentModal() {
        paymentModal.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (closePaymentModalBtn) closePaymentModalBtn.addEventListener('click', closePaymentModal);
    
    if (confirmPaymentBtn) {
        confirmPaymentBtn.addEventListener('click', function() {
            // Lock UI
            paymentModalContent.classList.add('loading');
            
            // Set dummy hidden fields to bypass validation cleanly
            var dummyPhone = "Non renseigné";
            var dummyTxId = "En attente";
            
            document.getElementById('payment_phone_h').value = dummyPhone;
            document.getElementById('transaction_id_h').value = dummyTxId;
            
            // Update FormData cache
            formDataCache.set('payment_phone', dummyPhone);
            formDataCache.set('transaction_id', dummyTxId);
            
            // Open Wave Link in a new tab immediately
            var amountToPay = document.getElementById('cart-total').textContent;
            var numericAmount = amountToPay.replace(/[^0-9]/g, '');
            // TODO: REMPLACER 'M_VOTRE_CODE' PAR VOTRE VRAI ID MARCHAND WAVE !
            var waveUrl = "https://pay.wave.com/m/M_VOTRE_CODE/amount/?amount=" + numericAmount;
            window.open(waveUrl, '_blank');

            // Submit logic
            fetch(form.action, { method: 'POST', body: formDataCache, headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    paymentModalContent.classList.remove('loading');
                    if (data.redirect) {
                        localStorage.removeItem(key);
                        if (window.lahadCartCount) window.lahadCartCount();
                        window.location.href = data.redirect;
                    } else {
                        showToast(data.message || 'Erreur lors de la validation.', 'error');
                    }
                })
                .catch(function() { 
                    paymentModalContent.classList.remove('loading');
                    showToast('Erreur serveur, veuillez réessayer.', 'error'); 
                });
        });
    }

    var form = document.getElementById('checkout-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            var name = (document.getElementById('customer_name') && document.getElementById('customer_name').value.trim()) || '';
            var email = (document.getElementById('customer_email') && document.getElementById('customer_email').value.trim()) || '';
            var address = (document.getElementById('shipping_address') && document.getElementById('shipping_address').value.trim()) || '';
            if (!name || !email || !address) { showToast('Veuillez remplir nom, email et adresse de livraison.', 'error'); return; }
            syncHiddenFields();
            
            document.getElementById('customer_name_h').value = name;
            document.getElementById('customer_email_h').value = email;
            document.getElementById('customer_phone_h').value = (document.getElementById('customer_phone') && document.getElementById('customer_phone').value) || '';
            document.getElementById('shipping_address_h').value = address;
            var payInput = document.querySelector('input[name="payment_method_choice"]:checked');
            var selectedMethod = payInput ? payInput.value : 'wave';
            document.getElementById('payment_method').value = selectedMethod;
            
            formDataCache = new FormData(form);

            // Setup and show modal based on method
            var amountToPay = document.getElementById('cart-total').textContent;
            document.getElementById('modal-amount-display').textContent = amountToPay;
            
            var modalTitle = document.getElementById('payment-modal-title');
            var modalIcon = document.getElementById('payment-modal-icon');
            var waveInstructions = document.getElementById('wave-instructions');
            var omInstructions = document.getElementById('om-instructions');
            
            paymentModalContent.className = 'payment-modal'; // reset
            if (selectedMethod === 'wave') {
                paymentModalContent.classList.add('theme-wave');
                modalTitle.textContent = 'Paiement avec Wave Business';
                modalIcon.innerHTML = '<i class="fas fa-water"></i>';
                if(waveInstructions) waveInstructions.style.display = 'block';
            }
            
            document.body.style.overflow = 'hidden';
            paymentModal.classList.add('active');
        });
    }
})();
</script>
@endpush
