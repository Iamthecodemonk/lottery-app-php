<?php
require_once('./middleware/middleware.php');

use Middleware\Middleware;

$currentAdmin = Middleware::currentJwtUser();
$adminName = trim((string) ($currentAdmin['name'] ?? $currentAdmin['email'] ?? 'Admin User'));
if ($adminName === '') {
  $adminName = 'Admin User';
}
?>

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
                    <strong><?php echo htmlspecialchars($adminName, ENT_QUOTES, 'UTF-8'); ?></strong>
                    <span>Platform Admin</span>
                  </span>
                  <i data-lucide="chevron-down"></i>
                </button>
                <div class="user-menu-panel">
                  <!-- <a class="user-menu-link" href="#"><span>Profile</span><i data-lucide="user-round-cog"></i></a> -->
                  <!-- <a class="user-menu-link" href="#"><span>Account Settings</span><i data-lucide="settings"></i></a> -->
                  <!-- <a class="user-menu-link" href="#"><span>Support</span><i data-lucide="life-buoy"></i></a> -->
                  <button class="user-menu-link" type="button" data-install-app>
                    <span>Install App</span><i data-lucide="download"></i>
                  </button>
                  <a class="user-menu-link" href="/lt/admin/logout"><span>Sign Out</span><i data-lucide="log-out"></i></a>
                </div>
              </div>
            </div>
          </div>
