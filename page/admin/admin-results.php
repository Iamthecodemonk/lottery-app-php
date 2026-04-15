<?php include_once('includes/head.php'); ?>

<body class="min-h-screen bg-shell font-body text-ink" data-page="admin-results">
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
                <div class="flex items-start gap-3">
                  <div>
                    <p class="text-sm uppercase tracking-[0.35em] text-muted">Admin Module</p>
                    <h1 class="mt-2 font-display text-3xl font-bold">Publish Results</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-muted">
                      Publish results by pairing each winning and machine number with its assigned game type.
                    </p>
                  </div>
                </div>
                <span class="status-pill">Result Control</span>
              </div>
            </header>
          
          <!-- Recent Published Games -->
          <section class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-12">
            <article class="panel-card xl:col-span-12">
              <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                  <p class="text-sm uppercase tracking-[0.35em] text-muted">Recent Published Games</p>
                  <h2 class="mt-2 font-display text-2xl font-bold">Latest published games</h2>
                </div>
                <button id="openPublishResultModal" type="button" class="action-button">Publish Result</button>
              </div>
              <div id="recentPublishedGames" class="mt-6 stack-grid"></div>
            </article>
          </section>

          <!-- Results History -->
          <section class="mt-6 panel-card">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Results History</p>
                <h2 class="mt-2 font-display text-2xl font-bold">Already published results</h2>
              </div>
              <div class="flex flex-wrap items-center gap-3">
                <input id="resultsHistorySearch" type="text" class="form-input"
                  placeholder="Search by game or date" />
                <span class="status-pill">History</span>
              </div>
            </div>
            <div id="resultsHistoryList" class="mt-6 stack-grid"></div>
            <div id="resultsHistoryPagination" class="mt-6 flex flex-wrap items-center justify-between gap-3"></div>
          </section>

          <!-- Logs -->
          <section class="mt-6 panel-card">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Activity Logs</p>
                <h2 class="mt-2 font-display text-2xl font-bold">Auto cleanup after 7 days</h2>
              </div>
              <span class="status-pill">7-Day Retention</span>
            </div>
            <div id="resultLogs" class="mt-6"></div>
          </section>

          <!-- Footer -->
          <?php include_once('includes/footer.php'); ?>
        </div>
      </main>
    </div>
  </div>

  <!-- Publish Result Modal -->
  <div id="publishResultModal" class="modal-backdrop">
    <div class="modal-card">
      <div class="flex items-start justify-between gap-4">
        <div>
          <p class="text-sm uppercase tracking-[0.35em] text-muted">Result Format</p>
          <h2 class="mt-2 font-display text-2xl font-bold">Publish a new draw result</h2>
        </div>
        <button id="closePublishResultModal" type="button" class="topbar-menu-button" aria-label="Close modal">
          <i data-lucide="x"></i>
        </button>
      </div>

      <form id="publishResultForm" class="mt-6 form-grid">
        <div class="result-input-split">
          <div>
          <label class="auth-label">Winning Numbers (5)</label>
          <div class="result-input-panel">
            <div class="result-number-grid">
              <?php for ($i = 0; $i < 5; $i++): ?>
                <div class="result-number-row" data-winning-row>
                  <input type="text" maxlength="2" class="otp-input otp-input--compact" data-winning-number inputmode="numeric" placeholder="No."
                    required />
                  <select class="form-select" data-winning-game data-game-select required></select>
                </div>
              <?php endfor; ?>
            </div>
          </div>
          </div>
          <div>
          <label class="auth-label">Machine Numbers (5)</label>
          <div class="result-input-panel">
            <div class="result-number-grid">
              <?php for ($i = 0; $i < 5; $i++): ?>
                <div class="result-number-row" data-machine-row>
                  <input type="text" maxlength="2" class="otp-input otp-input--compact" data-machine-number inputmode="numeric" placeholder="No."
                    required />
                  <select class="form-select" data-machine-game data-game-select required></select>
                </div>
              <?php endfor; ?>
            </div>
          </div>
          </div>
        </div>
        <button type="submit" class="action-button">Publish Result</button>
      </form>
    </div>
  </div>

  <!-- Page Scripts -->
  <?php include_once('includes/scripts.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    (function () {
      const basePath = "/lt/";
      const form = document.getElementById("publishResultForm");
      const modal = document.getElementById("publishResultModal");
      const openModalButton = document.getElementById("openPublishResultModal");
      const closeModalButton = document.getElementById("closePublishResultModal");
      const historySearchInput = document.getElementById("resultsHistorySearch");
      const historyPagination = document.getElementById("resultsHistoryPagination");
      const historyPageSize = 6;
      let historyPage = 1;
      let historySearch = "";

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

      function renderLatestResults(container, results) {
        if (!container) {
          return;
        }

        if (!results.length) {
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

        container.innerHTML = results
          .slice(0, 1)
          .map(
            (result) => `
              <article class="result-card result-card--featured">
                <div class="flex items-start justify-between gap-4">
                  <div>
                    <p class="text-sm uppercase tracking-[0.28em] text-accentSoft">${result.game_name}</p>
                    <p class="mt-2 text-sm text-muted">${formatDate(result.published_at)}</p>
                  </div>
                  <span class="status-pill ${result.statusClass || "status-pill--positive"}">Published</span>
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

      function renderResultsHistory(container, results) {
        if (!container) {
          return;
        }

        if (!results.length) {
          container.innerHTML = `
            <div class="empty-state empty-state--compact">
              <i data-lucide="history"></i>
              <p class="text-lg font-semibold text-ink">No result history yet</p>
              <p class="mt-3 text-sm leading-6 text-muted">
                Published result records will appear here once results are submitted.
              </p>
            </div>
          `;
          if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons();
          }
          return;
        }

        container.innerHTML = results
          .map(
            (result) => `
              <article class="result-card">
                <div class="flex flex-wrap items-start justify-between gap-4">
                  <div>
                    <p class="text-sm uppercase tracking-[0.28em] text-accentSoft">${result.game_name}</p>
                    <p class="mt-2 text-sm text-muted">${formatDate(result.published_at)}</p>
                  </div>
                  <span class="status-pill ${result.statusClass || "status-pill--positive"}">Published</span>
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

      function renderLogs(container, logs) {
        if (!container) {
          return;
        }

        if (!logs.length) {
          container.innerHTML = `
            <div class="empty-state empty-state--compact">
              <i data-lucide="file-clock"></i>
              <p class="text-lg font-semibold text-ink">No logs in the last 7 days</p>
              <p class="mt-3 text-sm leading-6 text-muted">
                Activity logs will appear here when actions are performed.
              </p>
            </div>
          `;
          if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons();
          }
          return;
        }

        container.innerHTML = logs
          .slice(0, 8)
          .map(
            (log) => `
              <div class="info-row">
                <div>
                  <p class="text-sm font-semibold text-ink">${log.message}</p>
                  <p class="mt-1 text-sm text-muted">${formatDate(log.createdAt)}</p>
                </div>
                <span class="status-pill">${log.type.replace("-", " ")}</span>
              </div>
            `
          )
          .join("");
      }


      function setGameOptionsForRows(games) {
        const selects = Array.from(document.querySelectorAll("[data-game-select]"));
        if (!selects.length) {
          return;
        }
        if (!games.length) {
          selects.forEach((select) => {
            select.innerHTML = `<option value="">No games</option>`;
          });
          return;
        }

        const options = [
          `<option value="" selected disabled>Select game</option>`,
          ...games.map((game) => `<option value="${game.id}">${game.game_name || game.name}</option>`)
        ].join("");

        selects.forEach((select) => {
          select.innerHTML = options;
        });
      }

      function normalizeResults(rawResults) {
        const map = new Map();
        rawResults.forEach((row) => {
          const id = row.result_id || row.id;
          if (!id) {
            return;
          }
          if (!map.has(id)) {
            map.set(id, {
              id,
              game_id: row.result_game_id || row.game_id,
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

      function buildLogs(results) {
        return results.map((result) => ({
          id: result.id,
          type: "publish-result",
          message: `${result.game_name} result published.`,
          createdAt: result.published_at
        }));
      }


      async function fetchGamesForRows() {
        try {
          const response = await axios.get(`${basePath}api/game/all`);
          const games = Array.isArray(response?.data?.message) ? response.data.message : [];
          setGameOptionsForRows(games);
        } catch {
          setGameOptionsForRows([]);
        }
      }

      function filterHistory(results) {
        if (!historySearch) {
          return results;
        }
        const term = historySearch.toLowerCase();
        return results.filter((result) => {
          const gameName = String(result.game_name || "").toLowerCase();
          const dateText = formatDate(result.published_at).toLowerCase();
          const rawDate = String(result.published_at || "").toLowerCase();
          return gameName.includes(term) || dateText.includes(term) || rawDate.includes(term);
        });
      }

      function renderHistoryPagination(results) {
        if (!historyPagination) {
          return;
        }

        const totalPages = Math.max(1, Math.ceil(results.length / historyPageSize));
        if (historyPage > totalPages) {
          historyPage = totalPages;
        }

        const start = (historyPage - 1) * historyPageSize;
        const end = start + historyPageSize;
        const pageResults = results.slice(start, end);

        renderResultsHistory(document.getElementById("resultsHistoryList"), pageResults);

        historyPagination.innerHTML = `
          <div class="text-sm text-muted">
            Showing ${results.length ? start + 1 : 0}-${Math.min(end, results.length)} of ${results.length}
          </div>
          <div class="flex flex-wrap items-center gap-2">
            <button type="button" class="action-button action-button-soft" data-page-action="prev" ${historyPage === 1 ? "disabled" : ""}>
              Prev
            </button>
            <span class="text-sm text-ink">Page ${historyPage} of ${totalPages}</span>
            <button type="button" class="action-button action-button-soft" data-page-action="next" ${historyPage === totalPages ? "disabled" : ""}>
              Next
            </button>
          </div>
        `;
      }

      historyPagination?.addEventListener("click", (event) => {
        const button = event.target.closest("[data-page-action]");
        if (!button) {
          return;
        }
        const action = button.getAttribute("data-page-action");
        if (action === "prev" && historyPage > 1) {
          historyPage -= 1;
        }
        if (action === "next") {
          const totalPages = Math.max(1, Math.ceil(filteredHistoryCache.length / historyPageSize));
          if (historyPage < totalPages) {
            historyPage += 1;
          }
        }
        renderHistoryPagination(filteredHistoryCache);
      });

      let resultsCache = [];
      let filteredHistoryCache = [];

      function refreshHistoryView() {
        filteredHistoryCache = filterHistory(resultsCache);
        historyPage = 1;
        renderHistoryPagination(filteredHistoryCache);
      }

      async function fetchResults() {
        try {
          const response = await axios.get(`${basePath}api/result/with-numbers`);
          const rows = Array.isArray(response?.data?.message) ? response.data.message : [];
          const results = normalizeResults(rows);
          resultsCache = results;
          renderLatestResults(document.getElementById("recentPublishedGames"), results);
          refreshHistoryView();
          renderLogs(document.getElementById("resultLogs"), buildLogs(results));
        } catch {
          resultsCache = [];
          renderLatestResults(document.getElementById("recentPublishedGames"), []);
          refreshHistoryView();
          renderLogs(document.getElementById("resultLogs"), []);
        }
      }

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

      form?.addEventListener("submit", async (event) => {
        event.preventDefault();

        const winningRows = Array.from(form.querySelectorAll("[data-winning-row]"));
        const machineRows = Array.from(form.querySelectorAll("[data-machine-row]"));

        const winningNumbers = winningRows.map((row) => ({
          number: row.querySelector("[data-winning-number]")?.value.trim() || "",
          game_id: row.querySelector("[data-winning-game]")?.value || ""
        }));
        const machineNumbers = machineRows.map((row) => ({
          number: row.querySelector("[data-machine-number]")?.value.trim() || "",
          game_id: row.querySelector("[data-machine-game]")?.value || ""
        }));

        const hasCompleteWinning = winningNumbers.every((entry) => entry.number && entry.game_id);
        const hasCompleteMachine = machineNumbers.every((entry) => entry.number && entry.game_id);

        if (!hasCompleteWinning || !hasCompleteMachine) {
          if (typeof window.showToast === "function") {
            window.showToast("Each number must include a value and a game before publishing.", "error", "Incomplete result");
          }
          return;
        }

        try {
          const response = await axios.post(`${basePath}api/result/publish`, {
            winning_numbers: winningNumbers,
            machine_numbers: machineNumbers
          });

          if (response?.data?.state) {
            form.reset();
            await fetchResults();
            closeModal();
            if (typeof window.showToast === "function") {
              window.showToast("Result published successfully.", "success", "Result published");
            }
            return;
          }
          if (typeof window.showToast === "function") {
            window.showToast(response?.data?.message || "Failed to publish result.", "error", "Publish failed");
          }
        } catch (error) {
          if (typeof window.showToast === "function") {
            window.showToast(error?.response?.data?.message || "Failed to publish result.", "error", "Publish failed");
          }
        }
      });

      historySearchInput?.addEventListener("input", (event) => {
        historySearch = event.target.value.trim();
        refreshHistoryView();
      });

      fetchGamesForRows();
      fetchResults();
    })();
  </script>
</body>

</html>
