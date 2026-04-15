<?php include_once('includes/head.php'); ?>

<body class="min-h-screen bg-shell font-body text-ink" data-page="agent-play">
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
      <!-- Sidebar Overlay -->
      <!-- <div id="sidebarOverlay" class="fixed inset-0 z-40 hidden bg-black/50 backdrop-blur-sm lg:hidden"></div> -->

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
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Game History</p>
                <h2 class="mt-2 font-display text-2xl font-bold">Recently played games</h2>
              </div>
              <span class="status-pill">Agent History</span>
            </div>
            <div class="border-b border-white/10 px-6 py-5">
              <div class="grid gap-4 lg:grid-cols-[1fr_auto_auto] lg:items-end">
                <label class="block">
                  <span class="result-label">Search History</span>
                  <input id="agentPlaySearchInput" class="form-input mt-3" type="search"
                    placeholder="Search by ticket, game, bet type, or selected number" />
                </label>
                <!--
                <div>
                  <p class="result-label">Filter Status</p>
                  <div class="filter-tabs mt-3">
                    <button class="filter-tab is-active" type="button" data-play-filter="all">All</button>
                    <button class="filter-tab" type="button" data-play-filter="printed">Printed</button>
                    <button class="filter-tab" type="button" data-play-filter="confirmed">Confirmed</button>
                  </div>
                </div>
                -->
                <div>
                  <p class="result-label">Sort By</p>
                  <select id="agentPlaySort" class="form-select mt-3">
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
                    <th>Game Summary</th>
                    <th>Selected Numbers</th>
                    <th>Total Games</th>
                    <th>Grand Stake</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="agentPlayHistoryTable"></tbody>
              </table>
            </div>
            <div id="agentPlayPagination" class="px-6 py-5"></div>
          </section>

          <!-- Footer -->
          <?php include_once('includes/footer.php'); ?>
        </div>
      </main>
    </div>
  </div>

  <!-- Play Lotto Game Modal -->
  <div id="playGameModal" class="modal-backdrop" aria-hidden="true">
    <div class="modal-card modal-card--wide">
      <!-- Modal Header -->
      <div class="flex items-start justify-between gap-4">
        <div>
          <p class="text-sm uppercase tracking-[0.35em] text-muted">Agent Play Flow</p>
          <h2 class="mt-2 font-display text-3xl font-bold">Build Lotto Games</h2>
          <p class="mt-3 max-w-3xl text-sm leading-6 text-muted">
            Select up to 20 numbers from 1 to 90, complete the game details, add more games if needed, then proceed to
            printing.
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
                <h3 class="mt-2 text-xl font-semibold text-ink">Select up to 20 numbers</h3>
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
              <h3 class="mt-2 text-xl font-semibold text-ink">Attach play details</h3>
            </div>
            <form id="playGameForm" class="form-grid mt-6">
              <input id="editingDraftId" type="hidden" />
              <label class="block">
                <span class="result-label">Game</span>
                <select id="playGameSelect" class="form-select mt-3"></select>
              </label>
              <label class="block">
                <span class="result-label">Bet Type</span>
                <select id="playBetType" class="form-select mt-3"></select>
              </label>
              <label class="block">
                <span class="result-label">Stake Amount</span>
                <input id="playStakeAmount" class="form-input mt-3" type="number" min="0" step="100"
                  placeholder="Enter stake amount" />
              </label>
              <label class="block">
                <span class="result-label">Unit Per Perm</span>
                <input id="playUnitPerPerm" class="form-input mt-3" type="number" min="1" step="1"
                  placeholder="Enter unit per perm" />
              </label>
              <div class="lg:col-span-2">
                <div class="info-row">
                  <span class="text-sm text-muted">Calculated Stake</span>
                  <span id="playCalculatedStake" class="text-sm font-semibold text-ink">₦ 0.00</span>
                </div>
                <p id="playStakeError" class="mt-2 hidden text-sm text-red-300"></p>
              </div>
            </form>
            <div class="mt-6 flex flex-wrap gap-3">
              <button id="addMoreGamesAction" class="action-button" type="button">
                <i data-lucide="plus"></i>
                <span id="builderPrimaryActionLabel">Add More Games</span>
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
                <p class="result-label">Games Played</p>
                <h3 class="mt-2 text-xl font-semibold text-ink">Ready for printing</h3>
              </div>
              <div class="play-counter play-counter--compact">
                <span id="draftGamesCount">0</span>
                <small>staged</small>
              </div>
            </div>
            <div id="draftGamesList" class="mt-5 stack-grid"></div>
          </section>

          <section class="soft-card">
            <p class="result-label">Printing Summary</p>
            <div class="mt-4 space-y-4">
              <div class="info-row">
                <span class="text-sm text-muted">Total staged games</span>
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
                Single or multiple games under this ticket will be submitted as one transaction and prepared for
                printing.
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
    window.useLiveAgentPlay = true;
  </script>

  <!-- Page Scripts -->
  <?php include_once('includes/scripts.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    (function () {
      const basePath = "/lt/";
      const gameSelect = document.getElementById("playGameSelect");
      const betTypeSelect = document.getElementById("playBetType");
      const stakeAmountInput = document.getElementById("playStakeAmount");
      const unitPerPermInput = document.getElementById("playUnitPerPerm");
      const selectedCountEl = document.getElementById("playSelectionCount");
      const calculatedStakeEl = document.getElementById("playCalculatedStake");
      const stakeErrorEl = document.getElementById("playStakeError");
      const submitReceiptButton = document.getElementById("submitReceiptAction");
      const printTicketButton = document.getElementById("printTicketAction");
      const playModal = document.getElementById("playGameModal");
      const successModal = document.getElementById("playSuccessModal");
      const closeSuccessModalBtn = document.getElementById("closeSuccessModal");
      const successGoBackBtn = document.getElementById("successGoBack");
      const successViewReceiptBtn = document.getElementById("successViewReceipt");
      const betTypeIdMap = new Map();

      function formatDate(value) {
        const normalized = value && typeof value === "string" ? value.replace(" ", "T") : value;
        const date = new Date(normalized);
        if (Number.isNaN(date.getTime())) {
          return "Not set";
        }
        return date.toLocaleString("en-NG", {
          day: "numeric",
          month: "short",
          year: "numeric",
          hour: "numeric",
          minute: "2-digit"
        });
      }

      function renderGameOptions(games) {
        if (!gameSelect) return;
        if (!Array.isArray(games) || !games.length) {
          gameSelect.innerHTML = '<option value="">No lotto games available</option>';
          return;
        }

        gameSelect.innerHTML = [
          '<option value="">Select game</option>',
          ...games.map((game) => {
            const name = game.game_name || game.name || "Game";
            const drawTime = game.cutoff_time ? formatDate(game.cutoff_time) : "Not set";
            return `<option value="${game.id}">${name} - ${drawTime}</option>`;
          })
        ].join("");
      }

      function renderBetTypeOptions(types) {
        if (!betTypeSelect) return;
        if (!Array.isArray(types) || !types.length) {
          betTypeSelect.innerHTML = '<option value="">No bet types available</option>';
          return;
        }

        betTypeIdMap.clear();
        betTypeSelect.innerHTML = [
          '<option value="">Select bet type</option>',
          ...types.map((type) => {
            const name = type.name || type.bet_type_name || "Bet type";
            const permMatch = String(name).match(/perm\s*(\d+)/i);
            const permSize = permMatch ? Number.parseInt(permMatch[1], 10) : "";
            if (type.id) {
              betTypeIdMap.set(String(name).toLowerCase(), type.id);
            }
            return `<option value="${name}" data-id="${type.id}" data-perm="${permSize}">${name}</option>`;
          })
        ].join("");
      }

      async function loadLottoGames() {
        if (!gameSelect) return;
        try {
          const response = await axios.get(`${basePath}api/game/all`);
          const rows = Array.isArray(response?.data?.message) ? response.data.message : [];
          const lottoGames = rows.filter((game) => {
            const category = String(game.category || game.game_category || "").toLowerCase();
            return category === "lotto" || category === "placebet";
          });
          renderGameOptions(lottoGames);
        } catch (error) {
          renderGameOptions([]);
        }
      }

      async function loadBetTypes() {
        if (!betTypeSelect) return;
        try {
          const response = await axios.get(`${basePath}api/bet-type/by-category`, {
            params: { category: "lotto" }
          });
          const rows = Array.isArray(response?.data?.message) ? response.data.message : [];
          renderBetTypeOptions(rows);
        } catch (error) {
          renderBetTypeOptions([]);
        }
      }

      function formatCurrency(value) {
        const amount = Number(value || 0);
        return `₦ ${amount.toLocaleString("en-NG", { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
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
        } catch (error) {
          renderLatestResultToday(null);
        }
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

      function renderRecentGames(rows) {
        const tbody = document.getElementById("agentPlayHistoryTable");
        if (!tbody) return;

        if (!Array.isArray(rows) || !rows.length) {
          tbody.innerHTML = `
            <tr>
              <td colspan="8">
                <div class="empty-state empty-state--compact py-6">
                  <i data-lucide="gamepad-2"></i>
                  <p class="text-lg font-semibold text-ink">No recent games</p>
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
          .map((bet) => {
            const gameName = bet.game_name || "Game";
            const betTypeName = bet.bet_type_name || "Bet";
            const numbers = (bet.numbers || [])
              .map((num) => `<span class="number-chip">${String(num).padStart(2, "0")}</span>`)
              .join("");
            const totalGames = Number(bet.bet_total_games_played || 0);
            const stake = Number(bet.bet_stake_amount || 0);
            const grandStake = stake * (totalGames || 1);
            const placedAt = bet.bet_placed_at || bet.placed_at;
            return `
              <tr>
                <td data-label="Ticket">${bet.bet_id}</td>
                <td data-label="Game Summary">
                  <p class="text-sm font-semibold text-ink">${gameName}</p>
                  <p class="text-xs text-muted">${betTypeName}</p>
                </td>
                <td data-label="Selected Numbers">
                  <div class="number-chip-row">${numbers}</div>
                </td>
                <td data-label="Total Games">${totalGames}</td>
                <td data-label="Grand Stake">${formatCurrency(grandStake)}</td>
                <td data-label="Date">${placedAt ? new Date(placedAt).toLocaleString("en-NG") : "N/A"}</td>
                <td data-label="Action">
                  <button class="action-button action-button-soft" type="button" data-print-ticket="${bet.bet_id}">
                    <i data-lucide="printer"></i>
                    <span>Print</span>
                  </button>
                </td>
              </tr>
            `;
          })
          .join("");
      }

      function renderPagination(container, currentPage, totalPages) {
        if (!container) return;
        if (totalPages <= 1) {
          container.innerHTML = "";
          return;
        }

        const pages = [];
        for (let i = 1; i <= totalPages; i += 1) {
          pages.push(i);
        }

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

      let recentGamesState = [];
      let historySearch = "";
      let historyStatus = "all";
      let historySort = "newest";
      let historyPage = 1;
      const historyPageSize = 6;

      function applyHistoryFilters() {
        let data = Array.isArray(recentGamesState) ? [...recentGamesState] : [];

        // Status filter removed from UI.

        if (historySearch) {
          const q = historySearch.toLowerCase();
          data = data.filter((bet) => {
            const haystack = [
              bet.bet_id,
              bet.game_name,
              bet.bet_type_name,
              ...(bet.numbers || [])
            ]
              .join(" ")
              .toLowerCase();
            return haystack.includes(q);
          });
        }

        data.sort((a, b) => {
          const dateA = new Date(a.bet_placed_at || a.placed_at || 0).getTime();
          const dateB = new Date(b.bet_placed_at || b.placed_at || 0).getTime();
          const stakeA = Number(a.bet_stake_amount || 0) * (Number(a.bet_total_games_played || 1));
          const stakeB = Number(b.bet_stake_amount || 0) * (Number(b.bet_total_games_played || 1));
          if (historySort === "oldest") return dateA - dateB;
          if (historySort === "stake_desc") return stakeB - stakeA;
          if (historySort === "stake_asc") return stakeA - stakeB;
          return dateB - dateA;
        });

        return data;
      }

      function renderHistory() {
        const filtered = applyHistoryFilters();
        const totalPages = Math.max(1, Math.ceil(filtered.length / historyPageSize));
        if (historyPage > totalPages) historyPage = totalPages;
        const start = (historyPage - 1) * historyPageSize;
        const paged = filtered.slice(start, start + historyPageSize);
        renderRecentGames(paged);
        renderPagination(document.getElementById("agentPlayPagination"), historyPage, totalPages);
      }

      function buildReceiptFromBet(bet) {
        const totalGames = Number(bet.bet_total_games_played || 1);
        const stake = Number(bet.bet_stake_amount || 0);
        const amountPlayed = stake * totalGames;
        return {
          ticketCode: bet.bet_id || `TK-${Math.floor(10000 + Math.random() * 89999)}`,
          playedAt: bet.bet_placed_at || bet.placed_at || Date.now(),
          totalGames,
          totalStakeAmount: amountPlayed,
          earnedAmount: 0,
          status: bet.bet_status || "printed",
          items: [
            {
              gameName: bet.game_name || "Game",
              betType: bet.bet_type_name || "Bet",
              selections: Array.isArray(bet.numbers) ? bet.numbers.map((num) => String(num).padStart(2, "0")) : [],
              stakeAmount: stake,
              unitPerPerm: 1,
              amountPlayed
            }
          ]
        };
      }

      async function loadRecentGames() {
        const storedAgent = localStorage.getItem("agent_profile");
        const agentProfile = storedAgent ? JSON.parse(storedAgent) : null;
        const agentId = agentProfile?.id;

        if (!agentId) {
          renderRecentGames([]);
          return;
        }

        try {
          const response = await axios.get(`${basePath}api/bet/with-numbers-by-agent`, {
            params: { agent_id: agentId }
          });
          const rows = Array.isArray(response?.data?.message) ? response.data.message : [];
          const map = new Map();
          rows.forEach((row) => {
            const id = row.bet_id;
            if (!id) return;
            if (!map.has(id)) {
              map.set(id, {
                bet_id: row.bet_id,
                bet_placed_at: row.bet_placed_at,
                bet_total_games_played: row.bet_total_games_played,
                bet_stake_amount: row.bet_stake_amount,
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
          recentGamesState = Array.from(map.values());
          renderHistory();
        } catch (error) {
          recentGamesState = [];
          renderHistory();
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
          const todayBets = bets.filter((bet) => isToday(bet.placed_at || bet.bet_placed_at));
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
        } catch (error) {
          setText("agentAmountEarnedToday", formatCurrency(0));
          setText("agentGamesPlayedToday", "0");
        }
      }

      function nCr(n, r) {
        if (r > n) return 0;
        if (r === 0 || r === n) return 1;
        let num = 1;
        let den = 1;
        for (let i = 1; i <= r; i += 1) {
          num *= n - (r - i);
          den *= i;
        }
        return num / den;
      }

      function getSelectedCount() {
        const count = Number.parseInt(selectedCountEl?.textContent || "0", 10);
        return Number.isNaN(count) ? 0 : count;
      }

      function showStakeError(message) {
        if (!stakeErrorEl) return;
        stakeErrorEl.textContent = message;
        stakeErrorEl.classList.remove("hidden");
      }

      function clearStakeError() {
        if (!stakeErrorEl) return;
        stakeErrorEl.textContent = "";
        stakeErrorEl.classList.add("hidden");
      }

      function getPermSizeFromSelection() {
        const option = betTypeSelect?.selectedOptions?.[0];
        if (!option) return null;
        const perm = Number.parseInt(option.dataset.perm || "", 10);
        return Number.isNaN(perm) ? null : perm;
      }

      function isPermType() {
        const label = String(betTypeSelect?.value || "").toLowerCase();
        return label.includes("perm");
      }

      function updateStakeCalculation() {
        if (!stakeAmountInput || !unitPerPermInput || !calculatedStakeEl) return;

        clearStakeError();

        const permSize = getPermSizeFromSelection();
        const selectedCount = getSelectedCount();
        const stakeAmount = Number(stakeAmountInput.value || 0);
        const unitPerPerm = Number(unitPerPermInput.value || 0);

        if (isPermType()) {
          if (selectedCount > 20) {
            showStakeError("Maximum 20 numbers allowed.");
            calculatedStakeEl.textContent = formatCurrency(0);
            return;
          }
          if (selectedCount < 3) {
            showStakeError("PERM requires at least 3 numbers.");
            calculatedStakeEl.textContent = formatCurrency(0);
            return;
          }
          const baseAmount = 5;
          stakeAmountInput.value = String(baseAmount);
          stakeAmountInput.readOnly = true;
          const combos = nCr(selectedCount, 2);
          unitPerPermInput.value = String(combos);
          unitPerPermInput.readOnly = true;
          calculatedStakeEl.textContent = formatCurrency(baseAmount * combos);
          return;
        }

        stakeAmountInput.readOnly = false;
        if (permSize) {
          if (selectedCount > 20) {
            showStakeError("Maximum 20 numbers allowed.");
            calculatedStakeEl.textContent = formatCurrency(0);
            return;
          }
          if (selectedCount < permSize) {
            showStakeError(`PERM ${permSize} requires at least ${permSize} numbers.`);
            calculatedStakeEl.textContent = formatCurrency(0);
            return;
          }
          const baseAmount = stakeAmount > 0 ? stakeAmount : 5;
          if (baseAmount <= 0) {
            showStakeError("Stake must be greater than 0.");
            calculatedStakeEl.textContent = formatCurrency(0);
            return;
          }
          if (!stakeAmountInput.value || Number(stakeAmountInput.value) <= 0) {
            stakeAmountInput.value = String(baseAmount);
          }
          const combos = nCr(selectedCount, permSize);
          unitPerPermInput.value = String(combos);
          unitPerPermInput.readOnly = true;
          calculatedStakeEl.textContent = formatCurrency(baseAmount * combos);
          return;
        }

        unitPerPermInput.readOnly = false;
        if (unitPerPermInput.value === "") {
          unitPerPermInput.value = "1";
        }
        if (stakeAmount <= 0) {
          showStakeError("Stake must be greater than 0.");
          calculatedStakeEl.textContent = formatCurrency(0);
          return;
        }
        if (unitPerPerm <= 0) {
          showStakeError("Unit per perm must be greater than 0.");
          calculatedStakeEl.textContent = formatCurrency(0);
          return;
        }
        calculatedStakeEl.textContent = formatCurrency(stakeAmount * unitPerPerm);
      }

      function watchSelectionCount() {
        if (!selectedCountEl) return;
        const observer = new MutationObserver(updateStakeCalculation);
        observer.observe(selectedCountEl, { childList: true, characterData: true, subtree: true });
      }

      betTypeSelect?.addEventListener("change", updateStakeCalculation);
      stakeAmountInput?.addEventListener("input", updateStakeCalculation);
      unitPerPermInput?.addEventListener("input", updateStakeCalculation);
      gameSelect?.addEventListener("change", updateStakeCalculation);

      function setSubmitLoading(isLoading) {
        if (!submitReceiptButton) return;
        submitReceiptButton.disabled = isLoading;
        submitReceiptButton.innerHTML = isLoading ? "Submitting..." : "<i data-lucide=\"check-check\"></i><span>Submit Transaction</span>";
        if (window.lucide && typeof window.lucide.createIcons === "function") {
          window.lucide.createIcons();
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

      window.handleAgentPlaySubmit = async function (currentReceipt, draftGames) {
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

        setSubmitLoading(true);

        try {
          const payloads = draftGames.map((draft) => {
            const betTypeKey = String(draft.betType || "").toLowerCase();
            const betTypeId = betTypeIdMap.get(betTypeKey);
            const selections = Array.isArray(draft.selections) ? draft.selections.map((num) => Number(num)) : [];
            const permMatch = String(draft.betType || "").match(/perm\s*(\d+)/i);
            const permSize = permMatch ? Number.parseInt(permMatch[1], 10) : null;
            const totalGamesPlayed = permSize ? nCr(selections.length, permSize) : 1;
            return {
              id: generateBetId(),
              agent_id: agentId,
              game_id: draft.gameId,
              bet_type_id: betTypeId,
              mode: "lotto",
              stake_amount: Number(draft.stakeAmount || 0),
              total_games_played: totalGamesPlayed,
              cashback_id: null,
              status: "pending",
              numbers: selections
            };
          });

          if (payloads.some((item) => !item.game_id || !item.bet_type_id)) {
            showToast("Missing game or bet type mapping. Please refresh and try again.", "error", "Invalid data");
            return true;
          }

          const responses = await Promise.all(
            payloads.map((payload) =>
              axios.post(`${basePath}api/bet/create`, payload)
            )
          );

          const betIds = responses
            .map((res) => res?.data?.message?.bet_id)
            .filter(Boolean);

          currentReceipt.betIds = betIds;
          currentReceipt.bets = payloads.map((payload, index) => ({
            ...payload,
            bet_id: betIds[index] || null
          }));

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
          return true;
        } catch (error) {
          const message = error?.response?.data?.message || error?.message || "Failed to submit transaction.";
          showToast(message, "error", "Submission failed");
          return true;
        } finally {
          setSubmitLoading(false);
        }
      };

      loadLottoGames();
      loadBetTypes().then(updateStakeCalculation);
      watchSelectionCount();
      updateStakeCalculation();
      updateAgentTodayStats();
      loadRecentGames();
      loadTodayResult();

      document.getElementById("agentPlaySearchInput")?.addEventListener("input", (event) => {
        historySearch = event.target.value.trim();
        historyPage = 1;
        renderHistory();
      });

      // Status filter handlers removed.

      document.getElementById("agentPlaySort")?.addEventListener("change", (event) => {
        historySort = event.target.value;
        historyPage = 1;
        renderHistory();
      });

      document.getElementById("agentPlayPagination")?.addEventListener("click", (event) => {
        const target = event.target.closest("[data-page]");
        if (!target) return;
        const page = Number(target.getAttribute("data-page"));
        if (!Number.isNaN(page)) {
          historyPage = Math.max(1, page);
          renderHistory();
        }
      });

      document.getElementById("agentPlayHistoryTable")?.addEventListener("click", (event) => {
        const button = event.target.closest("[data-print-ticket]");
        if (!button) return;
        const betId = button.getAttribute("data-print-ticket");
        const bet = recentGamesState.find((item) => item.bet_id === betId);
        if (!bet) {
          showToast("Unable to locate that ticket.", "error", "Print failed");
          return;
        }
        const receipt = buildReceiptFromBet(bet);
        sessionStorage.setItem("blueextra-receipt", JSON.stringify(receipt));
        sessionStorage.setItem(
          "blueextra-toast",
          JSON.stringify({
            message: "Receipt loaded. Ready to print.",
            type: "success",
            title: "Receipt ready"
          })
        );
        window.location.href = `${basePath}agent/receipt`;
      });

      printTicketButton?.addEventListener("click", () => {
        window.print();
      });

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
    })();
  </script>
</body>

</html>
