<aside id="sidebar"
  class="sidebar dashboard-sidebar fixed inset-y-0 left-0 z-50 w-72 -translate-x-full border-r border-white/10 bg-panel/95 px-6 py-8 backdrop-blur-xl transition-transform duration-300 lg:translate-x-0">
  <!-- Sidebar Header -->
  <div class="flex items-center justify-between">
    <div class="sidebar-brand">
      <img src="/lt/public/assets/img/logo_1.png" alt="Blue Extra Lotto" class="sidebar-brand-logo" />
      <div class="sidebar-brand-copy">
        <p class="font-display text-xs uppercase tracking-[0.35em] text-accent">Agent Side</p>
        <h1 class="mt-1 font-display text-2xl font-bold">Sales Desk</h1>
      </div>
    </div>
    <button id="closeSidebar"
      class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/10 text-xl text-ink/80 lg:hidden"
      type="button" aria-label="Close menu">
      ×
    </button>
  </div>

  <!-- Agent Badge -->
  <div class="mt-8 rounded-3xl border border-accent/20 bg-accent/10 p-4">
    <p class="text-xs uppercase tracking-[0.3em] text-accentSoft">Logged in as</p>
    <p id="agentSidebarName" class="mt-3 text-lg font-semibold text-ink">____</p>
    <!-- <p class="mt-2 text-sm leading-6 text-ink/80">Surulere outlet, Lagos</p> -->
  </div>

  <!-- Agent Navigation -->
  <nav class="mt-8 space-y-2">
    <a class="nav-link" href="/lt/agent">
      <span class="nav-link-label"><i data-lucide="layout-dashboard"></i><span>Dashboard</span></span>
    </a>
    <a class="nav-link" href="/lt/agent/lotto">
      <span class="nav-link-label"><i data-lucide="gamepad-2"></i><span>Play Lotto Game</span></span>
    </a>
    <a class="nav-link is-active" href="/lt/agent/cashback">
      <span class="nav-link-label"><i data-lucide="badge-dollar-sign"></i><span>Play Cash Back</span></span>
    </a>
    <a class="nav-link" href="/lt/agent/results">
      <span class="nav-link-label"><i data-lucide="scroll-text"></i><span>Results</span></span>
    </a>
    <a class="nav-link" href="/lt/agent/account">
      <span class="nav-link-label"><i data-lucide="wallet"></i><span>Account</span></span>
    </a>
  </nav>

  <!-- Logout -->
  <div class="mt-10 rounded-3xl border border-white/10 bg-white/5 p-5">
    <a href="/lt/agent/logout" class="cta-link">Logout</a>
  </div>
</aside>

<!-- Sidebar Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 z-40 hidden bg-black/50 backdrop-blur-sm lg:hidden"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const nameEl = document.getElementById('agentSidebarName');
    const storedAgent = localStorage.getItem('agent_profile');
    if (storedAgent && nameEl) {
        try {
            const agent = JSON.parse(storedAgent);
            const displayName =
                agent?.name ||
                agent?.full_name ||
                agent?.agent_name ||
                agent?.username ||
                agent?.email ||
                agent?.id ||
                'Agent';
            nameEl.textContent = displayName;
        } catch (error) {
            // ignore malformed storage
        }
    }
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
