<?php include_once('includes/head.php'); ?>

<body class="min-h-screen bg-shell font-body text-ink" data-page="agent-account">
  <div class="dashboard-shell relative min-h-screen overflow-hidden">
    <div class="pointer-events-none absolute inset-0 opacity-90">
      <div class="hero-glow hero-glow-a"></div>
      <div class="hero-glow hero-glow-b"></div>
      <div class="grid-fade"></div>
    </div>

    <div class="relative z-10 flex min-h-screen">
      <?php include_once('includes/sidebar.php'); ?>

      <main class="dashboard-main flex-1 px-4 py-4 sm:px-6 lg:px-8 lg:py-8">
        <div class="mx-auto max-w-7xl">
          <?php include_once('includes/header.php'); ?>

          <header class="topbar-offset rounded-[2rem] border border-white/10 bg-white/5 px-6 py-5 shadow-panel backdrop-blur-xl">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Agent Account</p>
                <h1 class="mt-2 font-display text-3xl font-bold">Wallet overview</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-muted">
                  Track your current balance and recent ticket activity.
                </p>
              </div>
              <span class="status-pill">Balance</span>
            </div>
          </header>

          <section class="mt-6 grid gap-4 md:grid-cols-2">
            <article class="stat-card">
              <p class="stat-label">Current Balance</p>
              <h3 id="agentWalletBalance" class="stat-value">N 0</h3>
              <p class="stat-meta text-accentSoft">Available for play</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Total Bets</p>
              <h3 id="agentWalletBets" class="stat-value">0</h3>
              <p class="stat-meta text-accent">All time</p>
            </article>
          </section>

          <section class="mt-6 table-card">
            <div class="flex flex-col gap-3 border-b border-white/10 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Recent Tickets</p>
                <h2 class="mt-2 font-display text-2xl font-bold">Latest transactions</h2>
              </div>
              <span class="status-pill">Wallet History</span>
            </div>
            <div class="table-wrap">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Ticket</th>
                    <th>Game</th>
                    <th>Stake</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody id="agentAccountHistory"></tbody>
              </table>
            </div>
          </section>

          <?php include_once('includes/footer.php'); ?>
        </div>
      </main>
    </div>
  </div>

  <?php include_once('includes/scripts.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    (function () {
      const basePath = "/lt/";
      const balanceEl = document.getElementById("agentWalletBalance");
      const betCountEl = document.getElementById("agentWalletBets");
      const historyBody = document.getElementById("agentAccountHistory");

      function formatCurrency(value) {
        return `N ${Number(value || 0).toLocaleString()}`;
      }

      function readCookie(name) {
        const match = document.cookie.split("; ").find((row) => row.startsWith(`${name}=`));
        return match ? decodeURIComponent(match.split("=")[1]) : "";
      }

      async function loadAccount() {
        const storedAgent = localStorage.getItem("agent_profile");
        let agentProfile = null;
        if (storedAgent) {
          try {
            agentProfile = JSON.parse(storedAgent);
          } catch (error) {
            agentProfile = null;
          }
        }
        const agentId = agentProfile?.id || readCookie("agent_id");

        if (!agentId) {
          if (balanceEl) balanceEl.textContent = "N 0";
          return;
        }

        try {
          const [agentRes, betsRes, txnRes] = await Promise.all([
            axios.get(`${basePath}api/agent/get-by-id`, { params: { agent_id: agentId } }),
            axios.get(`${basePath}api/bet/by-agent`, { params: { agent_id: agentId } }),
            axios.get(`${basePath}api/agent/transactions`, { params: { agent_id: agentId } })
          ]);
          const message = agentRes?.data?.message;
          const agent = Array.isArray(message)
            ? message[0]
            : (message && message.id ? message : message?.[0]);
          const bets = Array.isArray(betsRes?.data?.message) ? betsRes.data.message : [];
          const txns = Array.isArray(txnRes?.data?.message) ? txnRes.data.message : [];

          if (balanceEl) balanceEl.textContent = formatCurrency(agent?.balance || 0);
          if (betCountEl) betCountEl.textContent = String(bets.length);
          if (agent) {
            localStorage.setItem("agent_profile", JSON.stringify(agent));
          }

          renderHistory(txns);
        } catch {
          if (balanceEl) {
            const fallbackBalance = agentProfile?.balance || 0;
            balanceEl.textContent = formatCurrency(fallbackBalance);
          }
          renderHistory([]);
        }
      }

      function renderHistory(txns) {
        if (!historyBody) return;
        if (!txns.length) {
          historyBody.innerHTML = `
            <tr>
              <td colspan="4">
                <div class="empty-state empty-state--compact py-6">
                  <i data-lucide="wallet"></i>
                  <p class="text-lg font-semibold text-ink">No transactions yet</p>
                </div>
              </td>
            </tr>
          `;
          if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons();
          }
          return;
        }

        historyBody.innerHTML = txns.slice(0, 10).map((txn) => `
          <tr>
            <td data-label="Ticket">${txn.reference || "-"}</td>
            <td data-label="Game">${(txn.note || txn.type || "").toString()}</td>
            <td data-label="Stake">${formatCurrency(txn.amount || 0)}</td>
            <td data-label="Date">${txn.created_at ? new Date(txn.created_at).toLocaleString("en-NG") : "N/A"}</td>
          </tr>
        `).join("");
      }

      loadAccount();
    })();
  </script>
</body>

</html>
