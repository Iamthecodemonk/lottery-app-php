<?php include_once('includes/head.php'); ?>

<body class="min-h-screen bg-shell font-body text-ink" data-page="agent-results">
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

      <!-- <div id="sidebarOverlay" class="fixed inset-0 z-40 hidden bg-black/50 backdrop-blur-sm lg:hidden"></div> -->

      <main class="dashboard-main flex-1 px-4 py-4 sm:px-6 lg:px-8 lg:py-8">
        <div class="mx-auto max-w-7xl">
          <!-- Sticky Header -->
          <?php
            $agentHeaderTitle = 'Results Center';
            $agentHeaderDescription = 'Review the latest published draws and browse the full results history.';
            $agentHeaderActionLabel = 'Play Lotto Now';
            $agentHeaderActionHref = '/lt/agent/lotto';
            $agentHeaderActionId = 'playLottoFromResults';
            include_once('includes/header.php');
          ?>

          <section class="mt-6 panel-card">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Latest Result</p>
                <h2 class="mt-2 font-display text-2xl font-bold">Newest published result</h2>
              </div>
              <span class="status-pill">Live Update Ready</span>
            </div>
            <div id="agentResultsList" class="mt-6 stack-grid"></div>
            <div class="mt-6 flex flex-wrap justify-end gap-3">
              <a href="/lt/agent/cashback" class="action-button action-button-soft">
                <i data-lucide="arrow-left"></i>
                <span>Back to Cash Back</span>
              </a>
              <a href="/lt/agent/lotto" class="action-button">
                <i data-lucide="gamepad-2"></i>
                <span>Play Lotto Now</span>
              </a>
            </div>
          </section>

          <section class="mt-6 table-card">
            <div
              class="flex flex-col gap-3 border-b border-white/10 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Result History</p>
                <h2 class="mt-2 font-display text-2xl font-bold">Published result records</h2>
              </div>
              <span class="status-pill">Most Recent First</span>
            </div>
            <div id="agentResultsHistory" class="p-0"></div>
            <div id="agentResultsPagination" class="px-6 py-5"></div>
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
      const basePath = "/lt/";
      const latestContainer = document.getElementById("agentResultsList");
      const historyContainer = document.getElementById("agentResultsHistory");

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

      function renderLatestToday(results) {
        if (!latestContainer) return;
        const todayResults = results.filter((item) => isToday(item.published_at));
        const latest = todayResults[0];
        if (!latest) {
          latestContainer.innerHTML = `
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

        latestContainer.innerHTML = `
          <article class="result-card result-card--featured">
            <div class="flex items-start justify-between gap-4">
              <div>
                <p class="text-sm uppercase tracking-[0.28em] text-accentSoft">${latest.game_name}</p>
                <p class="mt-2 text-sm text-muted">${formatDate(latest.published_at)}</p>
              </div>
              <span class="status-pill status-pill--positive">Published</span>
            </div>
            <div class="result-split mt-6">
              <div>
                <p class="result-label">Winning Numbers</p>
                <div class="result-entry-grid result-entry-grid--horizontal mt-3">
                  ${(latest.winning_numbers || [])
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
                  ${(latest.machine_numbers || [])
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
        `;
      }

      function renderHistory(results) {
        if (!historyContainer) return;
        if (!results.length) {
          historyContainer.innerHTML = `
            <div class="empty-state empty-state--compact">
              <i data-lucide="history"></i>
              <p class="text-lg font-semibold text-ink">No result history yet</p>
              <p class="mt-3 text-sm leading-6 text-muted">
                Published results will appear here once available.
              </p>
            </div>
          `;
          if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons();
          }
          return;
        }

        historyContainer.innerHTML = `
          <div class="stack-grid">
            ${results
              .map(
                (result) => `
                  <article class="result-card">
                    <div class="flex flex-wrap items-start justify-between gap-4">
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
              .join("")}
          </div>
        `;
      }

      function renderPagination(container, currentPage, totalPages) {
        if (!container) return;
        if (totalPages <= 1) {
          container.innerHTML = "";
          return;
        }
        const pages = [];
        for (let i = 1; i <= totalPages; i += 1) pages.push(i);
        container.innerHTML = `
          <div class="pagination">
            <button class="pagination-btn" data-page="${currentPage - 1}" ${currentPage === 1 ? "disabled" : ""}>
              Prev
            </button>
            ${pages
              .map(
                (page) => `
                  <button class="pagination-btn ${page === currentPage ? "is-active" : ""}" data-page="${page}">
                    ${page}
                  </button>
                `
              )
              .join("")}
            <button class="pagination-btn" data-page="${currentPage + 1}" ${currentPage === totalPages ? "disabled" : ""}>
              Next
            </button>
          </div>
        `;
      }

      let resultsState = [];
      let historyPage = 1;
      const historyPageSize = 6;

      function renderHistoryPage() {
        const totalPages = Math.max(1, Math.ceil(resultsState.length / historyPageSize));
        if (historyPage > totalPages) historyPage = totalPages;
        const start = (historyPage - 1) * historyPageSize;
        const paged = resultsState.slice(start, start + historyPageSize);
        renderHistory(paged);
        renderPagination(document.getElementById("agentResultsPagination"), historyPage, totalPages);
      }

      async function loadResults() {
        try {
          const response = await axios.get(`${basePath}api/result/with-numbers`);
          const rows = Array.isArray(response?.data?.message) ? response.data.message : [];
          const results = normalizeResults(rows);
          renderLatestToday(results);
          resultsState = results;
          renderHistoryPage();
        } catch (error) {
          renderLatestToday([]);
          resultsState = [];
          renderHistoryPage();
        }
      }

      document.getElementById("agentResultsPagination")?.addEventListener("click", (event) => {
        const target = event.target.closest("[data-page]");
        if (!target) return;
        const page = Number(target.getAttribute("data-page"));
        if (!Number.isNaN(page)) {
          historyPage = Math.max(1, page);
          renderHistoryPage();
        }
      });

      loadResults();
    })();
  </script>
</body>

</html>
