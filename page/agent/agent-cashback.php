<?php include_once('includes/head.php'); ?>

<body class="min-h-screen bg-shell font-body text-ink" data-page="agent-cashback">
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
          <section class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-[0.7fr_0.7fr_1.2fr]">
            <article class="stat-card">
              <p class="stat-label">Amount Earned Today</p>
              <h3 id="agentAmountEarnedToday" class="stat-value">N 0</h3>
              <p class="stat-meta text-accentSoft">Current day outlet earnings</p>
            </article>
            <article class="stat-card">
              <p class="stat-label">Games Played</p>
              <h3 id="agentGamesPlayedToday" class="stat-value">0</h3>
              <p class="stat-meta text-accent">Submitted today</p>
            </article>
            <article class="stat-card">
              <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                  <p class="stat-label">Today's Game Result</p>
                  <p class="mt-2 text-sm leading-6 text-muted">
                    Quick preview of the latest published result.
                  </p>
                </div>
                <a href="results" class="action-button action-button-soft">
                  <i data-lucide="arrow-up-right"></i>
                  <span>Open Results</span>
                </a>
              </div>
              <div id="agentPlayLatestResult" class="mt-5"></div>
            </article>
          </section>

          <!-- History Table -->
          <section class="mt-6 table-card">
            <div
              class="flex flex-col gap-3 border-b border-white/10 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Cash Back History</p>
                <h2 class="mt-2 font-display text-2xl font-bold">Recently submitted tickets</h2>
              </div>
              <span class="status-pill">Agent History</span>
            </div>
            <div class="border-b border-white/10 px-6 py-5">
              <div class="grid gap-4 lg:grid-cols-[1fr_auto] lg:items-end">
                <label class="block">
                  <span class="result-label">Search History</span>
                  <input id="agentCashbackSearchInput" class="form-input mt-3" type="search"
                    placeholder="Search by ticket, game, cash back type, or cash back id" />
                </label>
                <div>
                  <p class="result-label">Sort By</p>
                  <select id="agentCashbackSort" class="form-select mt-3">
                    <option value="newest">Newest</option>
                    <option value="oldest">Oldest</option>
                    <option value="stake_desc">Highest Stake</option>
                    <option value="stake_asc">Lowest Stake</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="table-wrap">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Ticket</th>
                    <th>Game</th>
                    <th>Cash Back Type</th>
                    <th>Stake Amount</th>
                    <th>Cash Back ID</th>
                    <th>Date</th>
                    <th>Numbers</th>
                  </tr>
                </thead>
                <tbody id="agentCashbackHistoryTable"></tbody>
              </table>
            </div>
            <div id="agentCashbackPagination" class="px-6 py-5"></div>
          </section>

          <!-- Footer -->
          <?php include_once('includes/footer.php'); ?>
        </div>
      </main>
    </div>
  </div>

  <!-- Play Cash Back Modal -->
  <div id="playGameModal" class="modal-backdrop" aria-hidden="true">
    <div class="modal-card modal-card--wide">
      <!-- Modal Header -->
      <div class="flex items-start justify-between gap-4">
        <div>
          <p class="text-sm uppercase tracking-[0.35em] text-muted">Agent Cash Back Flow</p>
          <h2 class="mt-2 font-display text-3xl font-bold">Build Cash Back Game</h2>
          <p class="mt-3 max-w-3xl text-sm leading-6 text-muted">
            Select up to 20 numbers from 1 to 90, complete the game details, then proceed to printing.
          </p>
        </div>
        <button id="closePlayGameModal" class="action-icon-button text-xl" type="button"
          aria-label="Close play game modal">
          ×
        </button>
      </div>

      <!-- Modal Content -->
      <div id="playBuilderStep" class="mt-6 grid gap-6 xl:grid-cols-[1.25fr_0.75fr]">
        <!-- Builder Column -->
        <div class="space-y-6">
          <!-- Number Selection -->
          <section class="soft-card">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="result-label">Number Board</p>
                <h3 class="mt-2 text-xl font-semibold text-ink">Select 20 numbers only</h3>
              </div>
              <div class="play-counter">
                <span id="playSelectionCount">0</span>
                <small>of 20 selected</small>
              </div>
            </div>
            <div id="playNumberGrid" class="play-number-grid mt-6"></div>
          </section>

          <!-- Selected Numbers -->
          <section class="soft-card">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="result-label">Selected Numbers</p>
                <h3 class="mt-2 text-xl font-semibold text-ink">Current picks</h3>
              </div>
              <button id="clearSelectedNumbers" class="action-button action-button-soft" type="button">Clear
                Selection</button>
            </div>
            <div id="selectedNumbersDisplay" class="number-chip-row mt-5"></div>
          </section>

          <!-- Game Details -->
          <section class="soft-card">
            <div>
              <p class="result-label">Game Details</p>
              <h3 class="mt-2 text-xl font-semibold text-ink">Attach cash back details</h3>
            </div>
            <form id="playGameForm" class="form-grid mt-6">
              <input id="editingDraftId" type="hidden" />
              <label class="block">
                <span class="result-label">Game</span>
                <select id="playGameSelect" class="form-select mt-3"></select>
              </label>
              <label class="block">
                <span class="result-label">Cash Back Type</span>
                <select id="cashbackType" class="form-select mt-3">
                  <option value="">Select cash back type</option>
                  <option value="Direct">Direct</option>
                  <option value="Perm 2">Perm 2</option>
                  <option value="Perm 3">Perm 3</option>
                  <option value="Banker">Banker</option>
                </select>
              </label>
              <label class="block">
                <span class="result-label">Stake Amount</span>
                <input id="playStakeAmount" class="form-input mt-3" type="number" min="0" step="100"
                  placeholder="Enter stake amount" />
              </label>
              <label class="block">
                <span class="result-label">Cash Back ID</span>
                <input id="cashbackId" class="form-input mt-3" type="text" placeholder="Auto generated" readonly />
              </label>
            </form>
            <div class="mt-6 flex flex-wrap gap-3">
              <button id="addMoreGamesAction" class="action-button" type="button">
                <i data-lucide="plus"></i>
                <span id="builderPrimaryActionLabel">Save Game</span>
              </button>
              <button id="saveGameUpdateAction" class="action-button action-button-soft hidden" type="button">
                <i data-lucide="square-pen"></i>
                <span>Update Game</span>
              </button>
            </div>
          </section>
        </div>

        <!-- Draft Column -->
        <aside class="space-y-6">
          <section class="soft-card">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="result-label">Game Played</p>
                <h3 class="mt-2 text-xl font-semibold text-ink">Ready for printing</h3>
              </div>
              <div class="play-counter play-counter--compact">
                <span id="draftGamesCount">0</span>
                <small>saved</small>
              </div>
            </div>
            <div id="draftGamesList" class="mt-5 stack-grid"></div>
          </section>

          <section class="soft-card">
            <p class="result-label">Printing Summary</p>
            <div class="mt-4 space-y-4">
              <div class="info-row">
                <span class="text-sm text-muted">Saved ticket</span>
                <span id="draftGamesTotalCount" class="text-sm font-semibold text-ink">0</span>
              </div>
              <div class="info-row">
                <span class="text-sm text-muted">Total stake</span>
                <span id="draftGamesTotalStake" class="text-sm font-semibold text-ink">N 0</span>
              </div>
            </div>
            <button id="proceedToPrintingAction" class="action-button mt-6 w-full" type="button">
              <i data-lucide="printer"></i>
              <span>Proceed</span>
            </button>
          </section>
        </aside>
      </div>

      <!-- Receipt Step -->
      <div id="playReceiptStep" class="mt-6 hidden">
        <div class="soft-card">
          <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
              <p class="result-label">Receipt Review</p>
              <h3 class="mt-2 text-2xl font-semibold text-ink">Confirm transaction before printing</h3>
              <p class="mt-3 max-w-3xl text-sm leading-6 text-muted">
                This cash back ticket will be submitted as one transaction and prepared for printing.
              </p>
            </div>
            <div class="flex flex-wrap gap-3">
              <button id="backToBuilderAction" class="action-button action-button-soft" type="button">
                <i data-lucide="arrow-left"></i>
                <span>Back To Games</span>
              </button>
              <button id="submitReceiptAction" class="action-button" type="button">
                <i data-lucide="check-check"></i>
                <span>Submit Transaction</span>
              </button>
            </div>
          </div>
          <div id="ticketPrintArea" class="mt-6">
            <div id="receiptPreviewBody"></div>
          </div>
          <div class="mt-6 flex flex-wrap justify-end gap-3">
            <button id="printTicketAction" class="action-button action-button-soft" type="button">
              <i data-lucide="printer"></i>
              <span>Print Ticket</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Success Modal -->
  <div id="playSuccessModal" class="modal-backdrop" aria-hidden="true">
    <div class="modal-card">
      <div class="flex items-start justify-between gap-4">
        <div>
          <p class="text-sm uppercase tracking-[0.35em] text-muted">Transaction Status</p>
          <h2 class="mt-2 font-display text-2xl font-bold">Submission successful</h2>
          <p class="mt-3 text-sm leading-6 text-muted">
            Your ticket has been submitted. You can print the receipt now or return to the play screen.
          </p>
          <div class="mt-4 inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-2">
            <span class="text-xs uppercase tracking-[0.35em] text-muted">Auto close in</span>
            <div class="flex items-center gap-2">
              <span id="successCountdown" class="text-sm font-semibold text-ink">5</span>
              <div class="h-1 w-20 overflow-hidden rounded-full bg-white/10">
                <div id="successCountdownBar" class="h-full w-full rounded-full bg-accent"></div>
              </div>
            </div>
          </div>
        </div>
        <button id="closeSuccessModal" type="button" class="topbar-menu-button" aria-label="Close modal">
          <i data-lucide="x"></i>
        </button>
      </div>
      <div class="mt-6 flex flex-wrap justify-end gap-3">
        <button id="successGoBack" type="button" class="action-button action-button-soft">
          Back to Play
        </button>
        <button id="successViewReceipt" type="button" class="action-button">
          View Receipt
        </button>
      </div>
    </div>
  </div>

  <!-- Numbers Modal -->
  <div id="cashbackNumbersModal" class="modal-backdrop" aria-hidden="true">
    <div class="modal-card">
      <div class="flex items-start justify-between gap-4">
        <div>
          <p class="text-sm uppercase tracking-[0.35em] text-muted">Cash Back Ticket</p>
          <h2 class="mt-2 font-display text-2xl font-bold">Selected Numbers</h2>
          <p id="cashbackNumbersTicket" class="mt-3 text-sm text-muted"></p>
        </div>
        <button id="closeCashbackNumbersModal" type="button" class="topbar-menu-button" aria-label="Close modal">
          <i data-lucide="x"></i>
        </button>
      </div>
      <div id="cashbackNumbersBody" class="mt-6 number-chip-row"></div>
      <div class="mt-6 flex flex-wrap justify-end gap-3">
        <button id="printCashbackTicket" class="action-button action-button-soft" type="button">
          <i data-lucide="printer"></i>
          <span>Print Ticket</span>
        </button>
      </div>
    </div>
  </div>

  <style>
    .ticket-slip {
      max-width: 360px;
      margin: 0 auto;
      background: #ffffff;
      color: #111827;
      border-radius: 12px;
      padding: 18px 16px 20px;
      font-family: "Segoe UI", Arial, sans-serif;
      box-shadow: 0 10px 30px rgba(15, 23, 42, 0.18);
    }
    .ticket-topline {
      display: flex;
      justify-content: space-between;
      font-size: 10px;
      color: #111827;
      margin-bottom: 12px;
      gap: 8px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .ticket-url {
      color: #6b7280;
    }
    .ticket-logo {
      display: flex;
      justify-content: center;
      margin-bottom: 8px;
    }
    .ticket-logo img {
      height: 40px;
      width: auto;
      object-fit: contain;
    }
    .ticket-title {
      text-align: center;
      font-weight: 700;
      margin-bottom: 8px;
    }
    .ticket-brand {
      font-size: 16px;
      letter-spacing: 0.5px;
    }
    .ticket-subtitle {
      font-size: 13px;
      font-weight: 700;
      margin-top: 2px;
    }
    .ticket-code {
      font-size: 11px;
      margin-top: 6px;
      font-weight: 600;
    }
    .ticket-divider {
      height: 1px;
      background: #d1d5db;
      margin: 12px 0;
    }
    .ticket-divider--dashed {
      background: none;
      border-top: 2px dashed #111827;
    }
    .ticket-divider--strong {
      background: #111827;
    }
    .ticket-meta,
    .ticket-agent {
      display: flex;
      justify-content: space-between;
      font-size: 11px;
      margin-bottom: 10px;
    }
    .ticket-agent {
      flex-direction: column;
      gap: 2px;
      margin-bottom: 12px;
    }
    .ticket-game {
      margin-bottom: 12px;
    }
    .ticket-game-head {
      display: flex;
      justify-content: space-between;
      font-size: 11px;
      font-weight: 700;
      margin-bottom: 6px;
    }
    .ticket-game-type {
      text-transform: uppercase;
    }
    .ticket-numbers {
      display: flex;
      flex-wrap: wrap;
      gap: 4px;
      margin-bottom: 6px;
    }
    .ticket-numbers span {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 22px;
      height: 18px;
      border: 1px solid #111827;
      border-radius: 3px;
      font-size: 10px;
      font-weight: 600;
    }
    .ticket-amount {
      text-align: right;
      font-size: 12px;
      font-weight: 700;
    }
    .ticket-totals {
      font-size: 11px;
      display: flex;
      flex-direction: column;
      gap: 4px;
      margin-bottom: 12px;
    }
    .ticket-totals div {
      display: flex;
      justify-content: space-between;
    }
    .ticket-grand {
      border: 1px solid #d1d5db;
      border-radius: 6px;
      text-align: center;
      padding: 8px 10px;
      font-size: 13px;
      font-weight: 700;
      margin-bottom: 12px;
    }
    .ticket-footer {
      text-align: center;
      font-size: 10px;
      color: #111827;
    }
    .ticket-goodluck {
      font-weight: 700;
      margin-top: 4px;
    }
    .ticket-terms {
      font-size: 9px;
      color: #6b7280;
      margin-top: 6px;
    }
    @media print {
      body * {
        visibility: hidden !important;
      }
      #ticketPrintArea,
      #ticketPrintArea * {
        visibility: visible !important;
      }
      #ticketPrintArea {
        position: fixed;
        inset: 0;
        background: #ffffff;
        padding: 24px;
        color: #111827;
      }
      .ticket-slip {
        box-shadow: none;
      }
    }
  </style>

  <script>
    window.useLiveAgentCashback = true;
  </script>

  <!-- Page Scripts -->
  <?php include_once('includes/scripts.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    (function () {
      const basePath = "/lt/";
      const gameSelect = document.getElementById("playGameSelect");
      const cashBackTypeSelect = document.getElementById("cashbackType");
      const stakeAmountInput = document.getElementById("playStakeAmount");
      const cashBackIdInput = document.getElementById("cashbackId");
      const printTicketButton = document.getElementById("printTicketAction");
      const playModal = document.getElementById("playGameModal");
      const successModal = document.getElementById("playSuccessModal");
      const closeSuccessModalBtn = document.getElementById("closeSuccessModal");
      const successGoBackBtn = document.getElementById("successGoBack");
      const successViewReceiptBtn = document.getElementById("successViewReceipt");
      const betTypeIdMap = new Map();

      function setText(id, value) {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
      }

      function formatCurrency(value) {
        const amount = Number(value || 0);
        return `₦ ${amount.toLocaleString("en-NG", { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
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

      function renderGameOptions(games) {
        if (!gameSelect) return;
        if (!Array.isArray(games) || !games.length) {
          gameSelect.innerHTML = '<option value="">No cashback games available</option>';
          return;
        }

        gameSelect.innerHTML = [
          '<option value="">Select game</option>',
          ...games.map((game) => {
            const name = game.game_name || game.name || "Game";
            return `<option value="${game.id}">${name}</option>`;
          })
        ].join("");
      }

      function renderBetTypeOptions(types) {
        if (!cashBackTypeSelect) return;
        if (!Array.isArray(types) || !types.length) {
          cashBackTypeSelect.innerHTML = '<option value="">No cash back types</option>';
          return;
        }

        betTypeIdMap.clear();
        cashBackTypeSelect.innerHTML = [
          '<option value="">Select cash back type</option>',
          ...types.map((type) => {
            const name = type.name || type.bet_type_name || "Cash back";
            if (type.id) betTypeIdMap.set(String(name).toLowerCase(), type.id);
            return `<option value="${name}" data-id="${type.id}">${name}</option>`;
          })
        ].join("");
      }

      async function loadCashbackGames() {
        try {
          const response = await axios.get(`${basePath}api/game/all`);
          const rows = Array.isArray(response?.data?.message) ? response.data.message : [];
          const games = rows
            .filter((game) => String(game.category || game.game_category || "").toLowerCase() === "cashback")
            .map((game) => ({
              id: game.id,
              name: game.game_name || game.name || "Game",
              drawTime: game.cutoff_time || null
            }));
          renderGameOptions(games);
          if (typeof window.commitState === "function") {
            window.commitState((state) => {
              state.games = games;
              return state;
            });
          }
        } catch {
          renderGameOptions([]);
        }
      }

      async function loadCashbackTypes() {
        try {
          const response = await axios.get(`${basePath}api/bet-type/by-category`, {
            params: { category: "cashback" }
          });
          const rows = Array.isArray(response?.data?.message) ? response.data.message : [];
          renderBetTypeOptions(rows);
        } catch {
          renderBetTypeOptions([]);
        }
      }

      function generateCashbackId() {
        const partA = Math.random().toString(36).slice(2, 8).toUpperCase();
        const partB = Math.random().toString(36).slice(2, 6).toUpperCase();
        return `CB-${partA}-${partB}`;
      }

      function ensureCashbackId() {
        if (!cashBackIdInput) return;
        if (!cashBackIdInput.value) {
          cashBackIdInput.value = generateCashbackId();
        }
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

      function renderLatestResultToday(result) {
        const container = document.getElementById("agentPlayLatestResult");
        if (!container) return;
        if (!result) {
          container.innerHTML = `
            <div class="empty-state empty-state--compact">
              <i data-lucide="trophy"></i>
              <p class="text-base font-semibold text-ink">No result today</p>
              <p class="mt-2 text-sm leading-6 text-muted">
                Today's result will appear here once it is published.
              </p>
            </div>
          `;
          if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons();
          }
          return;
        }

        container.innerHTML = `
          <article class="rounded-[1.5rem] border border-white/10 bg-white/5 p-4">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
              <div>
                <p class="text-sm font-semibold text-ink">${result.game_name}</p>
                <p class="mt-1 text-xs text-muted">${new Date(result.published_at).toLocaleString("en-NG")}</p>
              </div>
              <span class="status-pill status-pill--positive">Published</span>
            </div>
            <div class="result-split mt-4">
              <div>
                <p class="result-label">Winning Numbers</p>
                <div class="result-entry-grid result-entry-grid--horizontal mt-3">
                  ${(result.winning_numbers || [])
                    .slice(0, 5)
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
                    .slice(0, 5)
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

      async function loadTodayResult() {
        try {
          const response = await axios.get(`${basePath}api/result/with-numbers`);
          const rows = Array.isArray(response?.data?.message) ? response.data.message : [];
          const results = normalizeResults(rows);
          const today = results.filter((row) => isToday(row.published_at));
          renderLatestResultToday(today[0] || null);
        } catch {
          renderLatestResultToday(null);
        }
      }

      async function updateAgentTodayStats() {
        const storedAgent = localStorage.getItem("agent_profile");
        const agentProfile = storedAgent ? JSON.parse(storedAgent) : null;
        const agentId = agentProfile?.id;

        if (!agentId) {
          setText("agentAmountEarnedToday", formatCurrency(0));
          setText("agentGamesPlayedToday", "0");
          return;
        }

        try {
          const response = await axios.get(`${basePath}api/bet/by-agent`, {
            params: { agent_id: agentId }
          });
          const bets = Array.isArray(response?.data?.message) ? response.data.message : [];
          const todayBets = bets.filter(
            (bet) => String(bet.mode || bet.bet_mode || "").toLowerCase() === "cashback" && isToday(bet.placed_at || bet.bet_placed_at)
          );
          const totalEarned = todayBets.reduce(
            (sum, bet) => sum + Number(bet.stake_amount ?? bet.bet_stake_amount ?? 0),
            0
          );
          const totalGames = todayBets.reduce(
            (sum, bet) => sum + Number(bet.total_games_played ?? bet.bet_total_games_played ?? 0),
            0
          );
          setText("agentAmountEarnedToday", formatCurrency(totalEarned));
          setText("agentGamesPlayedToday", String(totalGames));
        } catch {
          setText("agentAmountEarnedToday", formatCurrency(0));
          setText("agentGamesPlayedToday", "0");
        }
      }

      function renderHistory(rows) {
        const tbody = document.getElementById("agentCashbackHistoryTable");
        if (!tbody) return;
        if (!rows.length) {
          tbody.innerHTML = `
            <tr>
              <td colspan="7">
                <div class="empty-state empty-state--compact py-6">
                  <i data-lucide="gamepad-2"></i>
                  <p class="text-lg font-semibold text-ink">No recent tickets</p>
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
          .map((bet) => `
            <tr>
              <td data-label="Ticket">${bet.bet_id}</td>
              <td data-label="Game">${bet.game_name || "Game"}</td>
              <td data-label="Cash Back Type">${bet.bet_type_name || "Cashback"}</td>
              <td data-label="Stake Amount">${formatCurrency(bet.bet_stake_amount || 0)}</td>
              <td data-label="Cash Back ID">${bet.bet_cashback_id || "-"}</td>
              <td data-label="Date">${bet.bet_placed_at ? new Date(bet.bet_placed_at).toLocaleString("en-NG") : "N/A"}</td>
              <td data-label="Numbers">
                <button class="action-button action-button-soft" type="button" data-view-numbers="${bet.bet_id}">
                  View Numbers
                </button>
              </td>
            </tr>
          `)
          .join("");
      }

      let historyRows = [];
      let historySearch = "";
      let historySort = "newest";
      let historyPage = 1;
      const historyPageSize = 6;

      function applyHistoryFilters() {
        let data = [...historyRows];
        if (historySearch) {
          const q = historySearch.toLowerCase();
          data = data.filter((bet) => {
            const haystack = [
              bet.bet_id,
              bet.game_name,
              bet.bet_type_name,
              bet.bet_cashback_id
            ].join(" ").toLowerCase();
            return haystack.includes(q);
          });
        }
        data.sort((a, b) => {
          const dateA = new Date(a.bet_placed_at || 0).getTime();
          const dateB = new Date(b.bet_placed_at || 0).getTime();
          const stakeA = Number(a.bet_stake_amount || 0);
          const stakeB = Number(b.bet_stake_amount || 0);
          if (historySort === "oldest") return dateA - dateB;
          if (historySort === "stake_desc") return stakeB - stakeA;
          if (historySort === "stake_asc") return stakeA - stakeB;
          return dateB - dateA;
        });

        const totalPages = Math.max(1, Math.ceil(data.length / historyPageSize));
        if (historyPage > totalPages) historyPage = totalPages;
        const start = (historyPage - 1) * historyPageSize;
        const paged = data.slice(start, start + historyPageSize);
        renderHistory(paged);
        renderPagination(document.getElementById("agentCashbackPagination"), historyPage, totalPages);
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

      async function loadHistory() {
        const storedAgent = localStorage.getItem("agent_profile");
        const agentProfile = storedAgent ? JSON.parse(storedAgent) : null;
        const agentId = agentProfile?.id;

        if (!agentId) {
          historyRows = [];
          applyHistoryFilters();
          return;
        }

        try {
          const response = await axios.get(`${basePath}api/bet/with-numbers-by-agent`, {
            params: { agent_id: agentId }
          });
          const rows = Array.isArray(response?.data?.message) ? response.data.message : [];
          const map = new Map();
          rows.forEach((row) => {
            if (String(row.bet_mode || "").toLowerCase() !== "cashback") return;
            const id = row.bet_id;
            if (!id) return;
            if (!map.has(id)) {
              map.set(id, {
                bet_id: row.bet_id,
                bet_placed_at: row.bet_placed_at,
                bet_stake_amount: row.bet_stake_amount,
                bet_cashback_id: row.bet_cashback_id,
                bet_status: row.bet_status,
                game_name: row.game_name,
                bet_type_name: row.bet_type_name,
                numbers: []
              });
            }
            if (row.bet_number !== null && row.bet_number !== undefined) {
              map.get(id).numbers.push(row.bet_number);
            }
          });
          historyRows = Array.from(map.values());
          applyHistoryFilters();
        } catch {
          historyRows = [];
          applyHistoryFilters();
        }
      }

      function generateBetId() {
        const partA = Math.random().toString(36).slice(2, 10).toUpperCase();
        const partB = Math.random().toString(36).slice(2, 7).toUpperCase();
        return `TKT-${partA}-${partB}`;
      }

      function showToast(message, type = "success", title) {
        if (typeof window.showToast === "function") {
          window.showToast(message, type, title);
        } else {
          alert(message);
        }
      }

      function closeSuccessModal() {
        successModal?.classList.remove("is-open");
        document.body.classList.remove("overflow-hidden");
      }

      let countdownTimer = null;
      let countdownInterval = null;
      function startSuccessCountdown(seconds = 5) {
        const countdownEl = document.getElementById("successCountdown");
        const countdownBar = document.getElementById("successCountdownBar");
        let remaining = seconds;

        if (countdownEl) countdownEl.textContent = String(remaining);
        if (countdownBar) countdownBar.style.width = "100%";

        clearInterval(countdownInterval);
        clearTimeout(countdownTimer);

        countdownInterval = setInterval(() => {
          remaining -= 1;
          if (countdownEl) countdownEl.textContent = String(Math.max(remaining, 0));
          if (countdownBar) {
            const percent = Math.max(remaining, 0) / seconds;
            countdownBar.style.width = `${percent * 100}%`;
          }
        }, 1000);

        countdownTimer = setTimeout(() => {
          closeSuccessModal();
        }, seconds * 1000);
      }

      window.handleAgentCashbackSubmit = async function (currentReceipt, draftGames) {
        const storedAgent = localStorage.getItem("agent_profile");
        const agentProfile = storedAgent ? JSON.parse(storedAgent) : null;
        const agentId = agentProfile?.id;

        if (!agentId) {
          showToast("Agent session not found. Please log in again.", "error", "Unauthorized");
          return true;
        }

        if (!Array.isArray(draftGames) || !draftGames.length) {
          showToast("No games to submit.", "error", "Missing games");
          return true;
        }

        const draft = draftGames[0];
        const betTypeKey = String(draft.cashBackType || "").toLowerCase();
        const betTypeId = betTypeIdMap.get(betTypeKey);
        const selections = Array.isArray(draft.selections) ? draft.selections.map((num) => Number(num)) : [];

        if (!draft.gameId || !betTypeId || !draft.cashBackId) {
          showToast("Missing game, cash back type, or cash back id.", "error", "Invalid data");
          return true;
        }

        try {
          const payload = {
            id: generateBetId(),
            agent_id: agentId,
            game_id: draft.gameId,
            bet_type_id: betTypeId,
            mode: "cashback",
            stake_amount: Number(draft.stakeAmount || 0),
            total_games_played: 1,
            cashback_id: draft.cashBackId,
            status: "pending",
            numbers: selections
          };

          const response = await axios.post(`${basePath}api/bet/create`, payload);
          const betId = response?.data?.message?.bet_id;
          currentReceipt.betIds = betId ? [betId] : [];
          currentReceipt.bets = [{ ...payload, bet_id: betId || null }];

          sessionStorage.setItem("blueextra-receipt", JSON.stringify(currentReceipt));
          sessionStorage.setItem(
            "blueextra-toast",
            JSON.stringify({
              message: "Ticket submitted successfully. Receipt is ready to print.",
              type: "success",
              title: "Transaction submitted"
            })
          );

          playModal?.classList.remove("is-open");
          document.body.classList.remove("overflow-hidden");
          successModal?.classList.add("is-open");
          startSuccessCountdown(5);
          await loadHistory();
          await updateAgentTodayStats();
          return true;
        } catch (error) {
          const message = error?.response?.data?.message || error?.message || "Failed to submit transaction.";
          showToast(message, "error", "Submission failed");
          return true;
        }
      };

      printTicketButton?.addEventListener("click", () => {
        window.print();
      });

      closeSuccessModalBtn?.addEventListener("click", closeSuccessModal);
      successGoBackBtn?.addEventListener("click", closeSuccessModal);
      successViewReceiptBtn?.addEventListener("click", () => {
        window.location.href = `${basePath}agent/receipt`;
      });
      successModal?.addEventListener("click", (event) => {
        if (event.target === successModal) {
          closeSuccessModal();
        }
      });

      document.getElementById("agentCashbackSearchInput")?.addEventListener("input", (event) => {
        historySearch = event.target.value.trim();
        historyPage = 1;
        applyHistoryFilters();
      });

      document.getElementById("agentCashbackSort")?.addEventListener("change", (event) => {
        historySort = event.target.value;
        historyPage = 1;
        applyHistoryFilters();
      });

      document.getElementById("agentCashbackPagination")?.addEventListener("click", (event) => {
        const target = event.target.closest("[data-page]");
        if (!target) return;
        const page = Number(target.getAttribute("data-page"));
        if (!Number.isNaN(page)) {
          historyPage = Math.max(1, page);
          applyHistoryFilters();
        }
      });

      const numbersModal = document.getElementById("cashbackNumbersModal");
      const numbersModalClose = document.getElementById("closeCashbackNumbersModal");
      const numbersModalBody = document.getElementById("cashbackNumbersBody");
      const numbersModalTicket = document.getElementById("cashbackNumbersTicket");
      const printCashbackTicketBtn = document.getElementById("printCashbackTicket");
      let currentNumbersBet = null;

      function openNumbersModal(bet) {
        if (!numbersModal || !numbersModalBody) return;
        const numbers = (bet.numbers || []).map((num) => `<span class="number-chip">${String(num).padStart(2, "0")}</span>`).join("");
        numbersModalBody.innerHTML = numbers || "<p class=\"text-sm text-muted\">No numbers recorded.</p>";
        if (numbersModalTicket) {
          numbersModalTicket.textContent = `Ticket: ${bet.bet_id}`;
        }
        currentNumbersBet = bet;
        numbersModal.classList.add("is-open");
        document.body.classList.add("overflow-hidden");
      }

      function closeNumbersModal() {
        numbersModal?.classList.remove("is-open");
        document.body.classList.remove("overflow-hidden");
      }

      numbersModalClose?.addEventListener("click", closeNumbersModal);
      numbersModal?.addEventListener("click", (event) => {
        if (event.target === numbersModal) {
          closeNumbersModal();
        }
      });

      function buildReceiptFromCashbackBet(bet) {
        const totalGames = Number(bet.bet_total_games_played || 1);
        const stake = Number(bet.bet_stake_amount || 0);
        const amountPlayed = stake * totalGames;
        return {
          ticketCode: bet.bet_id || `TK-${Math.floor(10000 + Math.random() * 89999)}`,
          playedAt: bet.bet_placed_at || Date.now(),
          totalGames,
          totalStakeAmount: amountPlayed,
          earnedAmount: 0,
          status: bet.bet_status || "printed",
          items: [
            {
              gameName: bet.game_name || "Game",
              betType: bet.bet_type_name || "Cashback",
              selections: Array.isArray(bet.numbers) ? bet.numbers.map((num) => String(num).padStart(2, "0")) : [],
              stakeAmount: stake,
              unitPerPerm: bet.bet_cashback_id || bet.cashback_id || "",
              amountPlayed
            }
          ]
        };
      }

      printCashbackTicketBtn?.addEventListener("click", () => {
        if (!currentNumbersBet) {
          window.showToast?.("No ticket selected for printing.", "error", "Print failed");
          return;
        }
        const receipt = buildReceiptFromCashbackBet(currentNumbersBet);
        sessionStorage.setItem("blueextra-receipt", JSON.stringify(receipt));
        sessionStorage.setItem(
          "blueextra-toast",
          JSON.stringify({
            message: "Receipt loaded. Ready to print.",
            type: "success",
            title: "Receipt ready"
          })
        );
        closeNumbersModal();
        window.location.href = `${basePath}agent/receipt`;
      });

      document.getElementById("agentCashbackHistoryTable")?.addEventListener("click", (event) => {
        const trigger = event.target.closest("[data-view-numbers]");
        if (!trigger) return;
        const betId = trigger.getAttribute("data-view-numbers");
        const bet = historyRows.find((row) => row.bet_id === betId);
        if (bet) {
          openNumbersModal(bet);
        }
      });

      loadCashbackGames();
      loadCashbackTypes();
      loadTodayResult();
      updateAgentTodayStats();
      loadHistory();

      ensureCashbackId();
      cashBackIdInput?.addEventListener("click", ensureCashbackId);
    })();
  </script>
</body>

</html>
