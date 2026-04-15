<?php include_once('includes/head.php'); ?>

<body class="min-h-screen bg-shell font-body text-ink" data-page="agent-dashboard">
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

          <!-- Agent Stats -->
          <section class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <article class="stat-card">
              <p class="stat-label">Tickets Sold</p>
              <h3 id="agentTicketsSoldToday" class="stat-value">0</h3>
              <p class="stat-meta text-accent">Strong outlet activity</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Sales Today</p>
              <h3 id="agentSalesToday" class="stat-value">N 0</h3>
              <p class="stat-meta text-accentSoft">Across all open draws</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Credit Balance</p>
              <h3 id="agentCreditBalance" class="stat-value">N 0</h3>
              <p class="stat-meta text-accentBright">Available to play</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Total Results</p>
              <h3 id="agentTotalResults" class="stat-value">0</h3>
              <p class="stat-meta text-accentBright">Published on platform</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Total Games</p>
              <h3 id="agentTotalGames" class="stat-value">0</h3>
              <p class="stat-meta text-accentSoft">Active on platform</p>
            </article>
          </section>

          <!-- Agent Primary Panels -->
          <section class="mt-6 grid gap-6 xl:grid-cols-[1.25fr_0.75fr]">
            <!-- Quick Actions -->
            <article class="panel-card">
              <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                  <p class="text-sm uppercase tracking-[0.35em] text-muted">Sales Workflow</p>
                  <h3 class="mt-2 font-display text-2xl font-bold">Quick outlet actions</h3>
                </div>
                <p class="max-w-md text-sm leading-6 text-muted">
                  The agent dashboard should prioritize speed, repetition, and immediate customer service.
                </p>
              </div>

              <div class="mt-6 grid gap-4 md:grid-cols-2">
                <div class="soft-card">
                  <p class="text-sm font-semibold text-ink">Fast actions</p>
                  <div class="mt-4 flex flex-wrap gap-3">
                    <a class="chip" href="/lt/agent/cashback">Play Cash Back</a>
                    <a class="chip" href="/lt/agent/lotto">Play Lotto</a>
                    <a class="chip" href="/lt/agent/results">Check result</a>
                  </div>
                </div>
                <div class="metric-band">
                  <p class="text-sm uppercase tracking-[0.28em] text-accentSoft">Outlet Status</p>
                  <p class="mt-3 text-2xl font-bold text-ink">Open and active</p>
                  <p class="mt-3 text-sm leading-6 text-muted">
                    Sales are live for the current draw cycle and customer verification is available.
                  </p>
                </div>
              </div>
            </article>

            <!-- Agent Summary -->
            <aside class="panel-card">
              <p class="text-sm uppercase tracking-[0.35em] text-muted">Shift Summary</p>
              <div class="mt-5">
                <div class="info-row">
                  <span class="text-sm text-muted">Last ticket issued</span>
                  <span id="agentLastTicketIssued" class="text-sm font-semibold text-ink">--</span>
                </div>
                <div class="info-row">
                  <span class="text-sm text-muted">Highest stake</span>
                  <span id="agentHighestStake" class="text-sm font-semibold text-ink">N 0</span>
                </div>
                <div class="info-row">
                  <span class="text-sm text-muted">Pending claims</span>
                  <span class="status-pill status-pill--warning">7 Open</span>
                </div>
              </div>
            </aside>
          </section>

          <!-- Latest Results -->
          <section class="mt-6 panel-card">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Latest Results</p>
                <h3 class="mt-2 font-display text-2xl font-bold">Newest published results</h3>
              </div>
              <a href="./agent-results.html" class="cta-link">Open full results page</a>
            </div>
            <div id="agentLatestResults" class="mt-6 stack-grid"></div>
          </section>

          <!-- Tickets Table -->
          <section class="mt-6 table-card">
            <div
              class="flex flex-col gap-3 border-b border-white/10 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Recent Tickets</p>
                <h3 class="mt-2 font-display text-2xl font-bold">Latest customer activity</h3>
              </div>
              <span class="status-pill">Live Sales Feed</span>
            </div>

            <div class="table-wrap">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Ticket ID</th>
                    <th>Draw</th>
                    <th>Customer</th>
                    <th>Stake</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="agentLatestBetsBody"></tbody>
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
              <span class="status-pill">Agent Flow</span>
            </div>
            <p id="sectionDescription" class="mt-4 max-w-3xl text-sm leading-7 text-muted">
              The agent dashboard highlights today's sales, quick ticket actions, result checks, and outlet performance.
            </p>
          </section>

          <!-- Footer -->
          <?php include_once('includes/footer.php'); ?>
          <!-- <footer class="page-footer">
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
      const resultsContainer = document.getElementById("agentLatestResults");
      const latestBetsBody = document.getElementById("agentLatestBetsBody");
      const ticketsSoldTodayEl = document.getElementById("agentTicketsSoldToday");
      const salesTodayEl = document.getElementById("agentSalesToday");
      const creditBalanceEl = document.getElementById("agentCreditBalance");
      const totalResultsEl = document.getElementById("agentTotalResults");
      const totalGamesEl = document.getElementById("agentTotalGames");
      const lastTicketIssuedEl = document.getElementById("agentLastTicketIssued");
      const highestStakeEl = document.getElementById("agentHighestStake");

      function formatDate(value) {
        const date = new Date(value);
        if (Number.isNaN(date.getTime())) return "N/A";
        return date.toLocaleString("en-NG", {
          day: "numeric",
          month: "short",
          year: "numeric",
          hour: "numeric",
          minute: "2-digit"
        });
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
          const gameName = row.result_game_name || row.game_name || "Game";
          const gameId = row.result_detail_game_id || row.result_game_id || row.game_id || null;
          if (row.result_winning_number !== undefined && row.result_winning_number !== null) {
            entry.winning_numbers.push({
              number: String(row.result_winning_number).padStart(2, "0"),
              game_type_name: gameName,
              game_type_id: gameId
            });
          }
          if (row.result_machine_number !== undefined && row.result_machine_number !== null) {
            entry.machine_numbers.push({
              number: String(row.result_machine_number).padStart(2, "0"),
              game_type_name: gameName,
              game_type_id: gameId
            });
          }
        });
        return Array.from(map.values()).sort((a, b) => new Date(b.published_at) - new Date(a.published_at));
      }

      function renderLatestResultsToday(results) {
        if (!resultsContainer) return;
        const todayResults = results.filter((item) => isToday(item.published_at));
        if (!todayResults.length) {
          resultsContainer.innerHTML = `
            <div class="empty-state empty-state--compact">
              <i data-lucide="trophy"></i>
              <p class="text-lg font-semibold text-ink">No result today</p>
              <p class="mt-3 text-sm leading-6 text-muted">
                Latest results will appear once published.
              </p>
            </div>
          `;
          if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons();
          }
          return;
        }

        resultsContainer.innerHTML = todayResults
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

      function formatCurrency(value) {
        const amount = Number(value || 0);
        if (Number.isNaN(amount)) return "N 0";
        return `N ${amount.toLocaleString("en-NG", { minimumFractionDigits: 0, maximumFractionDigits: 2 })}`;
      }

      function readCookie(name) {
        const match = document.cookie.split("; ").find((row) => row.startsWith(`${name}=`));
        return match ? decodeURIComponent(match.split("=")[1]) : "";
      }

      function formatModeLabel(mode) {
        const normalized = (mode || "").toLowerCase();
        if (normalized === "cashback") return "Cashback";
        return "Lotto";
      }

      function renderLatestBets(rows) {
        if (!latestBetsBody) return;
        if (!rows.length) {
          latestBetsBody.innerHTML = `
            <tr>
              <td colspan="5">
                <div class="empty-state empty-state--compact">
                  <i data-lucide="ticket"></i>
                  <p class="text-lg font-semibold text-ink">No tickets yet</p>
                  <p class="mt-3 text-sm leading-6 text-muted">
                    Latest lotto and cashback tickets will show here.
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

        latestBetsBody.innerHTML = rows
          .map(
            (bet) => `
              <tr>
                <td data-label="Ticket ID">${bet.bet_id || bet.id || "N/A"}</td>
                <td data-label="Draw">${bet.game_name || "Draw"}</td>
                <td data-label="Customer">${formatModeLabel(bet.bet_mode || bet.mode)} ticket</td>
                <td data-label="Stake">${formatCurrency(bet.bet_stake_amount || bet.stake_amount)}</td>
                <td data-label="Action">
                  <a class="chip" href="${getModeLink(bet.bet_mode || bet.mode)}">
                    ${getModeLabel(bet.bet_mode || bet.mode)}
                  </a>
                </td>
              </tr>
            `
          )
          .join("");
      }

      function getModeLink(mode) {
        const normalized = (mode || "").toLowerCase();
        if (normalized === "cashback") return "/lt/agent/cashback";
        return "/lt/agent/lotto";
      }

      function getModeLabel(mode) {
        const normalized = (mode || "").toLowerCase();
        if (normalized === "cashback") return "Open Cashback";
        return "Open Lotto";
      }

      function formatTime(value) {
        const date = new Date(value);
        if (Number.isNaN(date.getTime())) return "--";
        return date.toLocaleTimeString("en-NG", {
          hour: "numeric",
          minute: "2-digit"
        });
      }

      function pickLatestPerMode(bets, mode, count) {
        const normalizedMode = mode.toLowerCase();
        return bets
          .filter((bet) => {
            const current = (bet.bet_mode || bet.mode || "").toLowerCase();
            if (normalizedMode === "lotto") {
              return current === "lotto" || current === "placebet";
            }
            return current === normalizedMode;
          })
          .sort((a, b) => new Date(b.bet_placed_at || b.placed_at) - new Date(a.bet_placed_at || a.placed_at))
          .slice(0, count);
      }

      async function loadLatestResults() {
        try {
          const response = await axios.get(`${basePath}api/result/with-numbers`);
          const rows = Array.isArray(response?.data?.message) ? response.data.message : [];
          const results = normalizeResults(rows);
          renderLatestResultsToday(results);
          if (totalResultsEl) {
            totalResultsEl.textContent = String(results.length);
          }
        } catch (error) {
          renderLatestResultsToday([]);
          if (totalResultsEl) totalResultsEl.textContent = "0";
        }
      }

      async function loadGamesCount() {
        try {
          const response = await axios.get(`${basePath}api/game/all`);
          const rows = Array.isArray(response?.data?.message) ? response.data.message : [];
          if (totalGamesEl) totalGamesEl.textContent = String(rows.length);
        } catch (error) {
          if (totalGamesEl) totalGamesEl.textContent = "0";
        }
      }

      async function loadAgentStats() {
        try {
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
            if (ticketsSoldTodayEl) ticketsSoldTodayEl.textContent = "0";
            if (salesTodayEl) salesTodayEl.textContent = "N 0";
            if (creditBalanceEl) creditBalanceEl.textContent = "N 0";
            if (lastTicketIssuedEl) lastTicketIssuedEl.textContent = "--";
            if (highestStakeEl) highestStakeEl.textContent = "N 0";
            return;
          }

          const [betsRes, agentRes] = await Promise.all([
            axios.get(`${basePath}api/bet/by-agent`, { params: { agent_id: agentId } }),
            axios.get(`${basePath}api/agent/get-by-id`, { params: { agent_id: agentId } })
          ]);
          const rows = Array.isArray(betsRes?.data?.message) ? betsRes.data.message : [];
          const message = agentRes?.data?.message;
          const agent = Array.isArray(message)
            ? message[0]
            : (message && message.id ? message : message?.[0]);
          const todayBets = rows.filter((bet) => isToday(bet.placed_at || bet.bet_placed_at));
          const ticketsSold = todayBets.length;
          const salesToday = todayBets.reduce((sum, bet) => sum + Number(bet.stake_amount || bet.bet_stake_amount || 0), 0);

          if (ticketsSoldTodayEl) ticketsSoldTodayEl.textContent = String(ticketsSold);
          if (salesTodayEl) salesTodayEl.textContent = formatCurrency(salesToday);
          if (creditBalanceEl) creditBalanceEl.textContent = formatCurrency(agent?.balance || 0);
          if (agent) {
            localStorage.setItem("agent_profile", JSON.stringify(agent));
          }

          const latestBet = rows
            .filter((bet) => bet.placed_at || bet.bet_placed_at)
            .sort((a, b) => new Date(b.placed_at || b.bet_placed_at) - new Date(a.placed_at || a.bet_placed_at))[0];
          if (lastTicketIssuedEl) {
            lastTicketIssuedEl.textContent = latestBet ? formatTime(latestBet.placed_at || latestBet.bet_placed_at) : "--";
          }

          const highestStake = rows.reduce(
            (max, bet) => Math.max(max, Number(bet.stake_amount || bet.bet_stake_amount || 0)),
            0
          );
          if (highestStakeEl) highestStakeEl.textContent = formatCurrency(highestStake);
        } catch (error) {
          if (ticketsSoldTodayEl) ticketsSoldTodayEl.textContent = "0";
          if (salesTodayEl) salesTodayEl.textContent = "N 0";
          if (creditBalanceEl) creditBalanceEl.textContent = "N 0";
          if (lastTicketIssuedEl) lastTicketIssuedEl.textContent = "--";
          if (highestStakeEl) highestStakeEl.textContent = "N 0";
        }
      }

      async function loadLatestBets() {
        try {
          const storedAgent = localStorage.getItem("agent_profile");
          const agentProfile = storedAgent ? JSON.parse(storedAgent) : null;
          const agentId = agentProfile?.id;

          if (!agentId) {
            renderLatestBets([]);
            return;
          }

          const response = await axios.get(`${basePath}api/bet/with-numbers-by-agent`, {
            params: { agent_id: agentId }
          });
          const rows = Array.isArray(response?.data?.message) ? response.data.message : [];
          const latestLotto = pickLatestPerMode(rows, "lotto", 2);
          const latestCashback = pickLatestPerMode(rows, "cashback", 2);
          const combined = [...latestLotto, ...latestCashback]
            .sort((a, b) => new Date(b.bet_placed_at || b.placed_at) - new Date(a.bet_placed_at || a.placed_at));
          renderLatestBets(combined);
        } catch (error) {
          renderLatestBets([]);
        }
      }

      loadLatestResults();
      loadLatestBets();
      loadAgentStats();
      loadGamesCount();
    })();
  </script>
</body>

</html>
