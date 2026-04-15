<?php include_once('includes/head.php'); ?>

<body class="min-h-screen bg-shell font-body text-ink" data-page="admin-sales">
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

      <main class="dashboard-main flex-1 px-4 py-4 sm:px-6 lg:px-8 lg:py-8">
        <div class="mx-auto max-w-7xl">
          <!-- Sticky Header -->
          <?php include_once('includes/header.php'); ?>
          
                      <header class="topbar-offset rounded-[2rem] border border-white/10 bg-white/5 px-6 py-5 shadow-panel backdrop-blur-xl">
              <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-start gap-3">
                  <div>
                    <p class="text-sm uppercase tracking-[0.35em] text-muted">Admin Module</p>
                    <h1 class="mt-2 font-display text-3xl font-bold">Previous Agent Sales</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-muted">
                      UI-only sales history screen for reviewing previous outlet sales and historical agent records.
                    </p>
                  </div>
                </div>
                <span class="status-pill">Historical View</span>
              </div>
            </header>


          <section class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <article class="stat-card">
              <p class="stat-label">Total Records</p>
              <h3 id="adminSalesRecordsCount" class="stat-value">0</h3>
              <p class="stat-meta text-accent">Captured sales entries</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Total Tickets</p>
              <h3 id="adminSalesTicketsCount" class="stat-value">0</h3>
              <p class="stat-meta text-accentSoft">Tickets sold by agents</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Total Sales</p>
              <h3 id="adminSalesValueCount" class="stat-value">N 0</h3>
              <p class="stat-meta text-accent">Combined sales value</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Agents Selling</p>
              <h3 id="adminSalesAgentsCount" class="stat-value">0</h3>
              <p class="stat-meta text-accentBright">Unique active records</p>
            </article>
          </section>

          <section class="mt-6 grid gap-6 xl:grid-cols-12">
            <article class="panel-card xl:col-span-4">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Agent Sales Directory</p>
                <h2 class="mt-2 font-display text-2xl font-bold">Browse agents first</h2>
              </div>

              <div class="mt-6 space-y-4">
                <input id="adminSalesSearch" type="text" class="form-input"
                  placeholder="Search agent, outlet or game" />
                <div class="filter-tabs">
                  <button class="filter-tab is-active" type="button" data-sales-filter="all">All</button>
                  <button class="filter-tab" type="button" data-sales-filter="high-value">High Value</button>
                  <button class="filter-tab" type="button" data-sales-filter="recent">Recent</button>
                </div>
              </div>

              <div id="adminSalesAgentList" class="sales-agent-list mt-6"></div>
            </article>

            <article class="table-card xl:col-span-8">
              <div
                class="flex flex-col gap-3 border-b border-white/10 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                  <p class="text-sm uppercase tracking-[0.35em] text-muted">Sales Transactions</p>
                  <h2 id="salesTransactionsTitle" class="mt-2 font-display text-2xl font-bold">All Agent Transactions
                  </h2>
                  <p id="salesTransactionsMeta" class="mt-2 text-sm text-muted">0 records</p>
                </div>
                <span class="status-pill">Historical View</span>
              </div>

              <div class="table-wrap">
                <table class="data-table">
                  <thead>
                    <tr>
                      <th>Agent</th>
                      <th>Outlet</th>
                      <th>Game</th>
                      <th>Tickets</th>
                      <th>Sales</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody id="salesTableBody"></tbody>
                </table>
              </div>
            </article>
          </section>

          <!-- Footer -->
          <?php include_once('includes/footer.php'); ?>
        </div>
      </main>
    </div>
  </div>

  <!-- Page Scripts -->
  <?php include_once('includes/scripts.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    (function () {
      const searchInput = document.getElementById("adminSalesSearch");
      const filterTabs = document.querySelectorAll("[data-sales-filter]");
      const agentList = document.getElementById("adminSalesAgentList");
      const tableBody = document.getElementById("salesTableBody");
      const title = document.getElementById("salesTransactionsTitle");
      const meta = document.getElementById("salesTransactionsMeta");

      const basePath = "/lt/";
      let agents = [];
      let sales = [];
      let currentSearch = "";
      let currentFilter = "all";
      let selectedAgentKey = "";

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

      function getSalesSummary(rows) {
        const uniqueAgents = new Set(rows.map((sale) => `${sale.agentName}__${sale.outlet}`));
        return {
          totalRecords: rows.length,
          totalTickets: rows.reduce((sum, sale) => sum + Number(sale.tickets || 0), 0),
          totalSalesValue: rows.reduce((sum, sale) => sum + Number(sale.salesAmount || 0), 0),
          totalAgents: uniqueAgents.size
        };
      }

      function getAdminSalesAgents(allAgents, rows) {
        const map = new Map();

        (allAgents || []).forEach((agent) => {
          const outlet = [agent.email, agent.phone].filter(Boolean).join(" • ") || "Agent";
          const key = agent.id || `${agent.name || "Agent"}__${outlet}`;
          if (!map.has(key)) {
            const createdAt = new Date(agent.created_at || Date.now()).getTime();
            map.set(key, {
              agentKey: key,
              agentId: agent.id || "",
              agentName: agent.name || "Agent",
              outlet,
              totalTickets: 0,
              totalSales: 0,
              transactionCount: 0,
              lastSoldAt: createdAt
            });
          }
        });

        rows.forEach((sale) => {
          const key = sale.agentId || `${sale.agentName}__${sale.outlet}`;
          const current = map.get(key) || {
            agentKey: key,
            agentId: sale.agentId || "",
            agentName: sale.agentName,
            outlet: sale.outlet,
            totalTickets: 0,
            totalSales: 0,
            transactionCount: 0,
            lastSoldAt: sale.soldAt
          };

          current.totalTickets += Number(sale.tickets || 0);
          current.totalSales += Number(sale.salesAmount || 0);
          current.transactionCount += 1;
          current.lastSoldAt = Math.max(current.lastSoldAt || 0, sale.soldAt || 0);
          map.set(key, current);
        });

        return [...map.values()].sort((a, b) => b.totalSales - a.totalSales || b.lastSoldAt - a.lastSoldAt);
      }

      function getAdminSalesFilterMatch(record, filter) {
        if (filter === "high-value") {
          return Number(record.salesAmount || 0) >= 500000;
        }
        if (filter === "recent") {
          return Number(record.soldAt || 0) >= Date.now() - 24 * 60 * 60 * 1000;
        }
        return true;
      }

      function renderAgents(container, agentsToRender, selectedKey) {
        if (!container) {
          return;
        }

        if (!agentsToRender.length) {
          container.innerHTML = `
            <div class="empty-state empty-state--compact">
              <i data-lucide="users"></i>
              <p class="text-lg font-semibold text-ink">No agents match this view</p>
              <p class="mt-3 text-sm leading-6 text-muted">
                Try adjusting the search term or activity filter to reveal agent sales records.
              </p>
            </div>
          `;
          if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons();
          }
          return;
        }

        container.innerHTML = `
          <button type="button" class="sales-agent-card ${selectedKey ? "" : "is-active"}" data-sales-agent="all">
            <div class="sales-agent-card-head">
              <div>
                <p class="sales-agent-name">All Agents</p>
                <p class="sales-agent-meta">Combined sales stream</p>
              </div>
              <span class="status-pill">Overview</span>
            </div>
            <div class="sales-agent-stats">
              <div>
                <p class="sales-agent-stat-label">Agents</p>
                <strong class="sales-agent-stat-value">${agentsToRender.length}</strong>
              </div>
            </div>
          </button>
          ${agentsToRender
            .map(
              (agent) => `
                <button type="button" class="sales-agent-card ${selectedKey === agent.agentKey ? "is-active" : ""}" data-sales-agent="${agent.agentKey}">
                  <div class="sales-agent-card-head">
                    <div>
                      <p class="sales-agent-name">${agent.agentName}</p>
                      <p class="sales-agent-meta">${agent.outlet}</p>
                    </div>
                    <span class="sales-agent-date">${formatDate(agent.lastSoldAt)}</span>
                  </div>
                  <div class="sales-agent-stats">
                    <div>
                      <p class="sales-agent-stat-label">Transactions</p>
                      <strong class="sales-agent-stat-value">${agent.transactionCount}</strong>
                    </div>
                    <div>
                      <p class="sales-agent-stat-label">Tickets</p>
                      <strong class="sales-agent-stat-value">${agent.totalTickets}</strong>
                    </div>
                    <div>
                      <p class="sales-agent-stat-label">Sales</p>
                      <strong class="sales-agent-stat-value">${formatCurrency(agent.totalSales)}</strong>
                    </div>
                  </div>
                </button>
              `
            )
            .join("")}
        `;
      }

      function renderSalesRows(container, rows, options = {}) {
        if (!container) {
          return;
        }

        if (!rows.length) {
          const hasActiveFilter = Boolean(options.hasActiveFilter);
          container.innerHTML = `
            <tr>
              <td colspan="6">
                <div class="empty-state empty-state--compact py-10">
                  <i data-lucide="receipt-text"></i>
                  <p class="text-lg font-semibold text-ink">${hasActiveFilter ? "No matching sales found" : "No sales transactions yet"}</p>
                  <p class="mt-3 text-sm leading-6 text-muted">
                    ${hasActiveFilter
                      ? "Try adjusting the search term, filter, or selected agent."
                      : "Agent sales transactions will appear here once records are available."}
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

        container.innerHTML = rows
          .map(
            (sale) => `
              <tr>
                <td data-label="Agent">${sale.agentName}</td>
                <td data-label="Outlet">${sale.outlet}</td>
                <td data-label="Game">${sale.gameName}</td>
                <td data-label="Tickets">${sale.tickets}</td>
                <td data-label="Sales">${formatCurrency(sale.salesAmount)}</td>
                <td data-label="Date">${formatDate(sale.soldAt)}</td>
              </tr>
            `
          )
          .join("");
      }

      function getFilteredSales() {
        return sales.filter((sale) => {
          const haystack = `${sale.agentName} ${sale.outlet} ${sale.gameName}`.toLowerCase();
          const matchesSearch = haystack.includes(currentSearch);
          const matchesFilter = getAdminSalesFilterMatch(sale, currentFilter);
          const matchesAgent = selectedAgentKey ? `${sale.agentName}__${sale.outlet}` === selectedAgentKey : true;
          return matchesSearch && matchesFilter && matchesAgent;
        });
      }

      function getFilteredAgents() {
        return getAdminSalesAgents(agents, sales).filter((agent) => {
          const haystack = `${agent.agentName} ${agent.outlet}`.toLowerCase();
          const matchesSearch = haystack.includes(currentSearch);
          const proxyRecord = {
            salesAmount: agent.totalSales,
            soldAt: agent.lastSoldAt
          };
          const matchesFilter = getAdminSalesFilterMatch(proxyRecord, currentFilter);
          return matchesSearch && matchesFilter;
        });
      }

      function renderView() {
        const filteredAgents = getFilteredAgents();
        const filteredSales = getFilteredSales();
        const summary = getSalesSummary(sales);
        const selectedAgent = filteredAgents.find((agent) => agent.agentKey === selectedAgentKey);
        const selectedSalesValue = filteredSales.reduce((sum, sale) => sum + Number(sale.salesAmount || 0), 0);

        const updateText = (id, value) => {
          const el = document.getElementById(id);
          if (el) {
            el.textContent = value;
          }
        };

        updateText("adminSalesRecordsCount", String(summary.totalRecords));
        updateText("adminSalesTicketsCount", String(summary.totalTickets));
        updateText("adminSalesValueCount", formatCurrency(summary.totalSalesValue));
        updateText("adminSalesAgentsCount", String(summary.totalAgents));

        renderAgents(agentList, filteredAgents, selectedAgentKey);
        renderSalesRows(tableBody, filteredSales, {
          hasActiveFilter: Boolean(currentSearch || currentFilter !== "all" || selectedAgentKey)
        });

        if (title) {
          title.textContent = selectedAgent ? `${selectedAgent.agentName} Transactions` : "All Agent Transactions";
        }

        if (meta) {
          meta.textContent = selectedAgent
            ? `${selectedAgent.outlet} • ${selectedAgent.transactionCount} records • ${formatCurrency(selectedSalesValue)}`
            : `${filteredSales.length} records • ${formatCurrency(selectedSalesValue)}`;
        }
      }

      async function fetchData() {
        try {
          const [agentsRes, betsRes] = await Promise.all([
            axios.get(`${basePath}api/agent/all`),
            axios.get(`${basePath}api/bet/with-details`)
          ]);

          agents = Array.isArray(agentsRes?.data?.message) ? agentsRes.data.message : [];
          const bets = Array.isArray(betsRes?.data?.message) ? betsRes.data.message : [];

          sales = bets.map((bet) => {
            const outlet = [bet.agent_email, bet.agent_phone].filter(Boolean).join(" • ") || "Agent";
            const placedAt = bet.bet_placed_at || bet.placed_at || Date.now();
            const soldAtDate = new Date(placedAt);
            const stakeAmount = bet.bet_stake_amount ?? bet.stake_amount ?? 0;
            const ticketsCount = bet.bet_total_games_played ?? bet.total_games_played ?? 1;
            return {
              id: bet.bet_id || bet.id,
              agentId: bet.bet_agent_id || bet.agent_id || "",
              agentName: bet.agent_name || bet.bet_agent_id || "Agent",
              outlet,
              gameName: bet.game_name || bet.bet_game_id || "Game",
              tickets: Number(ticketsCount || 1),
              salesAmount: Number.parseFloat(stakeAmount || 0),
              soldAt: Number.isNaN(soldAtDate.getTime()) ? Date.now() : soldAtDate.getTime()
            };
          });

          renderView();
        } catch (error) {
          renderView();
        }
      }

      renderView();
      fetchData();

      searchInput?.addEventListener("input", (event) => {
        currentSearch = event.target.value.trim().toLowerCase();
        if (selectedAgentKey && !getFilteredAgents().some((agent) => agent.agentKey === selectedAgentKey)) {
          selectedAgentKey = "";
        }
        renderView();
      });

      filterTabs.forEach((tab) => {
        tab.addEventListener("click", () => {
          filterTabs.forEach((item) => item.classList.remove("is-active"));
          tab.classList.add("is-active");
          currentFilter = tab.dataset.salesFilter || "all";

          if (selectedAgentKey && !getFilteredAgents().some((agent) => agent.agentKey === selectedAgentKey)) {
            selectedAgentKey = "";
          }

          renderView();
        });
      });

      agentList?.addEventListener("click", (event) => {
        const trigger = event.target.closest("[data-sales-agent]");
        if (!trigger) {
          return;
        }

        selectedAgentKey = trigger.getAttribute("data-sales-agent") === "all"
          ? ""
          : String(trigger.getAttribute("data-sales-agent"));
        renderView();
      });
    })();
  </script>
</body>

</html>
