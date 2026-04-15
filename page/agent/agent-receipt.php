<?php include_once('includes/head.php'); ?>

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
    #receiptPageBody,
    #receiptPageBody * {
      visibility: visible !important;
    }
    #receiptPageBody {
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

<body class="min-h-screen bg-shell font-body text-ink" data-page="agent-receipt">
  <div class="dashboard-shell relative min-h-screen overflow-hidden">
    <div class="pointer-events-none absolute inset-0 opacity-90">
      <div class="hero-glow hero-glow-a"></div>
      <div class="hero-glow hero-glow-b"></div>
      <div class="grid-fade"></div>
    </div>

    <main class="relative z-10 px-4 py-6 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-5xl">
        <header
          class="no-print rounded-[2rem] border border-white/10 bg-white/5 px-5 py-5 shadow-panel backdrop-blur-xl sm:px-6">
          <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
              <p class="text-sm uppercase tracking-[0.35em] text-muted">Receipt Print</p>
              <h1 class="mt-2 font-display text-3xl font-bold sm:text-4xl">Transaction Receipt</h1>
              <p class="mt-3 max-w-2xl text-sm leading-6 text-muted sm:text-base">
                Review the transaction receipt and print it for the customer.
              </p>
            </div>
            <div class="flex flex-wrap gap-3">
              <a href="./agent-play.html" class="action-button action-button-soft">
                <i data-lucide="arrow-left"></i>
                <span>Back To Play Page</span>
              </a>
              <button id="printReceiptAction" class="action-button" type="button">
                <i data-lucide="printer"></i>
                <span>Print Receipt</span>
              </button>
            </div>
          </div>
        </header>

        <section class="mt-6">
          <div id="receiptPageBody"></div>
        </section>
      </div>
    </main>
  </div>

  <?php include_once('includes/scripts.php'); ?>
</body>

</html>
