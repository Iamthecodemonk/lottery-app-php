<!-- Sidebar (JS-only active-link handling) -->
<aside id="sidebar"
    class="sidebar dashboard-sidebar fixed inset-y-0 left-0 z-50 w-72 -translate-x-full border-r border-white/10 bg-panel/95 px-6 py-8 backdrop-blur-xl transition-transform duration-300 lg:translate-x-0">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between">
        <div class="sidebar-brand">
            <img src="/lt/public/assets/img/logo_1.png" alt="Blue Extra Lotto" class="sidebar-brand-logo" />
            <div class="sidebar-brand-copy">
                <p class="font-display text-xs uppercase tracking-[0.35em] text-accent">Admin Side</p>
                <h1 class="mt-1 font-display text-2xl font-bold">Control Room</h1>
            </div>
        </div>
        <button id="closeSidebar"
            class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/10 text-xl text-ink/80 lg:hidden"
            type="button" aria-label="Close menu">×</button>
    </div>

    <!-- Admin Badge -->
    <div class="mt-8 rounded-3xl border border-accent/20 bg-accent/10 p-4">
        <p class="text-xs uppercase tracking-[0.3em] text-accentSoft">Control Level</p>
        <p class="mt-3 text-lg font-semibold text-ink">Platform Admin</p>
        <p class="mt-2 text-sm leading-6 text-ink/80">Head office operations</p>
    </div>

    <!-- Admin Navigation -->
    <nav class="mt-8 space-y-2">
        <a class="nav-link" href="https://blueextralotto.com/lt/admin">
            <span class="nav-link-label"><i data-lucide="layout-dashboard"></i><span>Dashboard</span></span>
        </a>
        <a class="nav-link" href="/lt/admin/agentsmanagement">
            <span class="nav-link-label"><i data-lucide="users"></i><span>Agent Management</span></span>
        </a>
        <a class="nav-link" href="/lt/admin/results">
            <span class="nav-link-label"><i data-lucide="trophy"></i><span>Publish Results</span></span>
        </a>
        <a class="nav-link" href="/lt/admin/games">
            <span class="nav-link-label"><i data-lucide="dice-5"></i><span>Manage Games</span></span>
        </a>
        <a class="nav-link" href="/lt/admin/bettypes">
            <span class="nav-link-label"><i data-lucide="layers-3"></i><span>Bet Types</span></span>
        </a>
        <a class="nav-link" href="/lt/admin/sales">
            <span class="nav-link-label"><i data-lucide="receipt-text"></i><span>Agent Sales</span></span>
        </a>
        <a class="nav-link" href="/lt/admin/account">
            <span class="nav-link-label"><i data-lucide="wallet"></i><span>Accounts</span></span>
        </a>
        <a class="nav-link" href="/lt/admin/lottomonitor">
            <span class="nav-link-label"><i data-lucide="gamepad-2"></i><span>Lotto Monitor</span></span>
        </a>
        <a class="nav-link" href="/lt/admin/cashbackmonitor">
            <span class="nav-link-label"><i data-lucide="badge-dollar-sign"></i><span>Cash Back Monitor</span></span>
        </a>
    </nav>

    <!-- Back Link -->
    <div class="mt-10 rounded-3xl border border-white/10 bg-white/5 p-5">
        <a href="/lt/admin/logout" class="cta-link">Logout</a>
    </div>
</aside>
<!-- Sidebar Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 z-40 hidden bg-black/50 backdrop-blur-sm lg:hidden"></div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const path = location.pathname.replace(/^\/|\/$/g, '');
    const parts = path.split('/').filter(Boolean);
    const last = parts.length ? parts[parts.length - 1] : '';
    document.querySelectorAll('.nav-link').forEach(function (a) {
        const href = (a.getAttribute('href') || '').replace(/^\/|\/$/g, '');
        if (!href) return;
        if (href === path || href === last || path.indexOf(href) !== -1) {
            a.classList.add('is-active');
        } else {
            a.classList.remove('is-active');
        }
    });
});
</script>
