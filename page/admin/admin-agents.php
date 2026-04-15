<?php include_once('includes/head.php'); ?>

<body class="min-h-screen bg-shell font-body text-ink" data-page="admin-agents">
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
                      <!-- Header -->
            <header class="topbar-offset rounded-[2rem] border border-white/10 bg-white/5 px-6 py-5 shadow-panel backdrop-blur-xl">
              <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                  <p class="text-sm uppercase tracking-[0.35em] text-muted">Admin Module</p>
                  <h1 class="mt-2 font-display text-3xl font-bold">Agent Management</h1>
                  <p class="mt-3 max-w-2xl text-sm leading-6 text-muted">
                    Manage all platform agents, review outlet assignments, and create new agent accounts with login details.
                  </p>
                </div>
                <span class="status-pill">Agent Control</span>
              </div>
            </header>

          <!-- Agent Stats -->
          <section class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <article class="stat-card">
              <p class="stat-label">Total Agents</p>
              <h3 id="totalAgentsCount" class="stat-value">0</h3>
              <p class="stat-meta text-accent">All registered accounts</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Active Agents</p>
              <h3 id="activeAgentsCount" class="stat-value">0</h3>
              <p class="stat-meta text-accentSoft">Currently operational</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Suspended Agents</p>
              <h3 id="suspendedAgentsCount" class="stat-value">0</h3>
              <p class="stat-meta text-accentBright">Restricted accounts</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Total Balance</p>
              <h3 id="agentsBalanceCount" class="stat-value">N 0</h3>
              <p class="stat-meta text-accent">Combined wallet balance</p>
            </article>
          </section>

          <!-- Content -->
          <section class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-12">
            <article class="panel-card xl:col-span-12">
              <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                  <p class="text-sm uppercase tracking-[0.35em] text-muted">Agent Directory</p>
                  <h2 class="mt-2 font-display text-2xl font-bold">Manage all agents</h2>
                </div>
                <button id="openCreateAgentModal" type="button" class="action-button">Create Agent</button>
              </div>
              <div class="mt-6 grid gap-4 lg:grid-cols-[1fr_auto]">
                <input id="agentSearchInput" type="text" class="form-input"
                  placeholder="Search by name, code, outlet or region" />
              </div>
              <div id="agentsCardGrid" class="agent-grid mt-6"></div>
              <div id="agentsSkeletons" class="skeleton-grid mt-6"></div>
              <div id="agentsPagination" class="mt-6 flex flex-wrap items-center justify-between gap-3"></div>
              <div id="agentsFeedSentinel" class="feed-sentinel"></div>
            </article>
          </section>

          <!-- Footer -->
          <?php include_once('includes/footer.php'); ?>
        </div>
      </main>
    </div>
  </div>

  <!-- Create Agent Modal -->
  <div id="createAgentModal" class="modal-backdrop">
    <div class="modal-card">
      <div class="flex items-start justify-between gap-4">
        <div>
          <p class="text-sm uppercase tracking-[0.35em] text-muted">Create Agent</p>
          <h2 class="mt-2 font-display text-2xl font-bold">Register a new agent</h2>
        </div>
        <button id="closeCreateAgentModal" type="button" class="topbar-menu-button" aria-label="Close modal">
          <i data-lucide="x"></i>
        </button>
      </div>

      <form id="createAgentForm" class="mt-6 form-grid">
        <div>
          <label class="auth-label" for="agentName">Agent Name</label>
          <input id="agentName" name="agentName" type="text" class="form-input" placeholder="Samuel Ade" required />
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
          <div>
            <label class="auth-label" for="agentCode">Agent Code</label>
            <input id="agentCode" name="agentCode" type="text" class="form-input" placeholder="AG114" required />
            <label class="mt-3 inline-flex items-center gap-3 text-sm text-muted">
              <input id="autoAgentCode" type="checkbox"
                class="h-4 w-4 rounded border-white/20 bg-transparent text-accent focus:ring-accent" />
              Auto-generate code
            </label>
          </div>
          <div>
            <label class="auth-label" for="phoneNumber">Phone Number</label>
            <input id="phoneNumber" name="phoneNumber" type="text" class="form-input" placeholder="0803 000 0114"
              required />
          </div>
        </div>
        <div>
          <label class="auth-label" for="agentEmail">Email</label>
          <input id="agentEmail" name="agentEmail" type="email" class="form-input" placeholder="agent@company.com"
            required />
        </div>
        <button id="createAgentButton" type="submit" class="action-button">Create Agent</button>
      </form>
    </div>
  </div>

  <!-- View Agent Modal -->
  <div id="viewAgentModal" class="modal-backdrop">
    <div class="modal-card">
      <div class="flex items-start justify-between gap-4">
        <div>
          <p class="text-sm uppercase tracking-[0.35em] text-muted">Agent Profile</p>
          <h2 class="mt-2 font-display text-2xl font-bold">View agent details</h2>
        </div>
        <button id="closeViewAgentModal" type="button" class="topbar-menu-button" aria-label="Close modal">
          <i data-lucide="x"></i>
        </button>
      </div>
      <div id="viewAgentBody" class="mt-6"></div>
    </div>
  </div>

  <!-- Edit Agent Modal -->
  <div id="editAgentModal" class="modal-backdrop">
    <div class="modal-card">
      <div class="flex items-start justify-between gap-4">
        <div>
          <p class="text-sm uppercase tracking-[0.35em] text-muted">Edit Agent</p>
          <h2 class="mt-2 font-display text-2xl font-bold">Update agent details</h2>
        </div>
        <button id="closeEditAgentModal" type="button" class="topbar-menu-button" aria-label="Close modal">
          <i data-lucide="x"></i>
        </button>
      </div>

      <form id="editAgentForm" class="mt-6 form-grid">
        <input id="editAgentId" name="agentId" type="hidden" />
        <div>
          <label class="auth-label" for="editAgentName">Agent Name</label>
          <input id="editAgentName" name="agentName" type="text" class="form-input" required />
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
          <div>
            <label class="auth-label" for="editAgentCode">Agent Code</label>
            <input id="editAgentCode" name="agentCode" type="text" class="form-input" required />
          </div>
          <div>
            <label class="auth-label" for="editPhoneNumber">Phone Number</label>
            <input id="editPhoneNumber" name="phoneNumber" type="text" class="form-input" required />
          </div>
        </div>
        <div>
          <label class="auth-label" for="editAgentEmail">Email</label>
          <input id="editAgentEmail" name="agentEmail" type="email" class="form-input" required />
        </div>
        <button id="editAgentButton" type="submit" class="action-button">Save Changes</button>
      </form>
    </div>
  </div>

  <!-- Page Scripts -->
  <?php include_once('includes/scripts.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    (function () {
      const basePath = "/lt/";
      const cardGrid = document.getElementById("agentsCardGrid");
      const skeletons = document.getElementById("agentsSkeletons");
      const searchInput = document.getElementById("agentSearchInput");
      const paginationEl = document.getElementById("agentsPagination");
      const pageSize = 8;
      let currentPage = 1;

      const createModal = document.getElementById("createAgentModal");
      const openCreateModalButton = document.getElementById("openCreateAgentModal");
      const closeCreateModalButton = document.getElementById("closeCreateAgentModal");
      const createForm = document.getElementById("createAgentForm");
      const autoAgentCodeToggle = document.getElementById("autoAgentCode");
      const createAgentButton = document.getElementById("createAgentButton");

      const viewModal = document.getElementById("viewAgentModal");
      const viewBody = document.getElementById("viewAgentBody");
      const closeViewModalButton = document.getElementById("closeViewAgentModal");

      const editModal = document.getElementById("editAgentModal");
      const closeEditModalButton = document.getElementById("closeEditAgentModal");
      const editForm = document.getElementById("editAgentForm");
      const editAgentButton = document.getElementById("editAgentButton");

      let agents = [];
      let bets = [];
      let currentSearch = "";

      function formatCurrency(value) {
        return `N ${Number(value || 0).toLocaleString()}`;
      }

      function getInitials(name) {
        return String(name || "")
          .trim()
          .split(/\s+/)
          .slice(0, 2)
          .map((part) => part.charAt(0).toUpperCase())
          .join("");
      }

      function getStatusTone(value) {
        const normalized = String(value || "").toLowerCase();
        if (["active"].includes(normalized)) return "status-pill--positive";
        if (["suspended"].includes(normalized)) return "status-pill--warning";
        return "";
      }

      function normalizeAgent(agent) {
        const isSuspended = Number(agent.suspendAgent || 0) === 1;
        const status = isSuspended ? "suspended" : "active";
        const outlet = agent.outlet || agent.region || "Outlet";
        return {
          id: agent.id,
          name: agent.name || "Agent",
          agentCode: agent.id,
          outlet,
          region: "",
          phone: agent.phone || "N/A",
          email: agent.email || "",
          status,
          balance: 0,
          username: agent.id,
          password: "N/A",
          raw: agent
        };
      }

      function getAgentAggregates(agentId) {
        const agentBets = bets.filter((bet) => (bet.bet_agent_id || bet.agent_id) === agentId);
        const totalStake = agentBets.reduce((sum, bet) => {
          const stake = bet.bet_stake_amount ?? bet.stake_amount ?? 0;
          return sum + Number.parseFloat(stake || 0);
        }, 0);
        const totalGamesPlayed = agentBets.reduce((sum, bet) => {
          const gamesPlayed = bet.bet_total_games_played ?? bet.total_games_played ?? 1;
          return sum + Number(gamesPlayed || 0);
        }, 0);
        return { totalStake, totalGamesPlayed };
      }

      function renderStats(list) {
        const totalAgents = list.length;
        const activeAgents = list.filter((item) => item.status === "active").length;
        const suspendedAgents = list.filter((item) => item.status === "suspended").length;
        const totalBalance = list.reduce((sum, item) => sum + Number(item.balance || 0), 0);

        const update = (id, value) => {
          const el = document.getElementById(id);
          if (el) el.textContent = value;
        };

        update("totalAgentsCount", String(totalAgents));
        update("activeAgentsCount", String(activeAgents));
        update("suspendedAgentsCount", String(suspendedAgents));
        update("agentsBalanceCount", formatCurrency(totalBalance));
      }

      function renderAgents(list) {
        if (!cardGrid) return;

        if (!list.length) {
          cardGrid.innerHTML = `
            <div class="empty-state">
              <i data-lucide="users"></i>
              <p class="text-lg font-semibold text-ink">No agents found</p>
              <p class="mt-3 text-sm leading-6 text-muted">
                Try adjusting the search or filter, or create a new agent.
              </p>
            </div>
          `;
          if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons();
          }
          return;
        }

        cardGrid.innerHTML = list
          .map(
            (agent) => `
              <article class="agent-card">
                <div class="agent-card-head">
                  <div class="agent-card-profile">
                    <span class="initial-avatar">${getInitials(agent.name)}</span>
                    <div>
                      <p class="agent-card-name">${agent.name}</p>
                      <p class="agent-card-meta">${agent.agentCode} · ${agent.outlet}</p>
                    </div>
                  </div>
                </div>

                <div class="agent-wallet-panel">
                  <p class="agent-wallet-label">Total Transactions</p>
                  <p class="agent-wallet-value">${formatCurrency(agent.balance || 0).replace("N", "₦")}</p>
                </div>

                <div class="agent-card-stats">
                  <div class="agent-card-stat">
                    <p class="agent-card-stat-label">Games Played</p>
                    <strong class="agent-card-stat-value">${agent.totalGamesPlayed || 0}</strong>
                  </div>
                  <div class="agent-card-stat">
                    <p class="agent-card-stat-label">Total Games Played</p>
                    <strong class="agent-card-stat-value">${agent.totalGamesPlayed || 0}</strong>
                  </div>
                </div>

                <div class="agent-card-submeta">
                  <span>${agent.region || ""}</span>
                </div>

                <div class="agent-card-actions">
                  <button class="action-button action-button-soft" type="button" data-view-agent="${agent.id}">
                    View
                  </button>
                </div>
              </article>
            `
          )
          .join("");
      }

      function renderPagination(filteredAgents) {
        if (!paginationEl) {
          return;
        }

        const totalPages = Math.max(1, Math.ceil(filteredAgents.length / pageSize));
        if (currentPage > totalPages) {
          currentPage = totalPages;
        }

        const start = (currentPage - 1) * pageSize;
        const end = start + pageSize;
        const pageItems = filteredAgents.slice(start, end);

        renderAgents(pageItems);

        paginationEl.innerHTML = `
          <div class="text-sm text-muted">
            Showing ${filteredAgents.length ? start + 1 : 0}-${Math.min(end, filteredAgents.length)} of ${filteredAgents.length}
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

      function renderView(agent) {
        if (!viewBody || !agent) return;

        viewBody.innerHTML = `
          <div class="flex items-start gap-4">
            <span class="initial-avatar initial-avatar--large">${getInitials(agent.name)}</span>
            <div>
              <p class="text-2xl font-semibold text-ink">${agent.name}</p>
              <p class="mt-2 text-sm text-muted">${agent.outlet}</p>
              <p class="mt-3"><span class="status-pill ${getStatusTone(agent.status)}">${agent.status}</span></p>
            </div>
          </div>
          <div class="mt-6 grid gap-4 sm:grid-cols-2">
            <div class="soft-card">
              <p class="result-label">Agent Code</p>
              <p class="mt-2 text-lg font-semibold text-ink">${agent.agentCode}</p>
            </div>
            <div class="soft-card">
              <p class="result-label">Email</p>
              <p class="mt-2 text-lg font-semibold text-ink">${agent.email || 'N/A'}</p>
            </div>
            <div class="soft-card">
              <p class="result-label">Phone</p>
              <p class="mt-2 text-lg font-semibold text-ink">${agent.phone}</p>
            </div>
            <div class="soft-card">
              <p class="result-label">Username</p>
              <p class="mt-2 text-lg font-semibold text-ink">${agent.username}</p>
            </div>
            <div class="soft-card">
              <p class="result-label">Balance</p>
              <p class="mt-2 text-lg font-semibold text-ink">${formatCurrency(agent.balance || 0)}</p>
            </div>
            <div class="soft-card">
              <p class="result-label">Quick Actions</p>
              <div class="agent-card-actions mt-4">
                <button class="action-button action-button-soft" type="button" data-modal-toggle-agent="${agent.id}">
                  ${agent.status === 'active' ? 'Suspend' : 'Activate'}
                </button>
                <button class="action-button action-button-soft" type="button" data-edit-agent="${agent.id}">Edit</button>
                <button class="action-button action-button-danger" type="button" data-delete-agent="${agent.id}">Delete</button>
              </div>
            </div>
            <div class="soft-card">
              <p class="result-label">Credit Dummy Money</p>
              <div class="mt-2 flex items-center gap-2">
                <input id="creditAmountInput" type="number" min="0" step="0.01" class="form-input" placeholder="Amount" />
                <button class="action-button" type="button" data-credit-agent="${agent.id}">Credit</button>
              </div>
            </div>
          </div>
        `;
      }

      function applyFilters() {
        const filtered = agents.filter((agent) => {
          const haystack = `${agent.name} ${agent.agentCode} ${agent.outlet} ${agent.phone}`.toLowerCase();
          const matchesSearch = haystack.includes(currentSearch);
          return matchesSearch;
        });

        renderStats(agents);
        renderPagination(filtered);
      }

      function openModal(modal) {
        modal?.classList.add("is-open");
        document.body.classList.add("overflow-hidden");
      }

      function closeModal(modal) {
        modal?.classList.remove("is-open");
        document.body.classList.remove("overflow-hidden");
      }

      function setButtonLoading(button, isLoading, idleText) {
        if (!button) return;
        if (isLoading) {
          button.disabled = true;
          button.dataset.originalText = idleText || button.textContent;
          button.innerHTML = `
            <span class="inline-flex items-center gap-2">
              <span class="h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white"></span>
              Processing...
            </span>
          `;
          return;
        }
        button.disabled = false;
        const text = button.dataset.originalText || idleText || "Submit";
        button.textContent = text;
      }

      async function fetchAgents() {
        if (skeletons) {
          skeletons.classList.remove("hidden");
          skeletons.innerHTML = "";
        }
        try {
          const agentsRes = await axios.get(`${basePath}api/agent/all`);
          const rows = Array.isArray(agentsRes?.data?.message) ? agentsRes.data.message : [];
          try {
            const betsRes = await axios.get(`${basePath}api/bet/with-details`);
            bets = Array.isArray(betsRes?.data?.message) ? betsRes.data.message : [];
          } catch (betError) {
            // If no bets exist yet, keep agents visible and treat bets as empty.
            bets = [];
          }

          agents = rows.map((row) => {
            const normalized = normalizeAgent(row);
            const aggregates = getAgentAggregates(normalized.id);
            return {
              ...normalized,
              balance: aggregates.totalStake,
              totalGamesPlayed: aggregates.totalGamesPlayed
            };
          });
          applyFilters();
        } catch {
          agents = [];
          bets = [];
          applyFilters();
        } finally {
          if (skeletons) {
            skeletons.classList.add("hidden");
          }
        }
      }

      async function createAgent(payload) {
        return axios.post(`${basePath}api/agent/create`, payload);
      }

      async function updateAgent(agentId, payload) {
        return axios.post(`${basePath}api/agent/update`, { agent_id: agentId, ...payload });
      }

      async function toggleAgent(agentId, suspendAgent) {
        return axios.post(`${basePath}api/agent/suspend`, { agent_id: agentId, suspendAgent: suspendAgent ? 1 : 0 });
      }

      openCreateModalButton?.addEventListener("click", () => openModal(createModal));
      closeCreateModalButton?.addEventListener("click", () => closeModal(createModal));
      closeViewModalButton?.addEventListener("click", () => closeModal(viewModal));
      closeEditModalButton?.addEventListener("click", () => closeModal(editModal));

      createModal?.addEventListener("click", (event) => {
        if (event.target === createModal) {
          closeModal(createModal);
        }
      });
      viewModal?.addEventListener("click", (event) => {
        if (event.target === viewModal) {
          closeModal(viewModal);
        }
      });
      editModal?.addEventListener("click", (event) => {
        if (event.target === editModal) {
          closeModal(editModal);
        }
      });

      function generateAgentCode() {
        const suffix = Math.floor(1000 + Math.random() * 9000);
        return `AG${suffix}`;
      }

      autoAgentCodeToggle?.addEventListener("change", (event) => {
        const agentCodeInput = document.getElementById("agentCode");
        if (!agentCodeInput) {
          return;
        }
        if (event.target.checked) {
          agentCodeInput.value = generateAgentCode();
          agentCodeInput.setAttribute("readonly", "readonly");
        } else {
          agentCodeInput.removeAttribute("readonly");
          agentCodeInput.value = "";
        }
      });

      createForm?.addEventListener("submit", async (event) => {
        event.preventDefault();
        const agentName = document.getElementById("agentName").value.trim();
        let agentCode = document.getElementById("agentCode").value.trim();
        const phoneNumber = document.getElementById("phoneNumber").value.trim();
        const agentEmailInput = document.getElementById("agentEmail").value.trim();

        if (!agentName || !phoneNumber || !agentEmailInput) {
          window.showToast?.("Please fill all required fields.", "error", "Missing data");
          return;
        }

        if (!agentCode) {
          agentCode = generateAgentCode();
        }

        const email = agentEmailInput;

        try {
          setButtonLoading(createAgentButton, true, "Create Agent");
          const response = await createAgent({
            id: agentCode,
            name: agentName,
            email,
            phone: phoneNumber
          });

          if (response?.data?.state) {
            createForm.reset();
            closeModal(createModal);
            await fetchAgents();
            window.showToast?.("Agent created successfully.", "success", "Agent created");
            setButtonLoading(createAgentButton, false, "Create Agent");
            return;
          }
          window.showToast?.(response?.data?.message || "Failed to create agent.", "error", "Create failed");
          setButtonLoading(createAgentButton, false, "Create Agent");
        } catch (error) {
          window.showToast?.(error?.response?.data?.message || "Failed to create agent.", "error", "Create failed");
          setButtonLoading(createAgentButton, false, "Create Agent");
        }
      });

      cardGrid?.addEventListener("click", (event) => {
        const viewTrigger = event.target.closest("[data-view-agent]");
        const editTrigger = event.target.closest("[data-edit-agent]");
        const deleteTrigger = event.target.closest("[data-delete-agent]");
        if (viewTrigger) {
          const agentId = viewTrigger.getAttribute("data-view-agent");
          const agent = agents.find((item) => item.id === agentId);
          if (agent) {
            renderView(agent);
            openModal(viewModal);
          }
          return;
        }
        if (editTrigger) {
          const agentId = editTrigger.getAttribute("data-edit-agent");
          const agent = agents.find((item) => item.id === agentId);
          if (agent) {
            document.getElementById("editAgentId").value = agent.id;
            document.getElementById("editAgentName").value = agent.name;
            document.getElementById("editAgentCode").value = agent.agentCode;
            document.getElementById("editPhoneNumber").value = agent.phone;
            document.getElementById("editAgentEmail").value = agent.email || "";
            openModal(editModal);
          }
          return;
        }
        if (deleteTrigger) {
          const agentId = deleteTrigger.getAttribute("data-delete-agent");
          const agent = agents.find((item) => item.id === agentId);
          const name = agent?.name || "this agent";
          if (!confirm(`Delete ${name}? This will remove all their bets and related data.`)) {
            return;
          }
          axios.post(`${basePath}api/agent/delete`, { agent_id: agentId })
            .then((response) => {
              if (response?.data?.state) {
                window.showToast?.("Agent deleted successfully.", "success", "Deleted");
                fetchAgents();
                return;
              }
              window.showToast?.(response?.data?.message || "Failed to delete agent.", "error", "Delete failed");
            })
            .catch((error) => {
              window.showToast?.(error?.response?.data?.message || "Failed to delete agent.", "error", "Delete failed");
            });
        }
      });

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
          const filteredCount = agents.filter((agent) => {
            const haystack = `${agent.name} ${agent.agentCode} ${agent.outlet} ${agent.phone}`.toLowerCase();
            const matchesSearch = haystack.includes(currentSearch);
            return matchesSearch;
          }).length;
          const totalPages = Math.max(1, Math.ceil(filteredCount / pageSize));
          if (currentPage < totalPages) {
            currentPage += 1;
          }
        }
        applyFilters();
      });

      viewBody?.addEventListener("click", async (event) => {
        const creditTrigger = event.target.closest("[data-credit-agent]");
        const editTrigger = event.target.closest("[data-edit-agent]");
        const deleteTrigger = event.target.closest("[data-delete-agent]");
        const toggleTrigger = event.target.closest("[data-modal-toggle-agent]");

        if (creditTrigger) {
          const agentId = creditTrigger.getAttribute("data-credit-agent");
          const agent = agents.find((item) => item.id === agentId);
          if (!agent) return;
          const input = document.getElementById("creditAmountInput");
          const raw = input?.value || "";
          const amount = Number.parseFloat(raw);
          if (!amount || amount <= 0) {
            window.showToast?.("Enter a valid amount to credit.", "error", "Invalid amount");
            return;
          }
          try {
            const response = await axios.post(`${basePath}api/agent/credit`, { agent_id: agentId, amount });
            if (response?.data?.state) {
              await fetchAgents();
              const refreshed = agents.find((item) => item.id === agentId);
              if (refreshed) renderView(refreshed);
              window.showToast?.("Agent credited successfully.", "success", "Wallet credited");
              if (input) input.value = "";
              return;
            }
            window.showToast?.(response?.data?.message || "Failed to credit agent.", "error", "Credit failed");
          } catch (err) {
            window.showToast?.(err?.response?.data?.message || "Failed to credit agent.", "error", "Credit failed");
          }
          return;
        }

        if (editTrigger) {
          const agentId = editTrigger.getAttribute("data-edit-agent");
          const agent = agents.find((item) => item.id === agentId);
          if (!agent) return;
          document.getElementById("editAgentId").value = agent.id;
          document.getElementById("editAgentName").value = agent.name;
          document.getElementById("editAgentCode").value = agent.agentCode;
          document.getElementById("editPhoneNumber").value = agent.phone;
          document.getElementById("editAgentEmail").value = agent.email || "";
          openModal(editModal);
          return;
        }

        if (deleteTrigger) {
          const agentId = deleteTrigger.getAttribute("data-delete-agent");
          const agent = agents.find((item) => item.id === agentId);
          const name = agent?.name || "this agent";
          if (!confirm(`Delete ${name}? This will remove all their bets and related data.`)) {
            return;
          }
          try {
            const response = await axios.post(`${basePath}api/agent/delete`, { agent_id: agentId });
            if (response?.data?.state) {
              closeModal(viewModal);
              await fetchAgents();
              window.showToast?.("Agent deleted successfully.", "success", "Deleted");
              return;
            }
            window.showToast?.(response?.data?.message || "Failed to delete agent.", "error", "Delete failed");
          } catch (error) {
            window.showToast?.(error?.response?.data?.message || "Failed to delete agent.", "error", "Delete failed");
          }
          return;
        }

        if (toggleTrigger) {
          const agentId = toggleTrigger.getAttribute("data-modal-toggle-agent");
          const agent = agents.find((item) => item.id === agentId);
          if (!agent) return;

          try {
            const nextSuspended = agent.status === "active";
            const response = await toggleAgent(agent.id, nextSuspended);
            if (response?.data?.state) {
              await fetchAgents();
              const refreshed = agents.find((item) => item.id === agentId);
              if (refreshed) {
                renderView(refreshed);
              }
              window.showToast?.("Agent status updated.", "success", "Updated");
              return;
            }
            window.showToast?.(response?.data?.message || "Failed to update agent.", "error", "Update failed");
          } catch (error) {
            window.showToast?.(error?.response?.data?.message || "Failed to update agent.", "error", "Update failed");
          }
        }
      });

      editForm?.addEventListener("submit", async (event) => {
        event.preventDefault();
        const agentId = document.getElementById("editAgentId").value;
        const name = document.getElementById("editAgentName").value.trim();
        const phone = document.getElementById("editPhoneNumber").value.trim();
        const email = document.getElementById("editAgentEmail").value.trim();

        if (!agentId || !name || !phone || !email) {
          window.showToast?.("Please fill all required fields.", "error", "Missing data");
          return;
        }

        try {
          setButtonLoading(editAgentButton, true, "Save Changes");
          const response = await updateAgent(agentId, {
            name,
            email,
            phone
          });
          if (response?.data?.state) {
            closeModal(editModal);
            await fetchAgents();
            window.showToast?.("Agent updated successfully.", "success", "Updated");
            setButtonLoading(editAgentButton, false, "Save Changes");
            return;
          }
          window.showToast?.(response?.data?.message || "Failed to update agent.", "error", "Update failed");
          setButtonLoading(editAgentButton, false, "Save Changes");
        } catch (error) {
          window.showToast?.(error?.response?.data?.message || "Failed to update agent.", "error", "Update failed");
          setButtonLoading(editAgentButton, false, "Save Changes");
        }
      });

      searchInput?.addEventListener("input", (event) => {
        currentSearch = event.target.value.trim().toLowerCase();
        currentPage = 1;
        applyFilters();
      });

      fetchAgents();
    })();
  </script>
</body>

</html>
