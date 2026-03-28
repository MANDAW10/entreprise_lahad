<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Lahad Enterprise') - Viandes & Produits locaux</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    {{-- En-tête type AgriEasy : logo, recherche, lieu, icônes --}}
    <header class="site-header">
        <div class="container header-inner">
            <a href="{{ route('home') }}" class="logo">
                <span class="logo-icon"><i class="fas fa-leaf"></i></span>
                <span class="logo-text">Lahad Enterprise</span>
            </a>
            <form action="{{ route('products.index') }}" method="get" class="header-search" role="search">
                <i class="fas fa-search"></i>
                <input type="text" name="q" placeholder="Rechercher des produits, catégories..." value="{{ request('q') }}" aria-label="Recherche">
            </form>
            <div class="header-location">
                <i class="fas fa-map-marker-alt"></i>
                <span>Dakar, Sénégal</span>
            </div>
            <div class="header-icons">
                @auth
                <div class="header-notifications" style="position: relative; display: inline-block;">
                    <a href="#" class="icon-btn" onclick="document.getElementById('client-notif-dropdown').classList.toggle('show'); return false;" style="position:relative;" aria-label="Notifications">
                        <i class="fas fa-bell"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="cart-badge" style="background:#dc3545;">{{ auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                    </a>
                    
                    <div id="client-notif-dropdown" class="dropdown-menu" style="display:none; position:absolute; top:120%; right:-10px; background:#fff; border-radius:12px; box-shadow:0 10px 40px rgba(0,0,0,0.15); width:320px; z-index:999; padding:0; overflow:hidden; text-align:left;">
                        <div style="padding: 1rem; background: #f8fafc; border-bottom: 1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
                            <strong style="color:var(--text); margin:0;">Notifications</strong>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <form action="{{ route('account.notifications.readAll') }}" method="post" style="margin:0;">
                                    @csrf
                                    <button type="submit" style="background:none; border:none; color:var(--primary); font-size:0.8rem; cursor:pointer; padding:0;">Tout marquer lu</button>
                                </form>
                            @endif
                        </div>
                        <div style="max-height: 350px; overflow-y:auto; padding: 0.5rem 0;">
                            @forelse(auth()->user()->unreadNotifications as $notif)
                                <a href="{{ route('account.notifications.read', $notif->id) }}" style="display:flex; gap:1rem; padding:0.75rem 1rem; text-decoration:none; border-bottom:1px solid #f1f5f9; transition: background 0.2s;">
                                    <div style="background:var(--orange-light); color:var(--orange); width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                        <i class="fas {{ $notif->data['icon'] ?? 'fa-bell' }}"></i>
                                    </div>
                                    <div>
                                        <div style="color:var(--text); font-weight:600; font-size:0.9rem; line-height:1.3; margin-bottom:0.25rem;">{{ $notif->data['title'] }}</div>
                                        <div style="color:var(--text-muted); font-size:0.75rem;">{{ $notif->created_at->diffForHumans() }}</div>
                                    </div>
                                </a>
                            @empty
                                <div style="padding: 2rem; text-align:center; color:var(--text-muted); font-size:0.9rem;">
                                    <i class="fas fa-bell-slash" style="font-size:2rem; margin-bottom:1rem; opacity:0.3; display:block;"></i>
                                    Aucune notification
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <script>
                    document.head.insertAdjacentHTML("beforeend", `<style>.dropdown-menu.show { display: block !important; }</style>`);
                    document.addEventListener('click', function(e) {
                        if (!e.target.closest('.header-notifications')) {
                            const dropdown = document.getElementById('client-notif-dropdown');
                            if(dropdown) dropdown.classList.remove('show');
                        }
                    });
                </script>
                @else
                    <a href="{{ route('login') }}" class="icon-btn" title="Notifications" aria-label="Notifications"><i class="fas fa-bell"></i></a>
                @endauth
                <a href="{{ route('cart') }}" class="icon-btn cart-btn" aria-label="Panier">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge" id="cart-count">0</span>
                </a>
                @auth
                    <a href="{{ route('account.index') }}" class="icon-btn" title="Mon compte" aria-label="Compte"><i class="fas fa-user"></i></a>
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary">Admin</a>
                    @endif
                    <form action="{{ route('logout') }}" method="post" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="icon-btn" title="Connexion"><i class="fas fa-user"></i></a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-primary">Inscription</a>
                @endauth
                <!-- Mobile Menu Button -->
                <button class="icon-btn mobile-menu-toggle" aria-label="Menu" onclick="const nav=document.getElementById('main-nav'); nav.classList.toggle('mobile-open'); document.getElementById('mobile-menu-icon').className = nav.classList.contains('mobile-open') ? 'fas fa-times' : 'fas fa-bars';">
                    <i id="mobile-menu-icon" class="fas fa-bars"></i>
                </button>
            </div>
        </div>
        <nav class="main-nav" id="main-nav">
            <div class="container">
                <a href="{{ route('home') }}" class="main-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a>
                @auth
                    <a href="{{ route('account.orders') }}" class="main-nav-link {{ request()->routeIs('account.orders*') ? 'active' : '' }}">Mes Commandes</a>
                @else
                    <a href="{{ route('login') }}" class="main-nav-link">Mes Commandes</a>
                @endauth

                <a href="{{ route('products.index') }}" class="main-nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">Produits</a>
                <a href="{{ route('contact') }}" class="main-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
            </div>
        </nav>
    </header>

    @include('partials.toasts')

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            &copy; {{ date('Y') }} Lahad Enterprise — Viande poulet locale, caille, agneau, lait, yaourt, fromage, aliments bétail, poussins Goliath.
        </div>
    </footer>

    <script>
        (function() {
            var key = 'lahad_cart';
            function countCart() {
                try {
                    var data = JSON.parse(localStorage.getItem(key) || '[]');
                    var n = data.reduce(function(s, i) { return s + (i.quantity || 0); }, 0);
                    var el = document.getElementById('cart-count');
                    if (el) el.textContent = n;
                } catch (e) {}
            }
            countCart();
            window.addEventListener('storage', countCart);
            window.lahadCartCount = countCart;
        })();
    </script>
    <!-- Chatbot Assistant -->
    <div class="chatbot-wrapper">
        <div class="chatbot-window" id="chatbot-window">
            <div class="chatbot-header">
                <div class="chatbot-header-info">
                    <div class="chatbot-header-icon"><i class="fas fa-robot"></i></div>
                    <div>
                        <h3>Assistant AgriEasy</h3>
                        <p>Dakar, PK 15 • En ligne</p>
                    </div>
                </div>
                <button class="chatbot-close" onclick="toggleChat()" aria-label="Fermer"><i class="fas fa-times"></i></button>
            </div>
            <div class="chatbot-messages" id="chatbot-messages">
                <!-- Les messages s'afficheront ici -->
            </div>
        </div>
        <button class="chatbot-toggle" onclick="toggleChat()" aria-label="Ouvrir le chat">
            <i class="fas fa-comment-dots" id="chat-toggle-icon"></i>
        </button>
    </div>

    <script>
        // Chatbot Logic
        const chatWindow = document.getElementById('chatbot-window');
        const chatMessages = document.getElementById('chatbot-messages');
        const chatToggleIcon = document.getElementById('chat-toggle-icon');
        let chatInitialized = false;

        const botData = {
            greeting: "Bonjour ! 😊 Bienvenue chez Lahad Enterprise. Comment puis-je vous aider aujourd'hui ?",
            options: [
                { text: "Quels produits vendez-vous ?", reply: "Nous offrons des produits frais agricoles :\n- 🍗 Viande de volaille et caille\n- 🥩 Viande d'agneau\n- 🥛 Produits laitiers (lait frais, yaourt, fromage)\n- 🌾 Aliments pour bétail." },
                { text: "Où se trouve votre ferme ?", reply: "📍 Notre ferme se trouve sur la Route des Niayes, Km 15 à Dakar, Sénégal.\nNous sommes ouverts du Lundi au Samedi de 8h à 18h." },
                { text: "Comment passer commande ?", reply: "C'est très simple ! Parcourez notre catalogue en cliquant sur 'Produits', ajoutez ce qu'il vous faut au panier et validez votre commande. Paiement facile à la livraison ou via mobile money." },
                { text: "Parler à un humain", reply: "📞 Vous pouvez nous appeler directement au +221 77 000 00 00 ou utiliser notre <a href='{{ route('contact') }}' style='color:var(--orange);font-weight:bold;text-decoration:underline;'>Formulaire de contact</a>." }
            ]
        };

        function toggleChat() {
            chatWindow.classList.toggle('open');
            if (chatWindow.classList.contains('open')) {
                chatToggleIcon.classList.remove('fa-comment-dots');
                chatToggleIcon.classList.add('fa-times');
                if (!chatInitialized) {
                    appendBotMessage(botData.greeting);
                    appendOptions();
                    chatInitialized = true;
                }
            } else {
                chatToggleIcon.classList.remove('fa-times');
                chatToggleIcon.classList.add('fa-comment-dots');
            }
        }

        function appendBotMessage(text) {
            const msg = document.createElement('div');
            msg.className = 'chat-msg bot';
            msg.innerHTML = text.replace(/\n/g, '<br>');
            chatMessages.appendChild(msg);
            scrollChat();
        }

        function appendUserMessage(text) {
            const msg = document.createElement('div');
            msg.className = 'chat-msg user';
            msg.textContent = text;
            chatMessages.appendChild(msg);
            scrollChat();
        }

        function appendOptions() {
            const container = document.createElement('div');
            container.className = 'chat-quick-replies';
            botData.options.forEach(opt => {
                const btn = document.createElement('button');
                btn.className = 'chat-quick-reply';
                btn.textContent = opt.text;
                btn.onclick = () => {
                    container.remove();
                    appendUserMessage(opt.text);
                    let typingMsg = document.createElement('div');
                    typingMsg.className = 'chat-msg bot';
                    typingMsg.innerHTML = '<i class="fas fa-ellipsis-h" style="opacity:0.5; font-size:1.2rem; animation: pulse 1s infinite;"></i>';
                    chatMessages.appendChild(typingMsg);
                    scrollChat();

                    setTimeout(() => {
                        typingMsg.remove();
                        appendBotMessage(opt.reply);
                        setTimeout(appendOptions, 800);
                    }, 800);
                };
                container.appendChild(btn);
            });
            chatMessages.appendChild(container);
            scrollChat();
        }

        function scrollChat() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        
        // --- Dynamic Global Toast ---
        window.showToast = function(message, type = 'success') {
            let container = document.getElementById('toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                container.className = 'toast-container';
                document.body.appendChild(container);
            }
            
            const toast = document.createElement('div');
            toast.className = 'toast-message toast-' + type;
            let icon = type === 'success' ? 'fa-check-circle' : (type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle');
            
            toast.innerHTML = `
                <i class="fas ${icon}"></i>
                <div class="toast-content">${message}</div>
                <button class="toast-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            `;
            
            container.appendChild(toast);
            
            setTimeout(() => {
                if(toast.parentElement) {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-20px) scale(0.95)';
                    setTimeout(() => { if(toast.parentElement) toast.remove(); }, 300);
                }
            }, 4000);
        };
    </script>
    @stack('scripts')
</body>
</html>
