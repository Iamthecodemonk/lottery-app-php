<?php include_once('includes/head.php'); ?>

<body class="min-h-screen bg-shell font-body text-ink" data-page="admin-cashback-monitor">
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
                  <h1 class="mt-2 font-display text-3xl font-bold">Cash Back Monitoring</h1>
                  <p class="mt-3 max-w-2xl text-sm leading-6 text-muted">
                    Oversight screen for cash back tickets submitted by agents, with monitoring sorted around agent activity.
                  </p>
                </div>
                <span class="status-pill">Agent Sorted</span>
              </div>
            </header>

          <section class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-5">
            <article class="stat-card">
              <p class="stat-label">Total Records</p>
              <h3 id="adminCashbackRecordsCount" class="stat-value">0</h3>
              <p class="stat-meta text-accent">Submitted cash back entries</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Games Played</p>
              <h3 id="adminCashbackGamesPlayed" class="stat-value">0</h3>
              <p class="stat-meta text-accent">Across all agents</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Amount Earned</p>
              <h3 id="adminCashbackAmountEarned" class="stat-value">N 0</h3>
              <p class="stat-meta text-accentSoft">Total monitored cash back value</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Agents Playing</p>
              <h3 id="adminCashbackAgentsCount" class="stat-value">0</h3>
              <p class="stat-meta text-accentBright">Unique agents in this module</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Recent Entries</p>
              <h3 id="adminCashbackRecentCount" class="stat-value">0</h3>
              <p class="stat-meta text-accent">Last 24 hours</p>
            </article>
          </section>

          <section class="mt-6 grid gap-6 xl:grid-cols-12">
            <article class="panel-card xl:col-span-4">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Cash Back Directory</p>
                <h2 class="mt-2 font-display text-2xl font-bold">Browse agents first</h2>
              </div>

              <div class="mt-6 space-y-4">
                <input id="adminCashbackSearch" type="text" class="form-input"
                  placeholder="Search agent, code, outlet or cash back ID" />
                <div class="filter-tabs">
                  <button class="filter-tab is-active" type="button" data-cashback-monitor-filter="all">All</button>
                  <button class="filter-tab" type="button" data-cashback-monitor-filter="high-value">High Value</button>
                  <button class="filter-tab" type="button" data-cashback-monitor-filter="recent">Recent</button>
                </div>
              </div>

              <div id="adminCashbackAgentList" class="sales-agent-list mt-6"></div>
            </article>

            <article class="table-card xl:col-span-8">
              <div
                class="flex flex-col gap-3 border-b border-white/10 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                  <p class="text-sm uppercase tracking-[0.35em] text-muted">Cash Back Transactions</p>
                  <h2 id="adminCashbackTransactionsTitle" class="mt-2 font-display text-2xl font-bold">All Cash Back
                    Transactions</h2>
                  <p id="adminCashbackTransactionsMeta" class="mt-2 text-sm text-muted">0 records</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                  <input id="adminCashbackTableSearch" type="text" class="form-input"
                    placeholder="Search agent in table" />
                  <span class="status-pill">Cash Back</span>
                </div>
              </div>
              <div class="table-wrap">
                <table class="data-table">
                  <thead>
                    <tr>
                      <th>Agent</th>
                      <th>Agent Code</th>
                      <th>Outlet</th>
                      <th>Game</th>
                      <th>Cash Back ID</th>
                      <th>Amount</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody id="adminCashbackMonitorTableBody"></tbody>
                </table>
              </div>
              <div id="cashbackPagination" class="mt-6 flex flex-wrap items-center justify-between gap-3"></div>
            </article>
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
      const searchInput = document.getElementById("adminCashbackSearch");
      const tableSearchInput = document.getElementById("adminCashbackTableSearch");
      const filterTabs = document.querySelectorAll("[data-cashback-monitor-filter]");
      const agentList = document.getElementById("adminCashbackAgentList");
      const tableBody = document.getElementById("adminCashbackMonitorTableBody");
      const title = document.getElementById("adminCashbackTransactionsTitle");
      const meta = document.getElementById("adminCashbackTransactionsMeta");
      const paginationEl = document.getElementById("cashbackPagination");

      const pageSize = 10;
      let currentPage = 1;
      let currentSearch = "";
      let currentFilter = "all";
      let selectedAgentKey = "";
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

      function getFilterMatch(record, filter) {
        if (filter === "high-value") {
          return Number(record.stakeAmount || 0) >= 5000;
        }
        if (filter === "recent") {
          return Number(record.playedAt || 0) >= Date.now() - 24 * 60 * 60 * 1000;
        }
        return true;
      }

      function getSummary(rows) {
        const uniqueAgents = new Set(rows.map((entry) => `${entry.agentId || entry.agentName}__${entry.outlet}`));
        const recentEntries = rows.filter((entry) => Number(entry.playedAt || 0) >= Date.now() - 24 * 60 * 60 * 1000).length;
        return {
          totalRecords: rows.length,
          totalGamesPlayed: rows.length,
          totalAmountEarned: rows.reduce((sum, entry) => sum + Number(entry.stakeAmount || 0), 0),
          totalAgents: uniqueAgents.size,
          recentEntries
        };
      }

      function getAgents(rows) {
        const map = new Map();
        rows.forEach((entry) => {
          const key = entry.agentId || `${entry.agentName}__${entry.outlet}`;
          const current = map.get(key) || {
            agentKey: key,
            agentName: entry.agentName || "Agent",
            agentCode: entry.agentId || "AGENT",
            outlet: entry.outlet || "Outlet",
            totalEntries: 0,
            totalAmount: 0,
            lastPlayedAt: entry.playedAt
          };

          current.totalEntries += 1;
          current.totalAmount += Number(entry.stakeAmount || 0);
          current.lastPlayedAt = Math.max(current.lastPlayedAt || 0, entry.playedAt || 0);
          map.set(key, current);
        });

        return [...map.values()].sort((a, b) => b.totalAmount - a.totalAmount || b.lastPlayedAt - a.lastPlayedAt);
      }

      function renderAgents(agents, selectedKey) {
        if (!agentList) {
          return;
        }

        if (!agents.length) {
          agentList.innerHTML = `
            <div class="empty-state empty-state--compact">
              <i data-lucide="users"></i>
              <p class="text-lg font-semibold text-ink">No agents match this view</p>
              <p class="mt-3 text-sm leading-6 text-muted">
                Try adjusting the search term or activity filter to reveal cash back records.
              </p>
            </div>
          `;
          if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons();
          }
          return;
        }

        agentList.innerHTML = `
          <button type="button" class="sales-agent-card ${selectedKey ? "" : "is-active"}" data-cashback-agent="all">
            <div class="sales-agent-card-head">
              <div>
                <p class="sales-agent-name">All Agents</p>
                <p class="sales-agent-meta">Combined cash back stream</p>
              </div>
              <span class="status-pill">Overview</span>
            </div>
            <div class="sales-agent-stats">
              <div>
                <p class="sales-agent-stat-label">Agents</p>
                <strong class="sales-agent-stat-value">${agents.length}</strong>
              </div>
            </div>
          </button>
          ${agents
            .map(
              (agent) => `
                <button type="button" class="sales-agent-card ${selectedKey === agent.agentKey ? "is-active" : ""}" data-cashback-agent="${agent.agentKey}">
                  <div class="sales-agent-card-head">
                    <div>
                      <p class="sales-agent-name">${agent.agentName}</p>
                      <p class="sales-agent-meta">${agent.outlet}</p>
                    </div>
                    <span class="sales-agent-date">${formatDate(agent.lastPlayedAt)}</span>
                  </div>
                  <div class="sales-agent-stats">
                    <div>
                      <p class="sales-agent-stat-label">Transactions</p>
                      <strong class="sales-agent-stat-value">${agent.totalEntries}</strong>
                    </div>
                    <div>
                      <p class="sales-agent-stat-label">Amount</p>
                      <strong class="sales-agent-stat-value">${formatCurrency(agent.totalAmount)}</strong>
                    </div>
                  </div>
                </button>
              `
            )
            .join("")}
        `;
      }

      function renderRows(rows, hasActiveFilter) {
        if (!tableBody) {
          return;
        }

        if (!rows.length) {
          tableBody.innerHTML = `
            <tr>
              <td colspan="7">
                <div class="empty-state empty-state--compact py-10">
                  <i data-lucide="receipt-text"></i>
                  <p class="text-lg font-semibold text-ink">${hasActiveFilter ? "No matching cash back records" : "No cash back transactions yet"}</p>
                  <p class="mt-3 text-sm leading-6 text-muted">
                    ${hasActiveFilter
                      ? "Try adjusting the search term, filter, or selected agent."
                      : "Cash back transactions will appear here once records are available."}
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
        console.log("Rendering rows:", rows);
        tableBody.innerHTML = rows
          .map(
            (entry) => `
              <tr>
                <td data-label="Agent">${entry.agentName || "Agent"}</td>
                <td data-label="Agent Code">${entry.agentId || "AGENT"}</td>
                <td data-label="Outlet">${entry.outlet || "Outlet"}</td>
                <td data-label="Game">${entry.gameName}</td>
                <td data-label="Cash Back ID">${entry.betId || "N/A"}</td>
                <td data-label="Amount">${formatCurrency(entry.stakeAmount)}</td>
                <td data-label="Date">${formatDate(entry.playedAt)}</td>
              </tr>
            `
          )
          .join("");
      }

      function renderPagination(filteredRows) {
        if (!paginationEl) {
          return;
        }

        const totalPages = Math.max(1, Math.ceil(filteredRows.length / pageSize));
        if (currentPage > totalPages) {
          currentPage = totalPages;
        }

        const start = (currentPage - 1) * pageSize;
        const end = start + pageSize;
        const pageRows = filteredRows.slice(start, end);

        renderRows(pageRows, Boolean(currentSearch || currentFilter !== "all" || selectedAgentKey));

        paginationEl.innerHTML = `
          <div class="text-sm text-muted">
            Showing ${filteredRows.length ? start + 1 : 0}-${Math.min(end, filteredRows.length)} of ${filteredRows.length}
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
          const totalPages = Math.max(1, Math.ceil(getFilteredRows().length / pageSize));
          if (currentPage < totalPages) {
            currentPage += 1;
          }
        }
        renderView();
      });

      function getFilteredRows() {
        return allRows.filter((entry) => {
          const haystack = `${entry.agentName || ""} ${entry.agentId || ""} ${entry.outlet || ""} ${entry.gameName || ""} ${entry.cashBackId || ""}`.toLowerCase();
          const matchesSearch = haystack.includes(currentSearch);
          const matchesFilter = getFilterMatch(entry, currentFilter);
          const matchesAgent = selectedAgentKey ? `${entry.agentId || entry.agentName}__${entry.outlet}` === selectedAgentKey : true;
          return matchesSearch && matchesFilter && matchesAgent;
        });
      }

      function renderView() {
        const summary = getSummary(allRows);
        const filteredRows = getFilteredRows();
        const agents = getAgents(allRows).filter((agent) => {
          const haystack = `${agent.agentName} ${agent.agentCode} ${agent.outlet}`.toLowerCase();
          const matchesSearch = haystack.includes(currentSearch);
          const proxyRecord = { stakeAmount: agent.totalAmount, playedAt: agent.lastPlayedAt };
          const matchesFilter = getFilterMatch(proxyRecord, currentFilter);
          return matchesSearch && matchesFilter;
        });

        const selectedAgent = agents.find((agent) => agent.agentKey === selectedAgentKey);
        const selectedValue = filteredRows.reduce((sum, entry) => sum + Number(entry.stakeAmount || 0), 0);
        const updateText = (id, value) => {
          const el = document.getElementById(id);
          if (el) {
            el.textContent = value;
          }
        };

        updateText("adminCashbackRecordsCount", String(summary.totalRecords));
        updateText("adminCashbackGamesPlayed", String(summary.totalGamesPlayed));
        updateText("adminCashbackAmountEarned", formatCurrency(summary.totalAmountEarned));
        updateText("adminCashbackAgentsCount", String(summary.totalAgents));
        updateText("adminCashbackRecentCount", String(summary.recentEntries));

        renderAgents(agents, selectedAgentKey);

        if (title) {
          title.textContent = selectedAgent ? `${selectedAgent.agentName} Cash Back Transactions` : "All Cash Back Transactions";
        }

        if (meta) {
          meta.textContent = selectedAgent
            ? `${selectedAgent.outlet} • ${filteredRows.length} records • ${formatCurrency(selectedValue)}`
            : `${filteredRows.length} records • ${formatCurrency(selectedValue)}`;
        }

        renderPagination(filteredRows);
      }

      async function fetchData() {
        try {
          const response = await axios.get(`${basePath}api/bet/with-details`);
          const bets = Array.isArray(response?.data?.message) ? response.data.message : [];

          allRows = bets
            .filter((bet) => String(bet.game_category || "").toLowerCase() === "cashback")
            .map((bet) => {
              const outlet = [bet.agent_email, bet.agent_phone].filter(Boolean).join(" • ") || "Agent";
              const placedAt = bet.bet_placed_at || bet.placed_at || Date.now();
              const stakeAmount = Number.parseFloat(bet.bet_stake_amount ?? bet.stake_amount ?? 0);

              return {
                betId: bet.bet_id || bet.id,
                agentId: bet.bet_agent_id || bet.agent_id || "",
                agentName: bet.agent_name || bet.bet_agent_id || "Agent",
                agentCode: bet.bet_agent_id || bet.agent_id || "AGENT",
                outlet,
                gameName: bet.game_name || bet.bet_game_id || "Game",
                cashBackId: bet.bet_cashback_id || bet.cashback_id || "",
                stakeAmount,
                playedAt: placedAt
              };
            });

          currentPage = 1;
          renderView();
        } catch (error) {
          allRows = [];
          currentPage = 1;
          renderView();
        }
      }

      renderView();
      fetchData();

      searchInput?.addEventListener("input", (event) => {
        currentSearch = event.target.value.trim().toLowerCase();
        currentPage = 1;
        if (selectedAgentKey && !getAgents(allRows).some((agent) => agent.agentKey === selectedAgentKey)) {
          selectedAgentKey = "";
        }
        renderView();
      });

      tableSearchInput?.addEventListener("input", (event) => {
        currentSearch = event.target.value.trim().toLowerCase();
        currentPage = 1;
        if (selectedAgentKey && !getAgents(allRows).some((agent) => agent.agentKey === selectedAgentKey)) {
          selectedAgentKey = "";
        }
        renderView();
      });

      filterTabs.forEach((tab) => {
        tab.addEventListener("click", () => {
          filterTabs.forEach((item) => item.classList.remove("is-active"));
          tab.classList.add("is-active");
          currentFilter = tab.dataset.cashbackMonitorFilter || "all";
          currentPage = 1;

          if (selectedAgentKey && !getAgents(allRows).some((agent) => agent.agentKey === selectedAgentKey)) {
            selectedAgentKey = "";
          }

          renderView();
        });
      });

      agentList?.addEventListener("click", (event) => {
        const trigger = event.target.closest("[data-cashback-agent]");
        if (!trigger) {
          return;
        }

        selectedAgentKey = trigger.getAttribute("data-cashback-agent") === "all"
          ? ""
          : String(trigger.getAttribute("data-cashback-agent"));
        currentSearch = "";
        if (searchInput) {
          searchInput.value = "";
        }
        if (tableSearchInput) {
          tableSearchInput.value = "";
        }
        currentPage = 1;
        renderView();
      });
    })();
  </script>
</body>

</html>
