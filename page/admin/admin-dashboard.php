<?php include_once('includes/head.php'); ?>

<body class="min-h-screen bg-shell font-body text-ink" data-page="admin-dashboard">
  <div class="dashboard-shell relative min-h-screen overflow-hidden">
    <!-- Background Effects -->
    <div class="pointer-events-none absolute inset-0 opacity-90">
      <div class="hero-glow hero-glow-a"></div>
      <div class="hero-glow hero-glow-b"></div>
      <div class="grid-fade"></div>
    </div>

    <div class="relative z-10 flex min-h-screen">
      <!-- Sidebar -->
      <?php include_once('includes/sidebar.php'); ?>

      <!-- Main Content -->
      <main class="dashboard-main flex-1 px-4 py-4 sm:px-6 lg:px-8 lg:py-8">
        <div class="mx-auto max-w-7xl">
          <!-- Sticky Header -->
          <?php include_once('includes/header.php'); ?>
                      <!-- Top Header -->
            <header class="topbar-offset rounded-[2rem] border border-white/10 bg-white/5 px-5 py-4 shadow-panel backdrop-blur-xl sm:px-6">
              <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-start gap-3">
                  <div>
                    <p class="text-sm uppercase tracking-[0.35em] text-muted">Admin Dashboard</p>
                    <h2 class="mt-2 font-display text-3xl font-bold sm:text-4xl">Platform overview</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-muted sm:text-base">
                      Central oversight for agents, draw operations, reports, and overall lotto platform activity.
                    </p>
                  </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                  <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.3em] text-muted">Live Draw</p>
                    <p id="adminCurrentDraw" class="mt-2 text-xl font-semibold text-accentSoft">Evening Draw</p>
                  </div>
                  <div class="rounded-2xl border border-white/10 bg-accent/10 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.3em] text-accent/80">Active Agents</p>
                    <p class="mt-2 text-xl font-semibold text-accent"><span id="adminOpenAgents">214</span> Online</p>
                  </div>
                </div>
              </div>
            </header>

          <!-- Admin Stats -->
          <section class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <article class="stat-card">
              <p class="stat-label">Total Sales Today</p>
              <h3 id="adminTotalSales" class="stat-value">0</h3>
              <p class="stat-meta text-accent">Across all outlets</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Open Agents</p>
              <h3 id="adminOpenAgentsCard" class="stat-value">0</h3>
              <p class="stat-meta text-accentSoft">Currently transacting</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Pending Settlements</p>
              <h3 id="adminPendingSettlements" class="stat-value">0</h3>
              <p class="stat-meta text-accentBright">Requires review</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Total Games Created</p>
              <h3 id="adminTotalGamesCard" class="stat-value">0</h3>
              <p class="stat-meta text-accentSoft">All published & draft games</p>
            </article>
          </section>

          <!-- Admin Primary Panels -->
          <section class="mt-6 grid gap-6 xl:grid-cols-[1.25fr_0.75fr]">
            <!-- Control Panels -->
            <article class="panel-card">
              <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                  <p class="text-sm uppercase tracking-[0.35em] text-muted">Operational Control</p>
                  <h3 class="mt-2 font-display text-2xl font-bold">Admin quick actions</h3>
                </div>
                <p class="max-w-md text-sm leading-6 text-muted">
                  The admin dashboard is built for oversight, decision-making, and platform-level coordination.
                </p>
              </div>

              <div class="mt-6 grid gap-4 md:grid-cols-2">
                <div class="soft-card">
                  <p class="text-sm font-semibold text-ink">Control actions</p>
                  <div class="mt-4 flex flex-wrap gap-3">
                    <a class="chip" href="/lt/admin/results">Publish Result</a>
                    <a class="chip" href="/lt/admin/games">Manage Games</a>
                    <a class="chip" href="/lt/admin/agents">Manage agents</a>
                  </div>
                </div>
                <div class="metric-band">
                  <p class="text-sm uppercase tracking-[0.28em] text-accentSoft">Platform Status</p>
                  <p class="mt-3 text-2xl font-bold text-ink">Stable and processing</p>
                  <p class="mt-3 text-sm leading-6 text-muted">
                    Draw publication, ticket flow, and agent transactions are currently healthy.
                  </p>
                </div>
              </div>
            </article>

            <!-- Admin Feed -->
            <aside class="panel-card">
              <p class="text-sm uppercase tracking-[0.35em] text-muted">Operations Feed</p>
              <div class="mt-5 space-y-4">
                <div class="feed-item animate-pulse">
                  <span class="feed-dot bg-white/20"></span>
                  <div class="w-full">
                    <div class="h-3 w-3/4 rounded-full bg-white/10"></div>
                    <div class="mt-3 h-2 w-5/6 rounded-full bg-white/5"></div>
                  </div>
                </div>
                <div class="feed-item animate-pulse">
                  <span class="feed-dot bg-white/20"></span>
                  <div class="w-full">
                    <div class="h-3 w-2/3 rounded-full bg-white/10"></div>
                    <div class="mt-3 h-2 w-4/5 rounded-full bg-white/5"></div>
                  </div>
                </div>
                <div class="feed-item animate-pulse">
                  <span class="feed-dot bg-white/20"></span>
                  <div class="w-full">
                    <div class="h-3 w-1/2 rounded-full bg-white/10"></div>
                    <div class="mt-3 h-2 w-3/4 rounded-full bg-white/5"></div>
                  </div>
                </div>
              </div>
            </aside>
          </section>

          <!-- Latest Results -->
          <section class="mt-6 panel-card">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Latest Results</p>
                <h3 class="mt-2 font-display text-2xl font-bold">Recently published draws</h3>
              </div>
              <a href="./admin-results.html" class="cta-link">Open publish results page</a>
            </div>
            <div id="adminLatestResults" class="mt-6 stack-grid"></div>
          </section>

          <!-- Agents Table -->
          <section class="mt-6 table-card">
            <div
              class="flex flex-col gap-3 border-b border-white/10 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Agent Monitoring</p>
                <h3 class="mt-2 font-display text-2xl font-bold">Agent performance snapshot</h3>
              </div>
              <span class="status-pill">Admin View</span>
            </div>

            <div class="table-wrap">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Agent</th>
                    <th>Email</th>
                    <th>Sales</th>
                    <th>Total Games</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="animate-pulse">
                    <td data-label="Agent">
                      <div class="h-3 w-3/4 rounded-full bg-white/10"></div>
                    </td>
                    <td data-label="Email">
                      <div class="h-3 w-2/3 rounded-full bg-white/10"></div>
                    </td>
                    <td data-label="Sales">
                      <div class="h-3 w-1/2 rounded-full bg-white/10"></div>
                    </td>
                    <td data-label="Total Games">
                      <div class="h-3 w-1/2 rounded-full bg-white/10"></div>
                    </td>
                    <td data-label="Status">
                      <div class="h-6 w-20 rounded-full bg-white/10"></div>
                    </td>
                  </tr>
                  <tr class="animate-pulse">
                    <td data-label="Agent">
                      <div class="h-3 w-2/3 rounded-full bg-white/10"></div>
                    </td>
                    <td data-label="Email">
                      <div class="h-3 w-1/2 rounded-full bg-white/10"></div>
                    </td>
                    <td data-label="Sales">
                      <div class="h-3 w-1/3 rounded-full bg-white/10"></div>
                    </td>
                    <td data-label="Total Games">
                      <div class="h-3 w-1/3 rounded-full bg-white/10"></div>
                    </td>
                    <td data-label="Status">
                      <div class="h-6 w-20 rounded-full bg-white/10"></div>
                    </td>
                  </tr>
                  <tr class="animate-pulse">
                    <td data-label="Agent">
                      <div class="h-3 w-1/2 rounded-full bg-white/10"></div>
                    </td>
                    <td data-label="Email">
                      <div class="h-3 w-2/3 rounded-full bg-white/10"></div>
                    </td>
                    <td data-label="Sales">
                      <div class="h-3 w-2/3 rounded-full bg-white/10"></div>
                    </td>
                    <td data-label="Total Games">
                      <div class="h-3 w-1/2 rounded-full bg-white/10"></div>
                    </td>
                    <td data-label="Status">
                      <div class="h-6 w-20 rounded-full bg-white/10"></div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section>

          <!-- Section Preview -->
          <section class="mt-6 rounded-[2rem] border border-white/10 bg-panel/80 p-6 shadow-panel">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Section Preview</p>
                <h3 id="sectionTitle" class="mt-2 font-display text-2xl font-bold">Dashboard</h3>
              </div>
              <span class="status-pill">Admin Flow</span>
            </div>
            <p id="sectionDescription" class="mt-4 max-w-3xl text-sm leading-7 text-muted">
              The admin dashboard tracks platform health, agent activity, draw operations, and operational decisions.
            </p>
          </section>

          <!-- Footer -->
          <?php include_once('includes/footer.php'); ?>
        </div>
      </main>
    </div>
  </div>

  <!-- Dashboard Scripts -->
  <?php include_once('includes/scripts.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    (function () {
      const basePath = "/lt/";
      const latestResultsContainer = document.getElementById("adminLatestResults");

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

      function setText(id, value) {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
      }

      function normalizeResults(rows) {
        const map = new Map();
        rows.forEach((row) => {
          const id = row.result_id || row.id;
          if (!id) return;
          if (!map.has(id)) {
            map.set(id, {
              id,
              game_name: row.game_name || "Game",
              published_at: row.result_published_at || row.published_at,
              winning_numbers: [],
              machine_numbers: []
            });
          }
          const entry = map.get(id);
          const gameTypeName = row.result_game_type_name || row.game_type_name || "Game";
          const gameTypeId = row.result_game_type_id || row.game_type_id || null;
          if (row.result_winning_number !== undefined && row.result_winning_number !== null) {
            entry.winning_numbers.push({
              number: String(row.result_winning_number).padStart(2, "0"),
              game_type_name: gameTypeName,
              game_type_id: gameTypeId
            });
          }
          if (row.result_machine_number !== undefined && row.result_machine_number !== null) {
            entry.machine_numbers.push({
              number: String(row.result_machine_number).padStart(2, "0"),
              game_type_name: gameTypeName,
              game_type_id: gameTypeId
            });
          }
        });
        return Array.from(map.values()).sort((a, b) => new Date(b.published_at) - new Date(a.published_at));
      }

      function renderLatestResults(container, results) {
        if (!container) return;
        const filtered = results.filter((result) => isWithinLastTwoDays(result.published_at));
        if (!filtered.length) {
          container.innerHTML = `
            <div class="empty-state empty-state--compact">
              <i data-lucide="trophy"></i>
              <p class="text-lg font-semibold text-ink">No recent published game</p>
              <p class="mt-3 text-sm leading-6 text-muted">
                Published results will appear here once a game result is submitted.
              </p>
            </div>
          `;
          if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons();
          }
          return;
        }

        container.innerHTML = filtered
          .slice(0, 3)
          .map(
            (result) => `
              <article class="result-card">
                <div class="flex items-start justify-between gap-4">
                  <div>
                    <p class="text-sm uppercase tracking-[0.28em] text-accentSoft">${result.game_name}</p>
                    <p class="mt-2 text-sm text-muted">${formatDate(result.published_at)}</p>
                  </div>
                  <span class="status-pill status-pill--positive">Published</span>
                </div>
                <div class="result-split mt-6">
                  <div>
                    <p class="result-label">Winning Numbers</p>
                    <div class="result-entry-grid result-entry-grid--horizontal mt-3">
                      ${(result.winning_numbers || [])
                        .map(
                          (item) => `
                            <div class="result-entry-card">
                              <span class="number-chip">${item.number}</span>
                              <p class="result-entry-name">${item.game_type_name || "Game"}</p>
                            </div>
                          `
                        )
                        .join("")}
                    </div>
                  </div>
                  <div>
                    <p class="result-label">Machine Numbers</p>
                    <div class="result-entry-grid result-entry-grid--horizontal mt-3">
                      ${(result.machine_numbers || [])
                        .map(
                          (item) => `
                            <div class="result-entry-card result-entry-card--soft">
                              <span class="number-chip number-chip--soft">${item.number}</span>
                              <p class="result-entry-name">${item.game_type_name || "Game"}</p>
                            </div>
                          `
                        )
                        .join("")}
                    </div>
                  </div>
                </div>
              </article>
            `
          )
          .join("");
      }

      function renderAgentsTable(agents, bets) {
        const tbody = document.querySelector("tbody");
        if (!tbody) return;

        const salesByAgent = new Map();
        const gamesByAgent = new Map();
        (bets || []).forEach((bet) => {
          const agentId = bet.bet_agent_id || bet.agent_id;
          if (!agentId) return;
          const stake = Number.parseFloat(bet.bet_stake_amount ?? bet.stake_amount ?? 0);
          const current = salesByAgent.get(agentId) || 0;
          salesByAgent.set(agentId, current + stake);
          const gamesPlayed = Number.parseInt(bet.bet_total_games_played ?? bet.total_games_played ?? 0, 10) || 0;
          const gamesCurrent = gamesByAgent.get(agentId) || 0;
          gamesByAgent.set(agentId, gamesCurrent + gamesPlayed);
        });

        const rankedAgents = (agents || [])
          .map((agent) => ({
            agent,
            sales: salesByAgent.get(agent.id) || 0
          }))
          .sort((a, b) => b.sales - a.sales)
          .slice(0, 3);

        const rows = rankedAgents.map((entry, index) => {
          const agent = entry.agent;
          const sales = entry.sales;
          const totalGames = gamesByAgent.get(agent.id) || 0;
          return {
            outlet: `${index + 1}. ${agent.name || agent.id}`,
            region: agent.email || "N/A",
            sales,
            remittance: totalGames,
            status: agent.suspendAgent ? "Review" : "Healthy"
          };
        });

        if (!rows.length) {
          tbody.innerHTML = `
            <tr>
              <td colspan="5">
                <div class="empty-state empty-state--compact py-6">
                  <i data-lucide="users"></i>
                  <p class="text-lg font-semibold text-ink">No agent activity yet</p>
                </div>
              </td>
            </tr>
          `;
          if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons();
          }
          return;
        }

        tbody.innerHTML = rows
          .map(
            (row) => `
              <tr>
                <td data-label="Outlet">${row.outlet}</td>
                <td data-label="Region">${row.region}</td>
                <td data-label="Sales">${formatCurrency(row.sales)}</td>
                <td data-label="Remittance">${Number(row.remittance || 0).toLocaleString()}</td>
                <td data-label="Status"><span class="status-pill ${row.status === "Healthy" ? "status-pill--positive" : "status-pill--warning"}">${row.status}</span></td>
              </tr>
            `
          )
          .join("");
      }

      function isToday(dateValue) {
        const date = new Date(dateValue);
        if (Number.isNaN(date.getTime())) return false;
        const now = new Date();
        return (
          date.getFullYear() === now.getFullYear() &&
          date.getMonth() === now.getMonth() &&
          date.getDate() === now.getDate()
        );
      }

      function isWithinLastTwoDays(dateValue) {
        const date = new Date(dateValue);
        if (Number.isNaN(date.getTime())) return false;
        const now = new Date();
        const start = new Date(now.getFullYear(), now.getMonth(), now.getDate() - 1);
        return date >= start && date <= now;
      }

      async function loadDashboard() {
        try {
          const [agentsRes, betsRes, resultsRes, gamesRes] = await Promise.all([
            axios.get(`${basePath}api/agent/all`),
            axios.get(`${basePath}api/bet/with-details`),
            axios.get(`${basePath}api/result/with-numbers`),
            axios.get(`${basePath}api/game/all`)
          ]);

          const agents = Array.isArray(agentsRes?.data?.message) ? agentsRes.data.message : [];
          const bets = Array.isArray(betsRes?.data?.message) ? betsRes.data.message : [];
          const resultsRows = Array.isArray(resultsRes?.data?.message) ? resultsRes.data.message : [];
          const games = Array.isArray(gamesRes?.data?.message) ? gamesRes.data.message : [];
          const results = normalizeResults(resultsRows);

          const totalSales = bets.reduce(
            (sum, bet) => sum + Number.parseFloat(bet.bet_stake_amount ?? bet.stake_amount ?? 0),
            0
          );

          const pendingSettlements = bets.filter((bet) => String(bet.bet_status || bet.status).toLowerCase() === "pending").length;

          const activeAgents = agents.filter((agent) => !agent.suspendAgent).length;
          setText("adminTotalSales", formatCurrency(totalSales));
          setText("adminOpenAgents", String(activeAgents));
          setText("adminOpenAgentsCard", String(activeAgents));
          setText("adminPendingSettlements", String(pendingSettlements));
          setText("adminTotalGamesCard", String(games.length));

          renderLatestResults(latestResultsContainer, results);
          renderAgentsTable(agents, bets);
        } catch (error) {
          setText("adminTotalSales", "N 0");
          setText("adminOpenAgentsCard", "0");
          setText("adminPendingSettlements", "0");
          setText("adminTotalGamesCard", "0");
          renderLatestResults(latestResultsContainer, []);
          renderAgentsTable([], []);
        }
      }

      loadDashboard();
    })();
  </script>
</body>

</html>
