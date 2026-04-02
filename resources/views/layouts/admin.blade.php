<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - Lahad Enterprise</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="sidebar-logo">
                <i class="fas fa-leaf" style="color: var(--primary);"></i> Lahad Admin
                
                <div class="header-notifications" style="position: relative; margin-left: auto;">
                    <a href="#" class="icon-btn" onclick="document.getElementById('notif-dropdown').classList.toggle('show'); return false;" style="position:relative; color:#fff; font-size:1.2rem;">
                        <i class="fas fa-bell"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="badge" style="position:absolute; top:-5px; right:-5px; background:var(--orange); color:#fff; border-radius:50%; font-size:0.6rem; padding:0.15rem 0.35rem; width:18px; height:18px; display:flex; align-items:center; justify-content:center; box-shadow:0 0 0 2px var(--primary-dark);">{{ auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                    </a>
                    
                    <div id="notif-dropdown" class="dropdown-menu" style="display:none; position:absolute; top:40px; right:0; background:#fff; border-radius:12px; box-shadow:0 10px 40px rgba(0,0,0,0.15); width:320px; z-index:999; padding:0; overflow:hidden;">
                        <div style="padding: 1rem; background: #f8fafc; border-bottom: 1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
                            <strong style="color:var(--text); margin:0;">Notifications</strong>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <form action="{{ route('admin.notifications.readAll') }}" method="post" style="margin:0;">
                                    @csrf
                                    <button type="submit" style="background:none; border:none; color:var(--primary); font-size:0.8rem; cursor:pointer; padding:0;">Tout marquer lu</button>
                                </form>
                            @endif
                        </div>
                        <div style="max-height: 350px; overflow-y:auto; padding: 0.5rem 0;">
                            @forelse(auth()->user()->unreadNotifications as $notif)
                                <a href="{{ route('admin.notifications.read', $notif->id) }}" style="display:flex; gap:1rem; padding:0.75rem 1rem; text-decoration:none; border-bottom:1px solid #f1f5f9; transition: background 0.2s;">
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
                                    Vous êtes à jour !
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
                // CSS pour montrer/cacher le dropdown
                document.head.insertAdjacentHTML("beforeend", `<style>.dropdown-menu.show { display: block !important; }</style>`)
                // Fermer si on clique ailleurs
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.header-notifications')) {
                        document.getElementById('notif-dropdown').classList.remove('show');
                    }
                });
            </script>
            
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fas fa-box-open"></i> Produits
            </a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> Catégories
            </a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> Commandes
            </a>
            <a href="{{ route('admin.delivery_zones.index') }}" class="{{ request()->routeIs('admin.delivery_zones.*') ? 'active' : '' }}">
                <i class="fas fa-map-marker-alt"></i> Zones de Livraison
            </a>
            <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i> Messages
                @php
                    $unreadMessagesCount = \App\Models\ContactMessage::where('is_read', false)->count();
                @endphp
                @if($unreadMessagesCount > 0)
                    <span class="badge" style="background:#dc3545; color:#fff; border-radius:10px; margin-left:auto; font-size:0.75rem; padding:0.1rem 0.4rem;">{{ $unreadMessagesCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.broadcast.create') }}" class="{{ request()->routeIs('admin.broadcast.*') ? 'active' : '' }}">
                <i class="fas fa-bullhorn"></i> Diffuser Alerte
            </a>
            <div style="flex: 1;"></div>
            <a href="{{ route('home') }}" style="margin-top: 2rem;">
                <i class="fas fa-home"></i> Voir le site
            </a>
            <form action="{{ route('logout') }}" method="post" style="padding: 0; margin-top: 0.5rem;">
                @csrf
                <button type="submit" class="btn w-100" style="background: #fee2e2; color: #dc2626; border: none; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>
        </aside>
        <main class="admin-main">
            @include('partials.toasts')
            
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
