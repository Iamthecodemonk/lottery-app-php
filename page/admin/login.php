<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Meta And Assets -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login | Blue Extra Lotto</title>
    <meta
      name="description"
      content="Blue Extra Lotto admin login page for platform control and operations."
    />
    <link rel="icon" type="image/png" href="/lt/public/assets/img/logo_1.png" />
    <link rel="apple-touch-icon" href="/lt/public/assets/img/logo_1.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=Manrope:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              shell: "#07111f",
              panel: "#0d1a2b",
              stroke: "#20344f",
              accent: "#2596be",
              accentSoft: "#7fc8e0",
              accentBright: "#bdeeff",
              accentDeep: "#176f8e",
              ink: "#f4f7fb",
              muted: "#8da3bd",
            },
            fontFamily: {
              display: ["Space Grotesk", "sans-serif"],
              body: ["Manrope", "sans-serif"],
            },
            boxShadow: {
              panel: "0 24px 80px rgba(2, 8, 23, 0.35)",
            },
          },
        },
      };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="/lt/public/assets/css/styles.css" />
  </head>
  <body class="min-h-screen bg-shell font-body text-ink">
    <div class="auth-shell relative min-h-screen overflow-hidden">
      <!-- Background Effects -->
      <div class="pointer-events-none absolute inset-0 opacity-90">
        <div class="hero-glow hero-glow-a"></div>
        <div class="hero-glow hero-glow-b"></div>
        <div class="grid-fade"></div>
      </div>

      <div class="relative z-10 mx-auto flex min-h-screen max-w-7xl items-center px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid w-full gap-8 lg:grid-cols-[1.05fr_0.95fr]">
          <!-- Brand Intro Panel -->
          <section class="flex flex-col justify-between rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-panel backdrop-blur-xl sm:p-8 lg:min-h-[720px]">
            <div>
              <!-- Brand Block -->
              <div class="inline-flex items-center gap-4 rounded-2xl border border-white/10 bg-panel/60 px-4 py-3">
                <img
                  src="/lt/public/assets/img/logo_1.png"
                  alt="Blue Extra Lotto"
                  class="h-14 w-auto object-contain"
                />
                <div>
                  <p class="font-display text-xs uppercase tracking-[0.35em] text-accent">
                    Blue Extra
                  </p>
                  <p class="mt-1 text-sm text-muted">Admin control access</p>
                </div>
              </div>

              <!-- Hero Copy -->
              <div class="mt-10 max-w-xl">
                <p class="text-sm uppercase tracking-[0.35em] text-accentSoft">
                  Secure operator sign in
                </p>
                <h1 class="mt-4 font-display text-4xl font-bold leading-tight sm:text-5xl">
                  Manage lotto draws, agents, results, and platform operations from one control room.
                </h1>
                <p class="mt-5 text-base leading-7 text-muted">
                  A focused entry point for the Blue Extra Lotto admin team. Built for agent
                  oversight, draw control, approvals, reporting, and platform operations.
                </p>
              </div>

              <!-- Quick Stats -->
              <div class="mt-10 grid gap-4 sm:grid-cols-3">
                <article class="auth-stat">
                  <p class="auth-stat-label">Agents</p>
                  <p class="auth-stat-value">24/7</p>
                </article>
                <article class="auth-stat">
                  <p class="auth-stat-label">Draws</p>
                  <p class="auth-stat-value">Live</p>
                </article>
                <article class="auth-stat">
                  <p class="auth-stat-label">Reports</p>
                  <p class="auth-stat-value">Daily</p>
                </article>
              </div>
            </div>

            <!-- Access Note -->
            <div class="mt-10 rounded-[1.75rem] border border-accent/20 bg-accent/10 p-5">
              <p class="text-sm uppercase tracking-[0.3em] text-accentSoft">Access note</p>
              <p class="mt-3 max-w-2xl text-sm leading-7 text-ink/80">
                This admin login is UI only for now. When you are ready, we can connect it to
                real authentication, role checks, session rules, and the separate admin dashboard.
              </p>
            </div>
          </section>

          <!-- Login Form Panel -->
          <section class="flex items-center">
            <div class="auth-card w-full rounded-[2rem] border border-white/10 bg-panel/90 p-6 shadow-panel backdrop-blur-xl sm:p-8">
              <!-- Form Heading -->
              <div class="max-w-md">
                <p class="text-sm uppercase tracking-[0.35em] text-muted">Welcome back</p>
                <h2 class="mt-3 font-display text-3xl font-bold">Sign in to continue</h2>
                <p class="mt-3 text-sm leading-6 text-muted">
                  Enter your admin credentials to access the Blue Extra Lotto control dashboard.
                </p>
              </div>

              <!-- Login Form -->
              <form id="admin-login-form" class="mt-8 space-y-5" action="#" method="post" novalidate>
                <div>
                  <label class="auth-label" for="email">Admin email</label>
                  <input
                    id="email"
                    name="email"
                    type="email"
                    placeholder="admin@blueextra.com"
                    class="auth-input"
                  />
                </div>

                <div>
                  <!--<div class="flex items-center justify-between gap-4">-->
                  <!--  <label class="auth-label" for="password">Password</label>-->
                  <!--  <a href="#" class="text-sm font-medium text-accentSoft transition hover:text-accentBright">-->
                  <!--    Forgot password?-->
                  <!--  </a>-->
                  <!--</div>-->
                  <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Enter your password"
                    class="auth-input"
                  />
                </div>
                <p id="login-error" class="hidden text-sm text-red-300"></p>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                  <label class="inline-flex items-center gap-3 text-sm text-muted">
                    <input
                      type="checkbox"
                      class="h-4 w-4 rounded border-white/20 bg-transparent text-accent focus:ring-accent"
                    />
                    Keep me signed in
                  </label>
                  <!--<a href="/lt/public/index.html" class="text-sm font-medium text-accentSoft transition hover:text-accentBright">-->
                  <!--  Back to portal selection-->
                  <!--</a>-->
                </div>

                <button type="submit" class="auth-button">Sign In As Admin</button>
              </form>

              <!-- Login Footer Cards -->
              <div class="mt-8 border-t border-white/10 pt-6">
                <div class="grid gap-3 sm:grid-cols-2">
                  <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="text-xs uppercase tracking-[0.3em] text-muted">Scope</p>
                    <p class="mt-2 text-sm font-semibold text-ink">Platform operations</p>
                  </div>
                  <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="text-xs uppercase tracking-[0.3em] text-muted">Security</p>
                    <p class="mt-2 text-sm font-semibold text-ink">Token Auth</p>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
    <script src="/lt/public/assets/js/app.js"></script>
    <script>
      (function () {
        const form = document.getElementById("admin-login-form");
        const errorEl = document.getElementById("login-error");
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("password");

        const basePath = "/lt/";
        const loginUrl = `${basePath}api/admin/login`;
        const dashboardUrl = `${basePath}admin`;

        function showError(message) {
          errorEl.textContent = message;
          errorEl.classList.remove("hidden");
        }

        function clearError() {
          errorEl.textContent = "";
          errorEl.classList.add("hidden");
        }

        form.addEventListener("submit", async function (event) {
          event.preventDefault();
          clearError();

          const email = emailInput.value.trim();
          const password = passwordInput.value.trim();

          if (!email || !password) {
            showError("Please enter your email and password.");
            return;
          }

          try {
            const response = await axios.post(loginUrl, {
              email,
              password,
            });

            if (response.data && response.data.state) {
              if (response.data.token) {
                localStorage.setItem("admin_token", response.data.token);
              }
              window.location.href = dashboardUrl;
              return;
            }

            showError(response.data?.message || "Login failed.");
          } catch (error) {
            const message =
              error.response?.data?.message ||
              error.message ||
              "Login failed. Please try again.";
            showError(message);
          }
        });
      })();
    </script>
  </body>
</html>
