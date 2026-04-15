<?php include_once('includes/head.php'); ?>

<body class="min-h-screen bg-shell font-body text-ink" data-page="admin-bet-types">
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
                <div>
                  <p class="text-sm uppercase tracking-[0.35em] text-muted">Admin Module</p>
                  <h1 class="mt-2 font-display text-3xl font-bold">Manage Bet Types</h1>
                  <p class="mt-3 max-w-2xl text-sm leading-6 text-muted">
                    Configure bet types from the admin side and assign each one to either lotto play or cash back submission.
                  </p>
                </div>
                <span class="status-pill">Bet Type Control</span>
              </div>
            </header>

          <section class="mt-6 grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
            <article class="form-card">
              <p class="text-sm uppercase tracking-[0.35em] text-muted">Create Bet Type</p>
              <h2 class="mt-2 font-display text-2xl font-bold">Add a new bet type</h2>
              <form id="addBetTypeForm" class="mt-6 form-grid">
                <input type="hidden" id="betTypeId" name="betTypeId" />
                <div>
                  <label class="auth-label" for="betTypeName">Bet Type Name</label>
                  <input id="betTypeName" name="betTypeName" type="text" class="form-input"
                    placeholder="Direct 5" required />
                </div>
                <div>
                  <label class="auth-label" for="betTypeCategory">Category</label>
                  <select id="betTypeCategory" name="betTypeCategory" class="form-input" required>
                    <option value="" selected disabled>Select category</option>
                    <option value="lotto">Lotto</option>
                    <option value="cashback">Cashback</option>
                  </select>
                </div>
                <p id="betTypeFormError" class="hidden text-sm text-red-300"></p>
                <p id="betTypeFormSuccess" class="hidden text-sm text-emerald-300"></p>
                <div class="flex flex-wrap gap-3">
                  <button id="betTypeSubmitBtn" type="submit" class="action-button">Add Bet Type</button>
                  <button id="betTypeCancelEdit" type="button" class="action-button action-button-soft hidden">
                    Cancel Edit
                  </button>
                </div>
              </form>
            </article>

            <article class="panel-card">
              <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                  <p class="text-sm uppercase tracking-[0.35em] text-muted">Active Bet Types</p>
                  <h2 class="mt-2 font-display text-2xl font-bold">Current bet type list</h2>
                </div>
                <button id="openAllBetTypesModal" type="button" class="action-button action-button-soft">
                  View all bet types
                </button>
              </div>
              <div id="betTypeList" class="mt-6 stack-grid"></div>
            </article>
          </section>

          <section class="mt-6 panel-card">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Bet Type Logs</p>
                <h2 class="mt-2 font-display text-2xl font-bold">Recent changes</h2>
              </div>
              <span class="status-pill">Session Logs</span>
            </div>
            <div id="betTypeLogs" class="mt-6"></div>
          </section>

          <!-- Footer -->
          <?php include_once('includes/footer.php'); ?>
        </div>
      </main>
    </div>
  </div>

  <!-- All Bet Types Modal -->
  <div id="allBetTypesModal" class="modal-backdrop">
    <div class="modal-card">
      <div class="flex items-start justify-between gap-4">
        <div>
          <p class="text-sm uppercase tracking-[0.35em] text-muted">All Bet Types</p>
          <h2 class="mt-2 font-display text-2xl font-bold">Full bet type list</h2>
        </div>
        <button id="closeAllBetTypesModal" type="button" class="topbar-menu-button" aria-label="Close modal">
          <i data-lucide="x"></i>
        </button>
      </div>
      <div id="allBetTypesList" class="mt-6 stack-grid"></div>
    </div>
  </div>

  <!-- Page Scripts -->
  <?php include_once('includes/scripts.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    (function () {
      const basePath = "/lt/";
      const form = document.getElementById("addBetTypeForm");
      const errorEl = document.getElementById("betTypeFormError");
      const successEl = document.getElementById("betTypeFormSuccess");
      const listEl = document.getElementById("betTypeList");
      const allListEl = document.getElementById("allBetTypesList");
      const logsEl = document.getElementById("betTypeLogs");
      const modal = document.getElementById("allBetTypesModal");
      const openModalButton = document.getElementById("openAllBetTypesModal");
      const closeModalButton = document.getElementById("closeAllBetTypesModal");

      let logEntries = [];
      let allBetTypes = [];

      function showError(message) {
        errorEl.textContent = message;
        errorEl.classList.remove("hidden");
        successEl.classList.add("hidden");
      }

      function showSuccess(message) {
        successEl.textContent = message;
        successEl.classList.remove("hidden");
        errorEl.classList.add("hidden");
      }

      function addLog(message) {
        logEntries.unshift({
          message,
          createdAt: new Date().toISOString()
        });
        renderLogs();
      }

      function renderLogs() {
        if (!logsEl) return;
        if (!logEntries.length) {
          logsEl.innerHTML = `
            <div class="empty-state empty-state--compact">
              <i data-lucide="file-clock"></i>
              <p class="text-lg font-semibold text-ink">No recent bet type changes</p>
              <p class="mt-3 text-sm leading-6 text-muted">
                Updates will appear here as new bet types are created or removed.
              </p>
            </div>
          `;
          if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons();
          }
          return;
        }

        logsEl.innerHTML = logEntries
          .slice(0, 6)
          .map(
            (log) => `
              <div class="info-row">
                <div>
                  <p class="text-sm font-semibold text-ink">${log.message}</p>
                  <p class="mt-1 text-sm text-muted">${new Date(log.createdAt).toLocaleString("en-NG")}</p>
                </div>
                <span class="status-pill">bet type</span>
              </div>
            `
          )
          .join("");
      }

      function renderList(container, items) {
        if (!container) return;
        if (!items.length) {
          container.innerHTML = `
            <div class="empty-state empty-state--compact">
              <i data-lucide="layers-3"></i>
              <p class="text-lg font-semibold text-ink">No bet types available</p>
              <p class="mt-3 text-sm leading-6 text-muted">
                Create a bet type to start managing lotto categories.
              </p>
            </div>
          `;
          if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons();
          }
          return;
        }

        container.innerHTML = items
          .map((type) => {
            const name = type.name || "Bet Type";
            const category = type.category || "lotto";
            return `
              <div class="list-card-row">
                <div>
                  <p class="text-sm font-semibold text-ink">${name}</p>
                  <p class="mt-1 text-sm text-muted">Category: ${category}</p>
                </div>
                <div class="flex flex-wrap gap-2">
                  <button class="action-button action-button-soft" data-edit-bet-type="${type.id}" type="button">
                    Edit
                  </button>
                  <button class="action-button action-button-danger" data-delete-bet-type="${type.id}" type="button">
                    Delete
                  </button>
                </div>
              </div>
            `;
          })
          .join("");
      }

      function filterRecent(types) {
        const now = Date.now();
        const threeDays = 3 * 24 * 60 * 60 * 1000;
        return types.filter((type) => {
          const date = new Date(type.created_at || type.createdAt || Date.now());
          return now - date.getTime() <= threeDays;
        });
      }

      async function fetchBetTypes() {
        try {
          const response = await axios.get(`${basePath}api/bet-type/all`);
          allBetTypes = Array.isArray(response?.data?.message) ? response.data.message : [];
        } catch (error) {
          allBetTypes = [];
        }

        renderList(listEl, filterRecent(allBetTypes));
        renderList(allListEl, allBetTypes);
      }

      async function deleteBetType(id) {
        const response = await axios.post(`${basePath}api/bet-type/delete`, { bet_type_id: id });
        if (response?.data?.state) {
          return true;
        }
        throw new Error(response?.data?.message || "Failed to delete bet type.");
      }

      function startEdit(betType) {
        document.getElementById("betTypeId").value = betType.id || "";
        document.getElementById("betTypeName").value = betType.name || "";
        document.getElementById("betTypeCategory").value = betType.category || "lotto";
        document.getElementById("betTypeSubmitBtn").textContent = "Update Bet Type";
        document.getElementById("betTypeCancelEdit").classList.remove("hidden");
      }

      function resetForm() {
        form.reset();
        document.getElementById("betTypeId").value = "";
        document.getElementById("betTypeSubmitBtn").textContent = "Add Bet Type";
        document.getElementById("betTypeCancelEdit").classList.add("hidden");
      }

      document.getElementById("betTypeCancelEdit")?.addEventListener("click", () => {
        errorEl.classList.add("hidden");
        successEl.classList.add("hidden");
        resetForm();
      });

      function handleEditClick(event) {
        const trigger = event.target.closest("[data-edit-bet-type]");
        if (!trigger) return;
        const id = trigger.getAttribute("data-edit-bet-type");
        const betType = allBetTypes.find((item) => item.id === id);
        if (!betType) return;
        startEdit(betType);
      }

      listEl?.addEventListener("click", async (event) => {
        if (event.target.closest("[data-edit-bet-type]")) {
          handleEditClick(event);
          return;
        }
        const trigger = event.target.closest("[data-delete-bet-type]");
        if (!trigger) return;
        const id = trigger.getAttribute("data-delete-bet-type");
        if (!id) return;

        try {
          await deleteBetType(id);
          addLog("Bet type removed.");
          await fetchBetTypes();
        } catch (error) {
          showError(error.message || "Failed to delete bet type.");
        }
      });

      allListEl?.addEventListener("click", async (event) => {
        if (event.target.closest("[data-edit-bet-type]")) {
          handleEditClick(event);
          return;
        }
        const trigger = event.target.closest("[data-delete-bet-type]");
        if (!trigger) return;
        const id = trigger.getAttribute("data-delete-bet-type");
        if (!id) return;

        try {
          await deleteBetType(id);
          addLog("Bet type removed.");
          await fetchBetTypes();
        } catch (error) {
          showError(error.message || "Failed to delete bet type.");
        }
      });

      form?.addEventListener("submit", async (event) => {
        event.preventDefault();
        errorEl.classList.add("hidden");
        successEl.classList.add("hidden");

        const betTypeId = document.getElementById("betTypeId").value.trim();
        const name = document.getElementById("betTypeName").value.trim();
        const category = document.getElementById("betTypeCategory").value;

        if (!name || !category) {
          showError("Please fill all required fields.");
          return;
        }

        try {
          const url = betTypeId ? `${basePath}api/bet-type/update` : `${basePath}api/bet-type/create`;
          const payload = betTypeId ? { bet_type_id: betTypeId, name, category } : { name, category };
          const response = await axios.post(url, payload);
          if (response?.data?.state) {
            showSuccess(betTypeId ? "Bet type updated successfully." : "Bet type created successfully.");
            addLog(betTypeId ? "Bet type updated." : "New bet type created.");
            resetForm();
            await fetchBetTypes();
            return;
          }
          showError(response?.data?.message || "Failed to create bet type.");
        } catch (error) {
          showError(error?.response?.data?.message || "Failed to create bet type.");
        }
      });

      function openModal() {
        modal?.classList.add("is-open");
        document.body.classList.add("overflow-hidden");
      }

      function closeModal() {
        modal?.classList.remove("is-open");
        document.body.classList.remove("overflow-hidden");
      }

      openModalButton?.addEventListener("click", openModal);
      closeModalButton?.addEventListener("click", closeModal);
      modal?.addEventListener("click", (event) => {
        if (event.target === modal) {
          closeModal();
        }
      });

      renderLogs();
      fetchBetTypes();
    })();
  </script>
</body>

</html>
