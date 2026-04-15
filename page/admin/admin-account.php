<?php include_once('includes/head.php'); ?>

<body class="min-h-screen bg-shell font-body text-ink" data-page="admin-account">
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
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Admin Module</p>
                <h1 class="mt-2 font-display text-3xl font-bold">Agent Accounts</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-muted">
                  Credit agent balances and monitor account funding in real time.
                </p>
              </div>
              <span class="status-pill">Wallet Control</span>
            </div>
          </header>

          <section class="mt-6 panel-card">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Agent Wallets</p>
                <h2 class="mt-2 font-display text-2xl font-bold">Balances & credits</h2>
              </div>
              <input id="accountSearch" class="form-input" type="search" placeholder="Search by agent name or code" />
            </div>

            <div class="mt-6 grid gap-4 lg:grid-cols-[1.2fr_1fr]">
              <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                <p class="text-xs uppercase tracking-[0.35em] text-muted">Total Agent Balance</p>
                <p id="totalAgentBalance" class="mt-3 font-display text-3xl font-bold text-ink">N 0</p>
                <p class="mt-2 text-sm text-muted">Live combined wallet balance for all agents.</p>
              </div>
              <div class="rounded-2xl border border-white/10 bg-white/5 p-4 flex flex-col justify-between">
                <div>
                  <p class="text-xs uppercase tracking-[0.35em] text-muted">All Transactions</p>
                  <p class="mt-3 text-sm text-muted">Review every credit and debit across agents.</p>
                </div>
                <button id="viewAllTransactions" class="action-button mt-4" type="button">
                  View All Transactions
                </button>
              </div>
            </div>

            <div class="table-wrap mt-6">
              <table class="data-table data-table--cards">
                <thead>
                  <tr>
                    <th>Agent</th>
                    <th>Email</th>
                    <th>Balance</th>
                  <th>Manage</th>
                  <th>History</th>
                </tr>
              </thead>
              <tbody id="accountTableBody"></tbody>
            </table>
          </div>
            <div id="accountPagination" class="mt-6 flex flex-wrap items-center justify-between gap-3"></div>
          </section>

          <?php include_once('includes/footer.php'); ?>
        </div>
      </main>
    </div>
  </div>

  <!-- Transactions Modal -->
  <div id="agentTransactionsModal" class="modal-backdrop" aria-hidden="true">
    <div class="modal-card">
      <div class="flex items-start justify-between gap-4">
        <div>
          <p class="text-sm uppercase tracking-[0.35em] text-muted">Wallet History</p>
          <h2 class="mt-2 font-display text-2xl font-bold">Agent Transactions</h2>
          <p id="agentTransactionsTitle" class="mt-3 text-sm text-muted"></p>
        </div>
        <button id="closeAgentTransactionsModal" type="button" class="topbar-menu-button" aria-label="Close modal">
          <i data-lucide="x"></i>
        </button>
      </div>
      <div id="agentTransactionsBody" class="mt-6"></div>
    </div>
  </div>

  <!-- All Transactions Modal -->
  <div id="allTransactionsModal" class="modal-backdrop" aria-hidden="true">
    <div class="modal-card">
      <div class="flex items-start justify-between gap-4">
        <div>
          <p class="text-sm uppercase tracking-[0.35em] text-muted">Wallet History</p>
          <h2 class="mt-2 font-display text-2xl font-bold">All Agent Transactions</h2>
          <p class="mt-3 text-sm text-muted">Overview of every wallet movement.</p>
        </div>
        <button id="closeAllTransactionsModal" type="button" class="topbar-menu-button" aria-label="Close modal">
          <i data-lucide="x"></i>
        </button>
      </div>
      <div class="mt-6 grid gap-3 lg:grid-cols-[1.4fr_0.8fr_0.9fr_0.9fr]">
        <input id="allTxnSearch" class="form-input" type="search" placeholder="Search agent name, email, or ID" />
        <select id="allTxnType" class="form-input">
          <option value="">All types</option>
          <option value="credit">Credit</option>
          <option value="debit">Debit</option>
        </select>
        <input id="allTxnFrom" class="form-input" type="date" />
        <input id="allTxnTo" class="form-input" type="date" />
      </div>
      <div id="allTransactionsBody" class="mt-6"></div>
    </div>
  </div>

  <!-- Balance Modal -->
  <div id="agentBalanceModal" class="modal-backdrop" aria-hidden="true">
    <div class="modal-card">
      <div class="flex items-start justify-between gap-4">
        <div>
          <p class="text-sm uppercase tracking-[0.35em] text-muted">Wallet Control</p>
          <h2 class="mt-2 font-display text-2xl font-bold">Manage Balance</h2>
          <p id="agentBalanceTitle" class="mt-3 text-sm text-muted"></p>
        </div>
        <button id="closeAgentBalanceModal" type="button" class="topbar-menu-button" aria-label="Close modal">
          <i data-lucide="x"></i>
        </button>
      </div>

      <div class="mt-6 grid gap-4 lg:grid-cols-[1.1fr_1fr]">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
          <p class="text-xs uppercase tracking-[0.35em] text-muted">Current Balance</p>
          <p id="agentBalanceAmount" class="mt-3 font-display text-3xl font-bold text-ink">N 0</p>
          <p class="mt-2 text-sm text-muted">Use credit or debit to adjust the wallet.</p>
        </div>

        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
          <label class="text-sm font-medium text-ink">Amount</label>
          <input id="agentBalanceInput" class="form-input mt-2" type="number" min="100" max="20000" step="100" placeholder="Enter amount (100 - 20,000)" />
          <div class="mt-4 flex flex-wrap items-center gap-2">
            <button id="agentBalanceCredit" class="action-button action-button-soft" type="button">
              Credit Wallet
            </button>
            <button id="agentBalanceDebit" class="action-button" type="button">
              Debit Wallet
            </button>
          </div>
          <p class="mt-3 text-xs text-muted">Credits add to the wallet. Debits subtract from the wallet.</p>
        </div>
      </div>
    </div>
  </div>

  <?php include_once('includes/scripts.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    (function () {
      const basePath = "/lt/";
      const tbody = document.getElementById("accountTableBody");
      const searchInput = document.getElementById("accountSearch");
      const paginationEl = document.getElementById("accountPagination");
      const totalBalanceEl = document.getElementById("totalAgentBalance");
      const viewAllTransactionsBtn = document.getElementById("viewAllTransactions");
      const transactionsModal = document.getElementById("agentTransactionsModal");
      const closeTransactionsModalBtn = document.getElementById("closeAgentTransactionsModal");
      const transactionsBody = document.getElementById("agentTransactionsBody");
      const transactionsTitle = document.getElementById("agentTransactionsTitle");
      const allTransactionsModal = document.getElementById("allTransactionsModal");
      const closeAllTransactionsModalBtn = document.getElementById("closeAllTransactionsModal");
      const allTransactionsBody = document.getElementById("allTransactionsBody");
      const allTxnSearch = document.getElementById("allTxnSearch");
      const allTxnType = document.getElementById("allTxnType");
      const allTxnFrom = document.getElementById("allTxnFrom");
      const allTxnTo = document.getElementById("allTxnTo");
      const balanceModal = document.getElementById("agentBalanceModal");
      const closeBalanceModalBtn = document.getElementById("closeAgentBalanceModal");
      const balanceTitle = document.getElementById("agentBalanceTitle");
      const balanceAmount = document.getElementById("agentBalanceAmount");
      const balanceInput = document.getElementById("agentBalanceInput");
      const balanceCreditBtn = document.getElementById("agentBalanceCredit");
      const balanceDebitBtn = document.getElementById("agentBalanceDebit");
      const pageSize = 8;
      let currentPage = 1;
      let agents = [];
      let search = "";
      let activeAgent = null;
      let allTransactions = [];

      function formatCurrency(value) {
        return `N ${Number(value || 0).toLocaleString()}`;
      }

      function applyFilters() {
        const filtered = agents.filter((agent) => {
          const haystack = `${agent.name} ${agent.id} ${agent.email}`.toLowerCase();
          return haystack.includes(search);
        });

        const totalPages = Math.max(1, Math.ceil(filtered.length / pageSize));
        if (currentPage > totalPages) currentPage = totalPages;
        const start = (currentPage - 1) * pageSize;
        const pageItems = filtered.slice(start, start + pageSize);

        renderRows(pageItems);
        renderPagination(filtered.length, start, start + pageItems.length, totalPages);
      }

      function updateTotalBalance() {
        if (!totalBalanceEl) return;
        const total = agents.reduce((sum, agent) => sum + Number(agent.balance || 0), 0);
        totalBalanceEl.textContent = formatCurrency(total);
      }

      function renderRows(rows) {
        if (!tbody) return;
        if (!rows.length) {
          tbody.innerHTML = `
            <tr>
              <td colspan="5">
                <div class="empty-state empty-state--compact py-6">
                  <i data-lucide="wallet"></i>
                  <p class="text-lg font-semibold text-ink">No agents found</p>
                </div>
              </td>
            </tr>
          `;
          if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons();
          }
          return;
        }

        tbody.innerHTML = rows.map((agent) => `
          <tr>
            <td data-label="Agent">
              <p class="text-sm font-semibold text-ink">${agent.name || agent.id}</p>
              <p class="text-xs text-muted">${agent.id}</p>
            </td>
            <td data-label="Email">${agent.email || "N/A"}</td>
            <td data-label="Balance"><strong>${formatCurrency(agent.balance || 0)}</strong></td>
            <td data-label="Manage">
              <button class="action-button action-button-soft" type="button" data-manage-balance="${agent.id}">
                Manage
              </button>
            </td>
            <td data-label="History">
              <button class="action-button action-button-soft" type="button" data-view-transactions="${agent.id}">
                View
              </button>
            </td>
          </tr>
        `).join("");
      }

      function renderPagination(totalCount, start, end, totalPages) {
        if (!paginationEl) return;
        paginationEl.innerHTML = `
          <div class="text-sm text-muted">
            Showing ${totalCount ? start + 1 : 0}-${Math.min(end, totalCount)} of ${totalCount}
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

      function openTransactionsModal(agent, rows) {
        if (!transactionsModal || !transactionsBody) return;
        if (transactionsTitle) {
          transactionsTitle.textContent = `${agent.name || agent.id} - ${agent.id}`;
        }

        if (!rows.length) {
          transactionsBody.innerHTML = `
            <div class="empty-state empty-state--compact">
              <i data-lucide="wallet"></i>
              <p class="text-lg font-semibold text-ink">No transactions yet</p>
              <p class="mt-3 text-sm leading-6 text-muted">Credits and debits will appear here.</p>
            </div>
          `;
        } else {
          transactionsBody.innerHTML = `
            <div class="table-wrap">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Balance After</th>
                    <th>Reference</th>
                    <th>Note</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  ${rows.map((txn) => `
                    <tr>
                      <td data-label="Type"><span class="status-pill ${txn.type === 'credit' ? 'status-pill--positive' : 'status-pill--warning'}">${txn.type}</span></td>
                      <td data-label="Amount">${formatCurrency(txn.amount || 0)}</td>
                      <td data-label="Balance">${formatCurrency(txn.balance_after || 0)}</td>
                      <td data-label="Reference">${txn.reference || "-"}</td>
                      <td data-label="Note">${txn.note || "-"}</td>
                      <td data-label="Date">${txn.created_at ? new Date(txn.created_at).toLocaleString("en-NG") : "N/A"}</td>
                    </tr>
                  `).join("")}
                </tbody>
              </table>
            </div>
          `;
        }

        if (window.lucide && typeof window.lucide.createIcons === "function") {
          window.lucide.createIcons();
        }
        transactionsModal.classList.add("is-open");
        document.body.classList.add("overflow-hidden");
      }

      function closeTransactionsModal() {
        transactionsModal?.classList.remove("is-open");
        document.body.classList.remove("overflow-hidden");
      }

      function openBalanceModal(agent) {
        activeAgent = agent;
        if (balanceTitle) {
          balanceTitle.textContent = `${agent.name || agent.id} - ${agent.id}`;
        }
        if (balanceAmount) {
          balanceAmount.textContent = formatCurrency(agent.balance || 0);
        }
        if (balanceInput) {
          balanceInput.value = "";
        }
        balanceModal?.classList.add("is-open");
        document.body.classList.add("overflow-hidden");
        if (window.lucide && typeof window.lucide.createIcons === "function") {
          window.lucide.createIcons();
        }
      }

      function closeBalanceModal() {
        balanceModal?.classList.remove("is-open");
        document.body.classList.remove("overflow-hidden");
      }

      function renderAllTransactions(rows) {
        if (!allTransactionsModal || !allTransactionsBody) return;
        if (!rows.length) {
          allTransactionsBody.innerHTML = `
            <div class="empty-state empty-state--compact">
              <i data-lucide="wallet"></i>
              <p class="text-lg font-semibold text-ink">No transactions yet</p>
              <p class="mt-3 text-sm leading-6 text-muted">Credits and debits will appear here.</p>
            </div>
          `;
        } else {
          allTransactionsBody.innerHTML = `
            <div class="table-wrap">
              <table class="data-table data-table--cards">
                <thead>
                  <tr>
                    <th>Agent</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Balance After</th>
                    <th>Reference</th>
                    <th>Note</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  ${rows.map((txn) => `
                    <tr>
                      <td data-label="Agent">
                        <p class="text-sm font-semibold text-ink">${txn.agent_name || txn.agent_id}</p>
                        <p class="text-xs text-muted">${txn.agent_id}</p>
                      </td>
                      <td data-label="Type"><span class="status-pill ${txn.type === 'credit' ? 'status-pill--positive' : 'status-pill--warning'}">${txn.type}</span></td>
                      <td data-label="Amount">${formatCurrency(txn.amount || 0)}</td>
                      <td data-label="Balance">${formatCurrency(txn.balance_after || 0)}</td>
                      <td data-label="Reference">${txn.reference || "-"}</td>
                      <td data-label="Note">${txn.note || "-"}</td>
                      <td data-label="Date">${txn.created_at ? new Date(txn.created_at).toLocaleString("en-NG") : "N/A"}</td>
                    </tr>
                  `).join("")}
                </tbody>
              </table>
            </div>
          `;
        }

        if (window.lucide && typeof window.lucide.createIcons === "function") {
          window.lucide.createIcons();
        }
      }

      function applyAllTransactionsFilters() {
        const searchValue = allTxnSearch?.value.trim().toLowerCase() || "";
        const typeValue = allTxnType?.value || "";
        const fromValue = allTxnFrom?.value || "";
        const toValue = allTxnTo?.value || "";

        const filtered = allTransactions.filter((txn) => {
          const haystack = `${txn.agent_name || ""} ${txn.agent_email || ""} ${txn.agent_id || ""}`.toLowerCase();
          if (searchValue && !haystack.includes(searchValue)) return false;
          if (typeValue && (txn.type || "").toLowerCase() !== typeValue) return false;
          if (fromValue) {
            const created = txn.created_at ? new Date(txn.created_at) : null;
            if (!created || created < new Date(`${fromValue}T00:00:00`)) return false;
          }
          if (toValue) {
            const created = txn.created_at ? new Date(txn.created_at) : null;
            if (!created || created > new Date(`${toValue}T23:59:59`)) return false;
          }
          return true;
        });

        renderAllTransactions(filtered);
      }

      function openAllTransactionsModal(rows) {
        if (!allTransactionsModal) return;
        allTransactions = Array.isArray(rows) ? rows : [];
        applyAllTransactionsFilters();
        allTransactionsModal.classList.add("is-open");
        document.body.classList.add("overflow-hidden");
      }

      function closeAllTransactionsModal() {
        allTransactionsModal?.classList.remove("is-open");
        document.body.classList.remove("overflow-hidden");
      }

      async function loadAgents() {
        try {
          const response = await axios.get(`${basePath}api/agent/all`);
          agents = Array.isArray(response?.data?.message) ? response.data.message : [];
          updateTotalBalance();
          applyFilters();
        } catch {
          agents = [];
          updateTotalBalance();
          applyFilters();
        }
      }

      async function submitBalanceChange(type) {
        if (!activeAgent) return;
        const amount = Number(balanceInput?.value || 0);
        if (!amount || amount < 100 || amount > 20000) {
          window.showToast?.("Amount must be between 100 and 20,000.", "error", "Invalid amount");
          return;
        }

        const endpoint = type === "debit" ? "debit" : "credit";
        try {
          const response = await axios.post(`${basePath}api/agent/${endpoint}`, {
            agent_id: activeAgent.id,
            amount
          });
          if (response?.data?.state) {
            await loadAgents();
            const refreshed = agents.find((item) => item.id === activeAgent.id) || activeAgent;
            activeAgent = refreshed;
            if (balanceAmount) {
              balanceAmount.textContent = formatCurrency(refreshed.balance || 0);
            }
            if (balanceInput) {
              balanceInput.value = "";
            }
            window.showToast?.(
              type === "debit" ? "Agent debited successfully." : "Agent credited successfully.",
              "success",
              type === "debit" ? "Wallet debited" : "Wallet credited"
            );
            return;
          }
          window.showToast?.(response?.data?.message || "Failed to update balance.", "error", "Balance update failed");
        } catch (error) {
          window.showToast?.(error?.response?.data?.message || "Failed to update balance.", "error", "Balance update failed");
        }
      }

      tbody?.addEventListener("click", async (event) => {
        const manageTrigger = event.target.closest("[data-manage-balance]");
        const viewTrigger = event.target.closest("[data-view-transactions]");
        if (viewTrigger) {
          const agentId = viewTrigger.getAttribute("data-view-transactions");
          const agent = agents.find((item) => item.id === agentId);
          if (!agent) return;
          try {
            const response = await axios.get(`${basePath}api/agent/transactions`, { params: { agent_id: agentId } });
            const rows = Array.isArray(response?.data?.message) ? response.data.message : [];
            openTransactionsModal(agent, rows);
          } catch (error) {
            openTransactionsModal(agent, []);
          }
          return;
        }
        if (!manageTrigger) return;
        const agentId = manageTrigger.getAttribute("data-manage-balance");
        const agent = agents.find((item) => item.id === agentId);
        if (!agent) return;
        openBalanceModal(agent);
      });

      paginationEl?.addEventListener("click", (event) => {
        const action = event.target.closest("[data-page-action]")?.getAttribute("data-page-action");
        if (!action) return;
        if (action === "prev" && currentPage > 1) currentPage -= 1;
        if (action === "next") {
          const filteredCount = agents.filter((agent) => {
            const haystack = `${agent.name} ${agent.id} ${agent.email}`.toLowerCase();
            return haystack.includes(search);
          }).length;
          const totalPages = Math.max(1, Math.ceil(filteredCount / pageSize));
          if (currentPage < totalPages) currentPage += 1;
        }
        applyFilters();
      });

      searchInput?.addEventListener("input", (event) => {
        search = event.target.value.trim().toLowerCase();
        currentPage = 1;
        applyFilters();
      });

      closeTransactionsModalBtn?.addEventListener("click", closeTransactionsModal);
      transactionsModal?.addEventListener("click", (event) => {
        if (event.target === transactionsModal) {
          closeTransactionsModal();
        }
      });
      closeAllTransactionsModalBtn?.addEventListener("click", closeAllTransactionsModal);
      allTransactionsModal?.addEventListener("click", (event) => {
        if (event.target === allTransactionsModal) {
          closeAllTransactionsModal();
        }
      });
      viewAllTransactionsBtn?.addEventListener("click", async () => {
        try {
          const response = await axios.get(`${basePath}api/agent/transactions-all`);
          const rows = Array.isArray(response?.data?.message) ? response.data.message : [];
          openAllTransactionsModal(rows);
        } catch (error) {
          openAllTransactionsModal([]);
        }
      });
      allTxnSearch?.addEventListener("input", applyAllTransactionsFilters);
      allTxnType?.addEventListener("change", applyAllTransactionsFilters);
      allTxnFrom?.addEventListener("change", applyAllTransactionsFilters);
      allTxnTo?.addEventListener("change", applyAllTransactionsFilters);
      closeBalanceModalBtn?.addEventListener("click", closeBalanceModal);
      balanceModal?.addEventListener("click", (event) => {
        if (event.target === balanceModal) {
          closeBalanceModal();
        }
      });
      balanceCreditBtn?.addEventListener("click", () => submitBalanceChange("credit"));
      balanceDebitBtn?.addEventListener("click", () => submitBalanceChange("debit"));

      loadAgents();
    })();
  </script>
</body>

</html>
