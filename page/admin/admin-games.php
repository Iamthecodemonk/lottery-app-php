<?php
require_once('./middleware/middleware.php');
use Middleware\Middleware;
$jwtUser = Middleware::currentJwtUser();
$adminId = $jwtUser['id'] ?? '';
?>
<?php include_once('includes/head.php'); ?>

<body class="min-h-screen bg-shell font-body text-ink" data-page="admin-games">
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
                    <h1 class="mt-2 font-display text-3xl font-bold">Manage Games</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-muted">
                      UI-only screen for adding new lotto games and removing old ones from the active platform list.
                    </p>
                  </div>
                </div>
                <span class="status-pill">Game Control</span>
              </div>
            </header>

          <section class="mt-6 grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
            <article class="form-card">
              <p class="text-sm uppercase tracking-[0.35em] text-muted">Create Game</p>
              <h2 class="mt-2 font-display text-2xl font-bold">Add a new game</h2>
              <form id="addGameForm" class="mt-6 form-grid" data-admin-id="<?php echo htmlspecialchars($adminId, ENT_QUOTES, 'UTF-8'); ?>">
                <div>
                  <label class="auth-label" for="gameName">Game Name</label>
                  <input id="gameName" name="gameName" type="text" class="form-input" placeholder="Lucky Midday Draw"
                    required />
                </div>
                <div>
                  <label class="auth-label" for="gameCategory">Category</label>
                  <select id="gameCategory" name="gameCategory" class="form-input" required>
                    <option value="" selected disabled>Select category</option>
                    <option value="lotto">Lotto</option>
                    <option value="cashback">Cashback</option>
                  </select>
                </div>
                <div>
                  <label class="auth-label" for="gameStatus">Status</label>
                  <select id="gameStatus" name="gameStatus" class="form-input" required>
                    <option value="active" selected>Active</option>
                    <option value="inactive">Inactive</option>
                  </select>
                </div>
                <div>
                  <label class="auth-label" for="drawTime">Draw Time</label>
                  <input id="drawTime" name="drawTime" type="datetime-local" class="form-input" required />
                </div>
                <input type="hidden" id="createdBy" name="createdBy" value="<?php echo htmlspecialchars($adminId, ENT_QUOTES, 'UTF-8'); ?>" />
                <p id="gameFormError" class="hidden text-sm text-red-300"></p>
                <p id="gameFormSuccess" class="hidden text-sm text-emerald-300"></p>
                <button type="submit" class="action-button">Add Game</button>
              </form>
            </article>

            <article class="panel-card">
              <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                  <p class="text-sm uppercase tracking-[0.35em] text-muted">Active Games</p>
                  <h2 class="mt-2 font-display text-2xl font-bold">Current game list</h2>
                </div>
                <button id="openAllGamesModal" type="button" class="action-button action-button-soft">
                  View all games
                </button>
              </div>
              <div id="gameList" class="mt-6 stack-grid"></div>
            </article>
          </section>

          <section class="mt-6 panel-card">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Game Logs</p>
                <h2 class="mt-2 font-display text-2xl font-bold">Recent changes</h2>
              </div>
              <span class="status-pill">7-Day Retention</span>
            </div>
            <div id="gameLogs" class="mt-6"></div>
          </section>

          <!-- Footer -->
          <?php include_once('includes/footer.php'); ?>
        </div>
      </main>
    </div>
  </div>

  <!-- All Games Modal -->
  <div id="allGamesModal" class="modal-backdrop">
    <div class="modal-card">
      <div class="flex items-start justify-between gap-4">
        <div>
          <p class="text-sm uppercase tracking-[0.35em] text-muted">All Games</p>
          <h2 class="mt-2 font-display text-2xl font-bold">Full game list</h2>
        </div>
        <button id="closeAllGamesModal" type="button" class="topbar-menu-button" aria-label="Close modal">
          <i data-lucide="x"></i>
        </button>
      </div>
      <div id="allGamesList" class="mt-6 stack-grid"></div>
    </div>
  </div>

  <!-- Page Scripts -->
  <?php include_once('includes/scripts.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    (function () {
      const form = document.getElementById("addGameForm");
      const errorEl = document.getElementById("gameFormError");
      const successEl = document.getElementById("gameFormSuccess");

      const basePath = "/lt/";
      const createUrl = `${basePath}api/game/create`;

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

      form.addEventListener(
        "submit",
        async function (event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();
        errorEl.classList.add("hidden");
        successEl.classList.add("hidden");

        const gameName = document.getElementById("gameName").value.trim();
        const category = document.getElementById("gameCategory").value;
        const status = document.getElementById("gameStatus").value;
        const rawCutoffTime = document.getElementById("drawTime").value.trim();
        const createdBy = document.getElementById("createdBy").value.trim();
        const cutoffTime = rawCutoffTime
          ? rawCutoffTime.replace("T", " ") + (rawCutoffTime.length === 16 ? ":00" : "")
          : "";

        if (!createdBy) {
          showError("Admin session not found. Please log in again.");
          return;
        }
        console.log("Submitting game:", { gameName, category, status, cutoffTime, createdBy });
        if (!gameName || !category || !status || !cutoffTime) {
          showError("Please fill all required fields.");
          return;
        }

        try {
          const response = await axios.post(createUrl, {
            game_name: gameName,
            category: category,
            status: status,
            cutoff_time: cutoffTime,
            created_by: createdBy,
          });
          console.log("Create game response:", response);
          if (response.data && response.data.state) {
            showSuccess("Game created successfully.");
            form.reset();
            document.getElementById("gameStatus").value = "active";
            if (typeof window.refreshAdminGames === "function") {
              window.refreshAdminGames();
            }
            return;
          }

          showError(response.data?.message || "Failed to create game.");
        } catch (error) {
          alert(error);
          const message =
            error.response?.data?.message ||
            error.message ||
            "Failed to create game.";
          showError(message);
          console.log("Error creating game:", error);
        }
      },
      true
      );
    })();
  </script>

</body>

</html>
