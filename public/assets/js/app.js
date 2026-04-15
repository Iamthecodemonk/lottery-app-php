const sidebar = document.getElementById("sidebar");
const sidebarOverlay = document.getElementById("sidebarOverlay");
const openSidebar = document.getElementById("openSidebar");
const closeSidebar = document.getElementById("closeSidebar");
const sectionTitle = document.getElementById("sectionTitle");
const sectionDescription = document.getElementById("sectionDescription");
const navLinks = document.querySelectorAll(".nav-link");

function ensureToastStack() {
  let stack = document.getElementById("toastStack");

  if (!stack) {
    stack = document.createElement("div");
    stack.id = "toastStack";
    stack.className = "toast-stack";
    document.body.appendChild(stack);
  }

  return stack;
}

window.showToast = function showToast(message, type = "success", title) {
  const stack = ensureToastStack();
  const toast = document.createElement("div");
  const icon =
    type === "error" ? "circle-alert" :
    type === "info" ? "info" :
    "circle-check-big";

  toast.className = `toast toast--${type}`;
  toast.innerHTML = `
    <span class="toast-icon"><i data-lucide="${icon}"></i></span>
    <div class="toast-content">
      <strong>${title || (type === "error" ? "Action failed" : "Success")}</strong>
      <p>${message}</p>
    </div>
  `;

  stack.appendChild(toast);

  if (window.lucide && typeof window.lucide.createIcons === "function") {
    window.lucide.createIcons();
  }

  requestAnimationFrame(() => {
    toast.classList.add("is-visible");
  });

  window.setTimeout(() => {
    toast.classList.remove("is-visible");
    window.setTimeout(() => toast.remove(), 180);
  }, 2800);
};

const flashToast = sessionStorage.getItem("blueextra-toast");
if (flashToast) {
  try {
    const parsed = JSON.parse(flashToast);
    window.showToast(parsed.message, parsed.type, parsed.title);
  } catch {
    // Ignore malformed flash payloads.
  }
  sessionStorage.removeItem("blueextra-toast");
}

function setSidebarState(isOpen) {
  sidebar?.classList.toggle("is-open", isOpen);
  sidebarOverlay?.classList.toggle("hidden", !isOpen);
  document.body.classList.toggle("overflow-hidden", isOpen);
}

openSidebar?.addEventListener("click", () => setSidebarState(true));
closeSidebar?.addEventListener("click", () => setSidebarState(false));
sidebarOverlay?.addEventListener("click", () => setSidebarState(false));

if (window.lucide && typeof window.lucide.createIcons === "function") {
  window.lucide.createIcons();
}

const userMenuButtons = document.querySelectorAll("[data-user-menu-button]");

userMenuButtons.forEach((button) => {
  button.addEventListener("click", () => {
    const menu = button.closest(".user-menu");
    const isOpen = menu?.classList.contains("is-open");

    document.querySelectorAll(".user-menu").forEach((item) => item.classList.remove("is-open"));
    menu?.classList.toggle("is-open", !isOpen);
  });
});

document.addEventListener("click", (event) => {
  if (event.target.closest(".user-menu")) {
    return;
  }

  document.querySelectorAll(".user-menu").forEach((item) => item.classList.remove("is-open"));
});

navLinks.forEach((link) => {
  link.addEventListener("click", () => {
    navLinks.forEach((item) => item.classList.remove("is-active"));
    link.classList.add("is-active");

    if (sectionTitle) {
      sectionTitle.textContent = link.textContent.trim();
    }

    if (sectionDescription) {
      sectionDescription.textContent =
        link.dataset.description || "We can add a dedicated layout for this section next.";
    }

    if (window.innerWidth < 1024) {
      setSidebarState(false);
    }
  });
});

document.querySelectorAll("[data-flash-toast-form]").forEach((form) => {
  form.addEventListener("submit", () => {
    const message = form.dataset.toastMessage || "Action completed successfully.";
    const title = form.dataset.toastTitle || "Success";

    sessionStorage.setItem(
      "blueextra-toast",
      JSON.stringify({ message, type: "success", title })
    );
  });
});

// PWA install prompt + update banner
let deferredInstallPrompt = null;
const installButtons = document.querySelectorAll("[data-install-app]");

function setInstallButtonsVisible(visible) {
  installButtons.forEach((button) => {
    button.style.display = visible ? "flex" : "none";
  });
}

function ensureBanner(id, html) {
  let banner = document.getElementById(id);
  if (!banner) {
    banner = document.createElement("div");
    banner.id = id;
    banner.className = "pwa-banner";
    banner.innerHTML = html;
    document.body.appendChild(banner);
  }
  return banner;
}

function setupInstallBanner() {
  const banner = ensureBanner(
    "pwaInstallBanner",
    `
      <div class="pwa-banner-card">
        <div>
          <p class="pwa-banner-title">Install Blue Extra Lotto</p>
          <p class="pwa-banner-sub">Get faster access and work from your home screen.</p>
        </div>
        <div class="pwa-banner-actions">
          <button class="action-button action-button-soft" type="button" data-install-now>Install</button>
          <button class="action-button" type="button" data-install-dismiss>Not now</button>
        </div>
      </div>
    `
  );

  banner.querySelector("[data-install-dismiss]")?.addEventListener("click", () => {
    banner.classList.remove("is-visible");
  });

  banner.querySelector("[data-install-now]")?.addEventListener("click", async () => {
    if (!deferredInstallPrompt) {
      window.showToast?.("Install prompt not available yet. Please try again.", "info", "Install app");
      return;
    }
    deferredInstallPrompt.prompt();
    const choice = await deferredInstallPrompt.userChoice;
    if (choice?.outcome === "accepted") {
      window.showToast?.("App installation started.", "success", "Install app");
    }
    deferredInstallPrompt = null;
    banner.classList.remove("is-visible");
    setInstallButtonsVisible(false);
  });

  return banner;
}

function setupUpdateBanner() {
  const banner = ensureBanner(
    "pwaUpdateBanner",
    `
      <div class="pwa-banner-card">
        <div>
          <p class="pwa-banner-title">Update available</p>
          <p class="pwa-banner-sub">Refresh to get the latest features.</p>
        </div>
        <div class="pwa-banner-actions">
          <button class="action-button" type="button" data-update-reload>Refresh now</button>
        </div>
      </div>
    `
  );

  banner.querySelector("[data-update-reload]")?.addEventListener("click", () => {
    window.location.reload();
  });

  return banner;
}

const isStandalone = window.matchMedia && window.matchMedia("(display-mode: standalone)").matches;
setInstallButtonsVisible(!isStandalone);

window.addEventListener("beforeinstallprompt", (event) => {
  event.preventDefault();
  deferredInstallPrompt = event;
  setInstallButtonsVisible(true);
  if (!isStandalone) {
    const banner = setupInstallBanner();
    banner.classList.add("is-visible");
  }
});

window.addEventListener("appinstalled", () => {
  setInstallButtonsVisible(false);
  const banner = document.getElementById("pwaInstallBanner");
  banner?.classList.remove("is-visible");
});

installButtons.forEach((button) => {
  button.addEventListener("click", async () => {
    if (!deferredInstallPrompt) {
      window.showToast?.("Install prompt not available yet. Please try again.", "info", "Install app");
      return;
    }
    deferredInstallPrompt.prompt();
    const choice = await deferredInstallPrompt.userChoice;
    if (choice?.outcome === "accepted") {
      window.showToast?.("App installation started.", "success", "Install app");
    }
    deferredInstallPrompt = null;
    setInstallButtonsVisible(false);
  });
});

if ("serviceWorker" in navigator) {
  navigator.serviceWorker.getRegistration().then((registration) => {
    if (!registration) {
      return;
    }
    registration.update().catch(() => {});
    registration.addEventListener("updatefound", () => {
      const newWorker = registration.installing;
      if (!newWorker) {
        return;
      }
      newWorker.addEventListener("statechange", () => {
        if (newWorker.state === "installed" && navigator.serviceWorker.controller) {
          const banner = setupUpdateBanner();
          banner.classList.add("is-visible");
        }
      });
    });
  });
}
