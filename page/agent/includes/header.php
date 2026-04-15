 <div class="topbar">
            <div class="topbar-shell">
              <div class="topbar-left">
                <button id="openSidebar" class="topbar-menu-button lg:hidden" type="button" aria-label="Open menu">
                  <i data-lucide="menu"></i>
                </button>
                <span class="topbar-brand">Blue Extra Lotto</span>
              </div>
              <div class="user-menu">
                <button class="user-menu-button" type="button" data-user-menu-button aria-label="Open user menu">
                  <span class="user-avatar"><i data-lucide="user"></i></span>
                  <span class="user-menu-copy">
                    <strong id="agentMenuName">Loading</strong>
                    <span id="agentMenuMeta">Agent Account</span>
                  </span>
                  <i data-lucide="chevron-down"></i>
                </button>
                <div class="user-menu-panel">
                  <!-- <a class="user-menu-link" href="#"><span>Profile</span><i data-lucide="user-round-cog"></i></a> -->
                  <!-- <a class="user-menu-link" href="#"><span>Outlet Settings</span><i data-lucide="settings"></i></a> -->
                  <!-- <a class="user-menu-link" href="#"><span>Help</span><i data-lucide="circle-help"></i></a> -->
                  <button class="user-menu-link" type="button" data-install-app>
                    <span>Install App</span><i data-lucide="download"></i>
                  </button>
                  <a class="user-menu-link" href="/lt/agent/logout"><span>Sign Out</span><i data-lucide="log-out"></i></a>
                </div>
              </div>
            </div>
          </div>
          <script>
            (function () {
              const nameEl = document.getElementById("agentMenuName");
              const metaEl = document.getElementById("agentMenuMeta");
              const stored = localStorage.getItem("agent_profile");
              if (!stored) return;
              try {
                const agent = JSON.parse(stored);
                const displayName =
                  agent?.name ||
                  agent?.full_name ||
                  agent?.agent_name ||
                  agent?.username ||
                  agent?.email ||
                  agent?.id ||
                  "Agent";
                if (nameEl) nameEl.textContent = displayName;
                if (metaEl) metaEl.textContent = agent?.email || agent?.phone || "Agent Account";
              } catch {
                // ignore parse errors
              }
            })();
          </script>

<?php
$agentHeaderTitle = $agentHeaderTitle ?? 'Play Cash Back';
$agentHeaderDescription = $agentHeaderDescription ?? 'This page gives the agent a clear place to play one cash back game at a time, review daily performance, and track recent play history.';
$agentHeaderActionLabel = $agentHeaderActionLabel ?? 'Play Cash Back';
$agentHeaderActionHref = $agentHeaderActionHref ?? '#';
$agentHeaderActionId = $agentHeaderActionId ?? 'openPlayGameAction';
?>

          <!-- Page Header -->
          <header
            class="topbar-offset rounded-[2rem] border border-white/10 bg-white/5 px-5 py-4 shadow-panel backdrop-blur-xl sm:px-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
              <div>
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Agent Module</p>
                <h1 class="mt-2 font-display text-3xl font-bold sm:text-4xl"><?php echo htmlspecialchars($agentHeaderTitle, ENT_QUOTES, 'UTF-8'); ?></h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-muted sm:text-base">
                  <?php echo htmlspecialchars($agentHeaderDescription, ENT_QUOTES, 'UTF-8'); ?>
                </p>
              </div>
              <?php if (!empty($agentHeaderActionLabel)) : ?>
                <a id="<?php echo htmlspecialchars($agentHeaderActionId, ENT_QUOTES, 'UTF-8'); ?>" class="action-button" href="<?php echo htmlspecialchars($agentHeaderActionHref, ENT_QUOTES, 'UTF-8'); ?>">
                  <i data-lucide="play-circle"></i>
                  <span><?php echo htmlspecialchars($agentHeaderActionLabel, ENT_QUOTES, 'UTF-8'); ?></span>
                </a>
              <?php endif; ?>
            </div>
          </header>
