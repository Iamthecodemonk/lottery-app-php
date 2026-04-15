<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blue Extra Lotto | Choose Portal</title>
  <meta name="description" content="Choose an admin or agent portal to sign in to Blue Extra Lotto." />
  <meta name="theme-color" content="#000000" />
  <link rel="icon" type="image/png" href="/lt/public/assets/img/logo_1.png" />
  <link rel="apple-touch-icon" href="/lt/public/assets/img/logo_1.png" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap"
    rel="stylesheet"
  />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            shell: "#000000",
            panel: "#0b0b0b",
            accent: "#feb12c",
            accentSoft: "#ffd27a",
            accentBright: "#ffe3ad",
            accentDeep: "#c98000",
            ink: "#f4f7fb",
            muted: "#8da3bd"
          },
          fontFamily: {
            display: ["Montserrat", "sans-serif"],
            body: ["Montserrat", "sans-serif"]
          },
          boxShadow: {
            panel: "0 24px 80px rgba(2, 8, 23, 0.35)"
          }
        }
      }
    };
  </script>
  <link rel="stylesheet" href="/lt/public/assets/css/styles.css" />
</head>

<body class="min-h-screen bg-shell font-body text-ink">
  <div class="auth-shell relative min-h-screen overflow-hidden">
    <div class="pointer-events-none absolute inset-0 opacity-90">
      <div class="hero-glow hero-glow-a"></div>
      <div class="hero-glow hero-glow-b"></div>
      <div class="grid-fade"></div>
    </div>

    <div class="relative z-10 mx-auto flex min-h-screen max-w-6xl items-center px-4 py-12 sm:px-6 lg:px-8">
      <div class="w-full">
        <div class="text-center">
          <div class="inline-flex items-center gap-3 rounded-2xl border border-white/10 bg-panel/60 px-4 py-3">
            <img src="/lt/public/assets/img/logo_1.png" alt="Blue Extra Lotto" class="h-12 w-12 rounded-full" />
            <div class="text-left">
              <p class="font-display text-xs uppercase tracking-[0.35em] text-accent">Blue Extra Lotto</p>
              <p class="mt-1 text-sm text-muted">Choose your workspace</p>
            </div>
          </div>
          <h1 class="mt-8 font-display text-4xl font-bold sm:text-5xl">Welcome back</h1>
          <p class="mt-4 text-sm leading-6 text-muted sm:text-base">
            Select the portal you want to access. Admins manage the platform, agents run daily ticket sales.
          </p>
        </div>

        <div class="mt-10 grid gap-6 lg:grid-cols-2">
          <a href="/lt/admin/login" class="rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-panel backdrop-blur-xl transition hover:-translate-y-1">
            <p class="text-xs uppercase tracking-[0.35em] text-accentSoft">Admin portal</p>
            <h2 class="mt-4 font-display text-2xl font-bold">Sign in as Admin</h2>
            <p class="mt-3 text-sm text-muted">
              Manage agents, publish results, and control wallet balances.
            </p>
            <div class="mt-6">
              <span class="action-button action-button-soft">Continue to admin login</span>
            </div>
          </a>

          <a href="/lt/agent/login" class="rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-panel backdrop-blur-xl transition hover:-translate-y-1">
            <p class="text-xs uppercase tracking-[0.35em] text-accentSoft">Agent portal</p>
            <h2 class="mt-4 font-display text-2xl font-bold">Sign in as Agent</h2>
            <p class="mt-3 text-sm text-muted">
              Sell tickets, view results, and manage customer games.
            </p>
            <div class="mt-6">
              <span class="action-button action-button-soft">Continue to agent login</span>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
