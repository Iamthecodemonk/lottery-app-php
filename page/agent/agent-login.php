<?php include_once('includes/head.php'); ?>
<body class="min-h-screen bg-shell font-body text-ink">
  <div class="auth-shell relative min-h-screen overflow-hidden">
    <!-- Background Effects -->
    <div class="pointer-events-none absolute inset-0 opacity-90">
      <div class="hero-glow hero-glow-a"></div>
      <div class="hero-glow hero-glow-b"></div>
      <div class="grid-fade"></div>
    </div>

    <!-- Agent Login Layout -->
    <div class="relative z-10 mx-auto flex min-h-screen max-w-7xl items-center px-4 py-8 sm:px-6 lg:px-8">
      <div class="grid w-full gap-8 lg:grid-cols-[1.05fr_0.95fr]">
        <!-- Agent Intro Panel -->
        <section
          class="flex flex-col justify-between rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-panel backdrop-blur-xl sm:p-8 lg:min-h-[720px]">
          <div>
            <!-- Brand Block -->
            <div class="inline-flex items-center gap-4 rounded-2xl border border-white/10 bg-panel/60 px-4 py-3">
              <img src="/lt/public/assets/img/logo_1.png" alt="Blue Extra Lotto" class="h-14 w-auto object-contain" />
              <div>
                <p class="font-display text-xs uppercase tracking-[0.35em] text-accent">
                  Blue Extra Lotto
                </p>
                <p class="mt-1 text-sm text-muted">Agent sales access</p>
              </div>
            </div>

            <!-- Hero Copy -->
            <div class="mt-10 max-w-xl">
              <p class="text-sm uppercase tracking-[0.35em] text-accentSoft">
                Agent portal
              </p>
              <h1 class="mt-4 font-display text-4xl font-bold leading-tight sm:text-5xl">
                Sell tickets, serve customers, and track daily lotto activity.
              </h1>
              <p class="mt-5 text-base leading-7 text-muted">
                Built for field agents and shop operators handling customer entries, ticket
                issuance, sales records, and result checks.
              </p>
            </div>

            <!-- Quick Stats -->
            <div class="mt-10 grid gap-4 sm:grid-cols-3">
              <article class="auth-stat">
                <p class="auth-stat-label">Role</p>
                <p class="auth-stat-value">Agent</p>
              </article>
              <article class="auth-stat">
                <p class="auth-stat-label">Focus</p>
                <p class="auth-stat-value">Sales</p>
              </article>
              <article class="auth-stat">
                <p class="auth-stat-label">Access</p>
                <p class="auth-stat-value">Daily Ops</p>
              </article>
            </div>
          </div>

          <!-- Access Note -->
          <div class="mt-10 rounded-[1.75rem] border border-accent/20 bg-accent/10 p-5">
            <p class="text-sm uppercase tracking-[0.3em] text-accentSoft">Agent tools</p>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-ink/80">
              Next we can design the agent dashboard separately with ticket sales, result checks,
              wallet balance, and customer play history.
            </p>
          </div>
        </section>

        <!-- Agent Form Panel -->
        <section class="flex items-center">
          <div
            class="auth-card w-full rounded-[2rem] border border-white/10 bg-panel/90 p-6 shadow-panel backdrop-blur-xl sm:p-8">
            <!-- Form Heading -->
            <div class="max-w-md">
              <p class="text-sm uppercase tracking-[0.35em] text-muted">Agent access</p>
              <h2 class="mt-3 font-display text-3xl font-bold">Sign in to start selling</h2>
              <p class="mt-3 text-sm leading-6 text-muted">
                Enter your agent credentials to access the dedicated lotto sales dashboard.
              </p>
            </div>

            <!-- Login Form -->
            <form id="agentLoginForm" class="mt-8 space-y-5">
              <div id="agentLoginError"
                class="auth-banner auth-banner--error hidden rounded-2xl border p-3 text-sm">
                Unable to sign in. Please check your credentials.
              </div>
              <div>
                <label class="auth-label" for="agent-id">Agent ID</label>
                <input id="agent-id" name="agent-id" type="text" placeholder="Enter your agent ID" class="auth-input" />
              </div>

              <div>
                <label class="auth-label" for="agent-email">Email</label>
                <input id="agent-email" name="agent-email" type="email" placeholder="Enter your email"
                  class="auth-input" />
              </div>

              <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <label class="inline-flex items-center gap-3 text-sm text-muted">
                  <input type="checkbox"
                    class="h-4 w-4 rounded border-white/20 bg-transparent text-accent focus:ring-accent" />
                  Keep me signed in
                </label>
                <!--<a href="/lt/public/index.html" class="text-sm font-medium text-accentSoft transition hover:text-accentBright">-->
                <!--  Back to portal selection-->
                <!--</a>-->
              </div>

              <button id="agentLoginButton" type="submit" class="auth-button">Sign In As Agent</button>
            </form>
          </div>
        </section>
      </div>
    </div>
  </div>
  <script src="/lt/public/assets/js/app.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    (function () {
      const form = document.getElementById('agentLoginForm');
      const errorBox = document.getElementById('agentLoginError');
      const submitBtn = document.getElementById('agentLoginButton');
      const basePath = '/lt/';

      if (!form) return;

      function setLoading(isLoading) {
        if (!submitBtn) return;
        submitBtn.disabled = isLoading;
        submitBtn.textContent = isLoading ? 'Signing in...' : 'Sign In As Agent';
      }

      function showError(message, tone = "error") {
        if (!errorBox) return;
        errorBox.textContent = message || 'Unable to sign in. Please check your credentials.';
        errorBox.classList.remove('auth-banner--error', 'auth-banner--warning');
        errorBox.classList.add(tone === 'warning' ? 'auth-banner--warning' : 'auth-banner--error');
        errorBox.classList.remove('hidden');
      }

      form.addEventListener('submit', async function (event) {
        event.preventDefault();
        if (errorBox) errorBox.classList.add('hidden');

        const agentId = document.getElementById('agent-id')?.value?.trim() || '';
        const email = document.getElementById('agent-email')?.value?.trim() || '';

        if (!agentId || !email) {
          showError('Please enter both Agent ID and email.');
          return;
        }

        setLoading(true);

        try {
          const response = await axios.post(`${basePath}api/agent/login`, {
            agent_id: agentId,
            email: email
          });

          const payload = response?.data || {};
          if (!payload?.state) {
            const message = payload?.message || 'Invalid agent credentials.';
            const tone = /suspend/i.test(message) ? 'warning' : 'error';
            showError(message, tone);
            return;
          }

          if (payload?.message?.token) {
            localStorage.setItem('agent_token', payload.message.token);
          }
          if (payload?.message?.agent) {
            localStorage.setItem('agent_profile', JSON.stringify(payload.message.agent));
          }

          window.location.href = `${basePath}agent`;
        } catch (error) {
          const serverMessage = error?.response?.data?.message;
          const tone = /suspend/i.test(serverMessage || '') ? 'warning' : 'error';
          showError(serverMessage || 'Unable to sign in. Please check your credentials.', tone);
        } finally {
          setLoading(false);
        }
      });
    })();
  </script>
</body>

</html>
