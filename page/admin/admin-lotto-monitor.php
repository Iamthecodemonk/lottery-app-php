<?php include_once('includes/head.php'); ?>

<body class="min-h-screen bg-shell font-body text-ink" data-page="admin-lotto-monitor">
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
                  <p class="text-sm uppercase tracking-[0.35em] text-muted">Admin Monitor</p>
                  <h1 class="mt-2 font-display text-3xl font-bold">Lotto Game Monitoring</h1>
                  <p class="mt-3 max-w-2xl text-sm leading-6 text-muted">
                    Oversight screen for lotto games played by agents, with monitoring grouped around agent activity.
                  </p>
                </div>
                <span class="status-pill">Agent Sorted</span>
              </div>
            </header>

          <section class="mt-6 grid gap-4 md:grid-cols-2">
            <article class="stat-card">
              <p class="stat-label">Games Played</p>
              <h3 id="adminLottoGamesPlayed" class="stat-value">0</h3>
              <p class="stat-meta text-accent">Across all agents</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Amount Earned</p>
              <h3 id="adminLottoAmountEarned" class="stat-value">N 0</h3>
              <p class="stat-meta text-accentSoft">Total monitored stake value</p>
            </article>
          </section>

          <section class="mt-6 table-card">
            <div
              class="flex flex-col gap-3 border-b border-white/10 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Agent Lotto Activity</p>
                <h2 class="mt-2 font-display text-2xl font-bold">Sorted by agent</h2>
              </div>
              <span class="status-pill">Lotto Play</span>
            </div>
            <div class="table-wrap">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Agent</th>
                    <th>Agent Code</th>
                    <th>Outlet</th>
                    <th>Ticket</th>
                    <th>Games Played</th>
                    <th>Amount Earned</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody id="adminLottoMonitorTableBody"></tbody>
              </table>
            </div>
            <div id="lottoPagination" class="mt-6 flex flex-wrap items-center justify-between gap-3"></div>
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
      const tableBody = document.getElementById("adminLottoMonitorTableBody");
      const paginationEl = document.getElementById("lottoPagination");
      const pageSize = 10;
      let currentPage = 1;
      let allRows = [];

      function formatCurrency(value) {
        return `N ${Number(value || 0).toLocaleString()}`;
      }

      function formatDate(value) {
        const date = new Date(value);
        if (Number.isNaN(date.getTime())) {
          return "N/A";
        }
        return date.toLocaleString("en-NG", {
          day: "numeric",
          month: "short",
          year: "numeric",
          hour: "numeric",
          minute: "2-digit"
        });
      }

      function renderRows(rows) {
        if (!tableBody) {
          return;
        }

        if (!rows.length) {
          tableBody.innerHTML = `
            <tr>
              <td colspan="7">
                <div class="empty-state empty-state--compact py-10">
                  <i data-lucide="gamepad-2"></i>
                  <p class="text-lg font-semibold text-ink">No lotto play records yet</p>
                  <p class="mt-3 text-sm leading-6 text-muted">
                    Agent lotto play transactions will appear here once agents start submitting games.
                  </p>
                </div>
              </td>
            </tr>
          `;
          if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons();
          }
          return;
        }

        tableBody.innerHTML = rows
          .map(
            (entry) => `
              <tr>
                <td data-label="Agent">${entry.agentName || "Agent"}</td>
                <td data-label="Agent Code">${entry.agentCode || entry.agentId || "AGENT"}</td>
                <td data-label="Outlet">${entry.outlet || "Outlet"}</td>
                <td data-label="Ticket">${entry.ticketCode || entry.betId || "N/A"}</td>
                <td data-label="Games Played">${entry.totalGames}</td>
                <td data-label="Amount Earned">${formatCurrency(entry.totalStakeAmount)}</td>
                <td data-label="Date">${formatDate(entry.playedAt)}</td>
              </tr>
            `
          )
          .join("");
      }

      function renderPagination() {
        if (!paginationEl) {
          return;
        }

        const totalPages = Math.max(1, Math.ceil(allRows.length / pageSize));
        if (currentPage > totalPages) {
          currentPage = totalPages;
        }

        const start = (currentPage - 1) * pageSize;
        const end = start + pageSize;
        const visibleRows = allRows.slice(start, end);

        renderRows(visibleRows);

        paginationEl.innerHTML = `
          <div class="text-sm text-muted">
            Showing ${allRows.length ? start + 1 : 0}-${Math.min(end, allRows.length)} of ${allRows.length}
          </div>
          <div class="flex flex-wrap items-center gap-2">
            <button type="button" class="action-button action-button-soft" data-page-action="prev" ${currentPage === 1 ? "disabled" : ""}>
              Prev
            </button>
            <span class="text-sm text-ink">Page ${currentPage} of ${totalPages}</span>
            <button type="button" class="action-button action-button-soft" data-page-action="next" ${currentPage === totalPages ? "disabled" : ""}>
              Next
            </button>
          </div>
        `;
      }

      paginationEl?.addEventListener("click", (event) => {
        const button = event.target.closest("[data-page-action]");
        if (!button) {
          return;
        }
        const action = button.getAttribute("data-page-action");
        if (action === "prev" && currentPage > 1) {
          currentPage -= 1;
        }
        if (action === "next") {
          const totalPages = Math.max(1, Math.ceil(allRows.length / pageSize));
          if (currentPage < totalPages) {
            currentPage += 1;
          }
        }
        renderPagination();
      });

      function updateStats(summary) {
        const gamesEl = document.getElementById("adminLottoGamesPlayed");
        const amountEl = document.getElementById("adminLottoAmountEarned");
        if (gamesEl) {
          gamesEl.textContent = String(summary.totalGamesPlayed);
        }
        if (amountEl) {
          amountEl.textContent = formatCurrency(summary.totalAmountEarned);
        }
      }

      async function loadLottoBets() {
        try {
          const response = await axios.get(`${basePath}api/bet/with-details`);
          const bets = Array.isArray(response?.data?.message) ? response.data.message : [];

          const rows = bets
            .filter((bet) => String(bet.game_category || "").toLowerCase() === "lotto")
            .map((bet) => {
              const outlet = [bet.agent_email, bet.agent_phone].filter(Boolean).join(" • ") || "Agent";
              const placedAt = bet.bet_placed_at || bet.placed_at || Date.now();
              const totalGames = Number(bet.bet_total_games_played ?? bet.total_games_played ?? 1);
              const totalStakeAmount = Number.parseFloat(bet.bet_stake_amount ?? bet.stake_amount ?? 0);

              return {
                betId: bet.bet_id || bet.id,
                ticketCode: bet.bet_id || bet.id,
                agentId: bet.bet_agent_id || bet.agent_id || "",
                agentName: bet.agent_name || bet.bet_agent_id || "Agent",
                agentCode: bet.bet_agent_id || bet.agent_id || "AGENT",
                outlet,
                totalGames,
                totalStakeAmount,
                playedAt: placedAt
              };
            });

          const summary = {
            totalGamesPlayed: rows.reduce((sum, entry) => sum + Number(entry.totalGames || 0), 0),
            totalAmountEarned: rows.reduce((sum, entry) => sum + Number(entry.totalStakeAmount || 0), 0),
            rows
          };

          updateStats(summary);
          allRows = summary.rows;
          currentPage = 1;
          renderPagination();
        } catch (error) {
          updateStats({ totalGamesPlayed: 0, totalAmountEarned: 0 });
          allRows = [];
          currentPage = 1;
          renderPagination();
        }
      }

      loadLottoBets();
    })();
  </script>
</body>

</html>
