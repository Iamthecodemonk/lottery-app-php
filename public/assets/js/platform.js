const LOG_RETENTION_MS = 7 * 24 * 60 * 60 * 1000;
const API_BASE_PATH = "/lt/";

function notify(message, type = "success", title) {
  if (typeof window.showToast === "function") {
    window.showToast(message, type, title);
  }
}

function createId(prefix) {
  return `${prefix}-${Date.now()}-${Math.random().toString(16).slice(2, 8)}`;
}

function createSeedState() {
  const now = Date.now();

  return {
    games: [
      { id: "game-evening", name: "Today's Game Result", drawTime: "6:00 PM", status: "active", createdAt: now - 86400000 * 4 }
    ],
    agents: [
      {
        id: "agent-014",
        name: "Samuel Ade",
        agentCode: "AG014",
        outlet: "Surulere Outlet",
        phone: "0803 000 0140",
        region: "Lagos",
        status: "active",
        balance: 245000,
        username: "AG014",
        password: "BXL-0140",
        createdAt: now - 86400000 * 10
      },
      {
        id: "agent-009",
        name: "Amina Yusuf",
        agentCode: "AG009",
        outlet: "Ikeja Outlet",
        phone: "0803 000 0090",
        region: "Lagos",
        status: "active",
        balance: 320500,
        username: "AG009",
        password: "BXL-0090",
        createdAt: now - 86400000 * 8
      },
      {
        id: "agent-021",
        name: "Tunde Bello",
        agentCode: "AG021",
        outlet: "Ibadan Central",
        phone: "0803 000 0210",
        region: "Oyo",
        status: "review",
        balance: 112000,
        username: "AG021",
        password: "BXL-0210",
        createdAt: now - 86400000 * 6
      }
    ],
    results: [
      {
        id: "result-3",
        gameId: "game-evening",
        gameName: "Today's Game Result",
        winningNumbers: ["04", "11", "18", "33", "42"],
        machineNumbers: ["06", "14", "27", "35", "49"],
        publishedAt: now - 1000 * 60 * 45
      }
    ],
    agentSales: [
      {
        id: "sale-1",
        agentName: "Shop Agent 014",
        outlet: "Surulere Outlet",
        gameName: "Today's Game Result",
        tickets: 42,
        salesAmount: 428500,
        remittanceAmount: 395000,
        soldAt: now - 1000 * 60 * 90
      },
      {
        id: "sale-2",
        agentName: "Shop Agent 009",
        outlet: "Ikeja Outlet",
        gameName: "Today's Game Result",
        tickets: 56,
        salesAmount: 612000,
        remittanceAmount: 580000,
        soldAt: now - 1000 * 60 * 180
      },
      {
        id: "sale-3",
        agentName: "Shop Agent 021",
        outlet: "Ibadan Central",
        gameName: "Today's Game Result",
        tickets: 28,
        salesAmount: 290000,
        remittanceAmount: 210000,
        soldAt: now - 1000 * 60 * 60 * 16
      }
    ],
    agentGameHistory: [
      {
        id: "play-1",
        agentName: "Samuel Ade",
        agentCode: "AG014",
        outlet: "Surulere Outlet",
        ticketCode: "TK-24031",
        totalGames: 1,
        totalStakeAmount: 5000,
        earnedAmount: 650,
        status: "printed",
        playedAt: now - 1000 * 60 * 28,
        items: [
          {
            gameName: "Today's Game Result",
            betType: "Direct",
            selections: ["04", "11", "18", "33", "42", "47", "52", "55", "61", "64", "68", "71", "74", "76", "80", "82", "84", "86", "88", "90"],
            stakeAmount: 250,
            unitPerPerm: 20,
            amountPlayed: 5000
          }
        ]
      },
      {
        id: "play-2",
        agentName: "Amina Yusuf",
        agentCode: "AG009",
        outlet: "Ikeja Outlet",
        ticketCode: "TK-24030",
        totalGames: 2,
        totalStakeAmount: 7000,
        earnedAmount: 910,
        status: "printed",
        playedAt: now - 1000 * 60 * 74,
        items: [
          {
            gameName: "Today's Game Result",
            betType: "Perm 2",
            selections: ["06", "09", "15", "27", "44", "46", "48", "51", "53", "56", "59", "62", "66", "69", "72", "75", "79", "83", "87", "89"],
            stakeAmount: 175,
            unitPerPerm: 20,
            amountPlayed: 3500
          },
          {
            gameName: "Today's Game Result",
            betType: "Banker",
            selections: ["01", "03", "08", "14", "21", "24", "28", "30", "33", "36", "40", "43", "49", "54", "57", "60", "67", "70", "78", "85"],
            stakeAmount: 175,
            unitPerPerm: 20,
            amountPlayed: 3500
          }
        ]
      },
      {
        id: "play-3",
        agentName: "Tunde Bello",
        agentCode: "AG021",
        outlet: "Ibadan Central",
        ticketCode: "TK-24029",
        totalGames: 1,
        totalStakeAmount: 10000,
        earnedAmount: 1300,
        status: "confirmed",
        playedAt: now - 1000 * 60 * 145,
        items: [
          {
            gameName: "Today's Game Result",
            betType: "Perm 3",
            selections: ["01", "08", "21", "36", "48", "50", "58", "63", "65", "73", "77", "81", "02", "05", "07", "11", "17", "23", "31", "39"],
            stakeAmount: 500,
            unitPerPerm: 20,
            amountPlayed: 10000
          }
        ]
      },
      {
        id: "play-4",
        agentName: "Samuel Ade",
        agentCode: "AG014",
        outlet: "Surulere Outlet",
        ticketCode: "TK-24028",
        totalGames: 1,
        totalStakeAmount: 1500,
        earnedAmount: 195,
        status: "printed",
        playedAt: now - 1000 * 60 * 60 * 7,
        items: [
          {
            gameName: "Today's Game Result",
            betType: "Direct",
            selections: ["03", "10", "19", "31", "45", "47", "52", "55", "58", "61", "63", "66", "68", "70", "73", "76", "79", "82", "85", "88"],
            stakeAmount: 75,
            unitPerPerm: 20,
            amountPlayed: 1500
          }
        ]
      }
    ],
    cashbackHistory: [
      {
        id: "cashback-1",
        agentName: "Samuel Ade",
        agentCode: "AG014",
        outlet: "Surulere Outlet",
        ticketCode: "CB-24031",
        cashBackId: "CBX-1021",
        gameName: "Today's Game Result",
        cashBackType: "Direct",
        stakeAmount: 5000,
        selections: ["04", "11", "18", "33", "42", "47", "52", "55", "61", "64", "68", "71", "74", "76", "80", "82", "84", "86", "88", "90"],
        status: "printed",
        playedAt: now - 1000 * 60 * 36
      }
    ],
    logs: [
      {
        id: "log-1",
        type: "publish-result",
        message: "Today's Game Result published.",
        createdAt: now - 1000 * 60 * 45
      },
      {
        id: "log-2",
        type: "add-game",
        message: "Today's Game Result available.",
        createdAt: now - 1000 * 60 * 60 * 30
      }
    ]
  };
}

let platformState = createSeedState();

function cleanupLogs(state) {
  const threshold = Date.now() - LOG_RETENTION_MS;
  state.logs = (state.logs || []).filter((log) => log.createdAt >= threshold);
  return state;
}

function getState() {
  platformState = cleanupLogs(platformState);
  return platformState;
}

function commitState(mutator) {
  const state = getState();
  const nextState = cleanupLogs(mutator(state) || state);
  platformState = nextState;
  return nextState;
}

function addLog(state, type, message) {
  state.logs.unshift({
    id: createId("log"),
    type,
    message,
    createdAt: Date.now()
  });
}

function formatCurrency(value) {
  return `N ${Number(value).toLocaleString()}`;
}

function formatDate(value) {
  return new Date(value).toLocaleString("en-NG", {
    day: "numeric",
    month: "short",
    year: "numeric",
    hour: "numeric",
    minute: "2-digit"
  });
}

function parseDbDate(value) {
  if (!value) {
    return null;
  }
  if (value instanceof Date) {
    return value;
  }
  if (typeof value === "string") {
    const normalized = value.includes("T") ? value : value.replace(" ", "T");
    const date = new Date(normalized);
    if (!Number.isNaN(date.getTime())) {
      return date;
    }
  }
  const date = new Date(value);
  return Number.isNaN(date.getTime()) ? null : date;
}

function formatDateOnly(value) {
  return new Date(value).toLocaleDateString("en-NG", {
    day: "numeric",
    month: "numeric",
    year: "numeric"
  });
}

function formatTimeOnly(value) {
  return new Date(value).toLocaleTimeString("en-NG", {
    hour: "2-digit",
    minute: "2-digit",
    hour12: true
  });
}

function formatPlayNumber(value) {
  return String(value).padStart(2, "0");
}

function getInitials(name) {
  return String(name || "")
    .trim()
    .split(/\s+/)
    .slice(0, 2)
    .map((part) => part.charAt(0).toUpperCase())
    .join("");
}

function getStatusTone(value) {
  const normalized = String(value || "").toLowerCase();

  if (["active", "healthy", "confirmed", "printed", "published"].includes(normalized)) {
    return "status-pill--positive";
  }

  if (["suspended", "pending", "review"].includes(normalized)) {
    return "status-pill--warning";
  }

  if (["warning", "failed", "error"].includes(normalized)) {
    return "status-pill--danger";
  }

  return "";
}

function getSortedResults(state) {
  return [...(state.results || [])].sort((a, b) => b.publishedAt - a.publishedAt);
}

function getSortedSales(state) {
  return [...(state.agentSales || [])].sort((a, b) => b.soldAt - a.soldAt);
}

function getSortedAgents(state) {
  return [...(state.agents || [])].sort((a, b) => b.createdAt - a.createdAt);
}

function getSortedAgentGameHistory(state) {
  return [...(state.agentGameHistory || [])].sort((a, b) => b.playedAt - a.playedAt);
}

function getSortedCashbackHistory(state) {
  return [...(state.cashbackHistory || [])].sort((a, b) => b.playedAt - a.playedAt);
}

function publishResult(payload) {
  return commitState((state) => {
    const game = state.games.find((item) => item.id === payload.gameId);

    if (!game) {
      return state;
    }

    state.results.unshift({
      id: createId("result"),
      gameId: game.id,
      gameName: game.name,
      winningNumbers: payload.winningNumbers,
      machineNumbers: payload.machineNumbers,
      publishedAt: Date.now()
    });

    addLog(state, "publish-result", `${game.name} result published.`);
    return state;
  });
}

function addGame(payload) {
  return commitState((state) => {
    state.games.unshift({
      id: createId("game"),
      name: payload.name,
      drawTime: payload.drawTime,
      status: "active",
      createdAt: Date.now()
    });

    addLog(state, "add-game", `${payload.name} game added.`);
    return state;
  });
}

function deleteGame(gameId) {
  return commitState((state) => {
    const game = state.games.find((item) => item.id === gameId);
    state.games = state.games.filter((item) => item.id !== gameId);
    state.results = state.results.filter((item) => item.gameId !== gameId);

    if (game) {
      addLog(state, "delete-game", `${game.name} game deleted.`);
    }

    return state;
  });
}

function createAgent(payload) {
  return commitState((state) => {
    const createdAt = Date.now();
    const agentCode = payload.agentCode.toUpperCase();

    state.agents.unshift({
      id: createId("agent"),
      name: payload.name,
      agentCode,
      outlet: payload.outlet,
      phone: payload.phone,
      region: payload.region,
      status: "active",
      balance: Number(payload.balance || 0),
      username: agentCode,
      password: payload.password,
      createdAt
    });

    addLog(state, "create-agent", `${payload.name} agent account created.`);
    return state;
  });
}

function updateAgent(agentId, payload) {
  return commitState((state) => {
    const agent = state.agents.find((item) => item.id === agentId);

    if (!agent) {
      return state;
    }

    agent.name = payload.name;
    agent.agentCode = payload.agentCode.toUpperCase();
    agent.outlet = payload.outlet;
    agent.phone = payload.phone;
    agent.region = payload.region;
    agent.password = payload.password;
    agent.username = agent.agentCode;
    agent.balance = Number(payload.balance || 0);

    addLog(state, "edit-agent", `${agent.name} profile updated.`);
    return state;
  });
}

function toggleAgentStatus(agentId) {
  return commitState((state) => {
    const agent = state.agents.find((item) => item.id === agentId);

    if (!agent) {
      return state;
    }

    agent.status = agent.status === "active" ? "suspended" : "active";
    addLog(state, "agent-status", `${agent.name} marked as ${agent.status}.`);
    return state;
  });
}

function creditAgent(agentId, amount = 50000) {
  return commitState((state) => {
    const agent = state.agents.find((item) => item.id === agentId);

    if (!agent) {
      return state;
    }

    agent.balance = Number(agent.balance || 0) + amount;
    addLog(state, "credit-agent", `${agent.name} credited with ${formatCurrency(amount)}.`);
    return state;
  });
}

function addAgentGameEntries(entries, options = {}) {
  return commitState((state) => {
    const playedAt = options.playedAt || Date.now();
    const transaction = {
      id: createId("play"),
      agentName: options.agentName || "Samuel Ade",
      agentCode: options.agentCode || "AG014",
      outlet: options.outlet || "Surulere Outlet",
      ticketCode: options.ticketCode || `TK-${Math.floor(10000 + Math.random() * 89999)}`,
      totalGames: entries.length,
      totalStakeAmount: entries.reduce((sum, item) => sum + Number(item.amountPlayed || 0), 0),
      earnedAmount: entries.reduce((sum, item) => sum + Number(item.earnedAmount || 0), 0),
      status: "printed",
      playedAt,
      items: entries.map((entry) => ({
        gameName: entry.gameName,
        betType: entry.betType,
        selections: entry.selections,
        stakeAmount: entry.stakeAmount,
        unitPerPerm: entry.unitPerPerm,
        amountPlayed: entry.amountPlayed
      }))
    };

    state.agentGameHistory.unshift(transaction);

    addLog(state, "print-game", `${entries.length} game${entries.length > 1 ? "s" : ""} sent for printing under ${transaction.ticketCode}.`);
    return state;
  });
}

function addCashbackEntry(entry, options = {}) {
  return commitState((state) => {
    const playedAt = options.playedAt || Date.now();
    const transaction = {
      id: createId("cashback"),
      agentName: options.agentName || "Samuel Ade",
      agentCode: options.agentCode || "AG014",
      outlet: options.outlet || "Surulere Outlet",
      ticketCode: options.ticketCode || `CB-${Math.floor(10000 + Math.random() * 89999)}`,
      cashBackId: entry.cashBackId,
      gameName: entry.gameName,
      cashBackType: entry.cashBackType,
      stakeAmount: entry.stakeAmount,
      selections: entry.selections,
      status: "printed",
      playedAt
    };

    state.cashbackHistory.unshift(transaction);
    addLog(state, "cashback-print", `Cash back ticket ${transaction.ticketCode} submitted.`);
    return state;
  });
}

function renderLatestResults(container, results) {
  if (!container) {
    return;
  }

  if (!results.length) {
    container.innerHTML = `
      <div class="empty-state empty-state--compact">
        <i data-lucide="trophy"></i>
        <p class="text-lg font-semibold text-ink">No recent published game</p>
        <p class="mt-3 text-sm leading-6 text-muted">
          Published results will appear here once a game result is submitted.
        </p>
      </div>
    `;
    if (window.lucide && typeof window.lucide.createIcons === "function") {
      window.lucide.createIcons();
    }
    return;
  }

  container.innerHTML = results
    .slice(0, 1)
    .map(
      (result) => `
        <article class="result-card result-card--featured">
          <div class="flex items-start justify-between gap-4">
            <div>
              <p class="text-sm uppercase tracking-[0.28em] text-accentSoft">${result.gameName}</p>
              <p class="mt-2 text-sm text-muted">${formatDate(result.publishedAt)}</p>
            </div>
            <span class="status-pill ${getStatusTone("published")}">Published</span>
          </div>
          <div class="result-split mt-6">
            <div>
              <p class="result-label">Winning Numbers</p>
              <div class="number-row mt-3">
                ${result.winningNumbers.map((item) => `<span class="number-ball">${item}</span>`).join("")}
              </div>
            </div>
            <div>
              <p class="result-label">Machine Numbers</p>
              <div class="number-row mt-3">
                ${result.machineNumbers.map((item) => `<span class="number-ball number-ball-soft">${item}</span>`).join("")}
              </div>
            </div>
          </div>
        </article>
      `
    )
    .join("");
}

function renderLatestResultSneakPeek(container, results) {
  if (!container) {
    return;
  }

  if (!results.length) {
    container.innerHTML = `
      <div class="empty-state empty-state--compact">
        <i data-lucide="trophy"></i>
        <p class="text-base font-semibold text-ink">No published result yet</p>
        <p class="mt-2 text-sm leading-6 text-muted">
          The latest result will appear here once the admin publishes it.
        </p>
      </div>
    `;
    if (window.lucide && typeof window.lucide.createIcons === "function") {
      window.lucide.createIcons();
    }
    return;
  }

  const result = results[0];
  container.innerHTML = `
    <article class="rounded-[1.5rem] border border-white/10 bg-white/5 p-4">
      <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div>
          <p class="text-sm font-semibold text-ink">${result.gameName}</p>
          <p class="mt-1 text-xs text-muted">${formatDate(result.publishedAt)}</p>
        </div>
        <span class="status-pill ${getStatusTone("published")}">Published</span>
      </div>
      <div class="mt-4">
        <p class="result-label">Winning Numbers</p>
        <div class="number-chip-row mt-3">
          ${result.winningNumbers.slice(0, 5).map((item) => `<span class="number-chip">${item}</span>`).join("")}
        </div>
      </div>
    </article>
  `;
}

function renderResultsHistory(container, results) {
  if (!container) {
    return;
  }

  if (!results.length) {
    container.innerHTML = `
      <div class="empty-state empty-state--compact">
        <i data-lucide="history"></i>
        <p class="text-lg font-semibold text-ink">No result history yet</p>
        <p class="mt-3 text-sm leading-6 text-muted">
          Published result records will appear here once results are submitted.
        </p>
      </div>
    `;
    if (window.lucide && typeof window.lucide.createIcons === "function") {
      window.lucide.createIcons();
    }
    return;
  }

  container.innerHTML = `
    <div class="table-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th>Game</th>
            <th>Winning Numbers</th>
            <th>Machine Numbers</th>
            <th>Published</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          ${results
            .map(
              (result) => `
                <tr>
                  <td data-label="Game">${result.gameName}</td>
                  <td data-label="Winning Numbers">
                    <div class="number-chip-row">
                      ${result.winningNumbers.map((item) => `<span class="number-chip">${item}</span>`).join("")}
                    </div>
                  </td>
                  <td data-label="Machine Numbers">
                    <div class="number-chip-row">
                      ${result.machineNumbers.map((item) => `<span class="number-chip number-chip--soft">${item}</span>`).join("")}
                    </div>
                  </td>
                  <td data-label="Published">${formatDate(result.publishedAt)}</td>
                  <td data-label="Status"><span class="status-pill ${getStatusTone("published")}">Published</span></td>
                </tr>
              `
            )
            .join("")}
        </tbody>
      </table>
    </div>
  `;
}

function renderGames(container, games) {
  if (!container) {
    return;
  }

  if (!games.length) {
    container.innerHTML = `
      <div class="empty-state empty-state--compact">
        <i data-lucide="dice-5"></i>
        <p class="text-lg font-semibold text-ink">No games available</p>
        <p class="mt-3 text-sm leading-6 text-muted">
          Add a game to start managing active lotto draws.
        </p>
      </div>
    `;
    if (window.lucide && typeof window.lucide.createIcons === "function") {
      window.lucide.createIcons();
    }
    return;
  }

  container.innerHTML = games
    .map(
      (game) => {
        const name = game.name || game.game_name || "Untitled game";
        let drawTimeText = "Not set";
        if (game.drawTime) {
          drawTimeText = game.drawTime;
        } else if (game.cutoff_time) {
          const parsed = parseDbDate(game.cutoff_time);
          drawTimeText = parsed ? formatDate(parsed) : "Not set";
        }

        return `
        <div class="list-card-row">
          <div>
            <p class="text-sm font-semibold text-ink">${name}</p>
            <p class="mt-1 text-sm text-muted">Draw time: ${drawTimeText}</p>
          </div>
          <button class="action-button action-button-danger" data-delete-game="${game.id}" type="button">
            Delete
          </button>
        </div>
      `;
      }
    )
    .join("");
}

function renderGameSelect(select, games) {
  if (!select) {
    return;
  }

  if (!Array.isArray(games) || !games.length) {
    select.innerHTML = '<option value="">No games available</option>';
    return;
  }

  select.innerHTML = [
    '<option value="">Select game</option>',
    ...games.map((game) => {
      const name = game.name || game.game_name || "Game";
      let drawTimeText = "Not set";
      if (game.drawTime) {
        drawTimeText = game.drawTime;
      } else if (game.cutoff_time) {
        const parsed = parseDbDate(game.cutoff_time);
        drawTimeText = parsed ? formatDate(parsed) : "Not set";
      }
      return `<option value="${game.id}">${name} - ${drawTimeText}</option>`;
    })
  ].join("");
}

function renderLogs(container, logs) {
  if (!container) {
    return;
  }

  if (!logs.length) {
    container.innerHTML = `
      <div class="empty-state empty-state--compact">
        <i data-lucide="file-clock"></i>
        <p class="text-lg font-semibold text-ink">No logs in the last 7 days</p>
        <p class="mt-3 text-sm leading-6 text-muted">
          Activity logs will appear here when actions are performed.
        </p>
      </div>
    `;
    if (window.lucide && typeof window.lucide.createIcons === "function") {
      window.lucide.createIcons();
    }
    return;
  }

  container.innerHTML = logs
    .slice(0, 8)
    .map(
      (log) => `
        <div class="info-row">
          <div>
            <p class="text-sm font-semibold text-ink">${log.message}</p>
            <p class="mt-1 text-sm text-muted">${formatDate(log.createdAt)}</p>
          </div>
          <span class="status-pill">${log.type.replace("-", " ")}</span>
        </div>
      `
    )
    .join("");
}

function getAdminSalesSummary(state) {
  const records = getSortedSales(state);
  const uniqueAgents = new Set(records.map((sale) => `${sale.agentName}__${sale.outlet}`));
  return {
    totalRecords: records.length,
    totalTickets: records.reduce((sum, sale) => sum + Number(sale.tickets || 0), 0),
    totalSalesValue: records.reduce((sum, sale) => sum + Number(sale.salesAmount || 0), 0),
    totalAgents: uniqueAgents.size
  };
}

function getAdminSalesAgents(state) {
  const map = new Map();

  (state.agents || []).forEach((agent) => {
    const outlet = [agent.email, agent.phone].filter(Boolean).join(" • ") || "Agent";
    const key = `${agent.name || "Agent"}__${outlet}`;
    if (!map.has(key)) {
      const createdAt = parseDbDate(agent.created_at);
      map.set(key, {
        agentKey: key,
        agentName: agent.name || "Agent",
        outlet,
        totalTickets: 0,
        totalSales: 0,
        transactionCount: 0,
        lastSoldAt: createdAt ? createdAt.getTime() : 0
      });
    }
  });

  getSortedSales(state).forEach((sale) => {
    const key = `${sale.agentName}__${sale.outlet}`;
    const current = map.get(key) || {
      agentKey: key,
      agentName: sale.agentName,
      outlet: sale.outlet,
      totalTickets: 0,
      totalSales: 0,
      transactionCount: 0,
      lastSoldAt: sale.soldAt
    };

    current.totalTickets += Number(sale.tickets || 0);
    current.totalSales += Number(sale.salesAmount || 0);
    current.transactionCount += 1;
    current.lastSoldAt = Math.max(current.lastSoldAt || 0, sale.soldAt || 0);
    map.set(key, current);
  });

  return [...map.values()].sort((a, b) => b.totalSales - a.totalSales || b.lastSoldAt - a.lastSoldAt);
}

function getAdminSalesFilterMatch(record, filter) {
  if (filter === "high-value") {
    return Number(record.salesAmount || 0) >= 500000;
  }

  if (filter === "recent") {
    return Number(record.soldAt || 0) >= Date.now() - 24 * 60 * 60 * 1000;
  }

  return true;
}

function renderAdminSalesAgents(container, agents, selectedAgentKey) {
  if (!container) {
    return;
  }

  if (!agents.length) {
    container.innerHTML = `
      <div class="empty-state empty-state--compact">
        <i data-lucide="users"></i>
        <p class="text-lg font-semibold text-ink">No agents match this view</p>
        <p class="mt-3 text-sm leading-6 text-muted">
          Try adjusting the search term or activity filter to reveal agent sales records.
        </p>
      </div>
    `;
    if (window.lucide && typeof window.lucide.createIcons === "function") {
      window.lucide.createIcons();
    }
    return;
  }

  container.innerHTML = `
    <button type="button" class="sales-agent-card ${selectedAgentKey ? "" : "is-active"}" data-sales-agent="all">
      <div class="sales-agent-card-head">
        <div>
          <p class="sales-agent-name">All Agents</p>
          <p class="sales-agent-meta">Combined sales stream</p>
        </div>
        <span class="status-pill">Overview</span>
      </div>
      <div class="sales-agent-stats">
        <div>
          <p class="sales-agent-stat-label">Agents</p>
          <strong class="sales-agent-stat-value">${agents.length}</strong>
        </div>
      </div>
    </button>
    ${agents
      .map(
        (agent) => `
          <button type="button" class="sales-agent-card ${selectedAgentKey === agent.agentKey ? "is-active" : ""}" data-sales-agent="${agent.agentKey}">
            <div class="sales-agent-card-head">
              <div>
                <p class="sales-agent-name">${agent.agentName}</p>
                <p class="sales-agent-meta">${agent.outlet}</p>
              </div>
              <span class="sales-agent-date">${formatDate(agent.lastSoldAt)}</span>
            </div>
            <div class="sales-agent-stats">
              <div>
                <p class="sales-agent-stat-label">Transactions</p>
                <strong class="sales-agent-stat-value">${agent.transactionCount}</strong>
              </div>
              <div>
                <p class="sales-agent-stat-label">Tickets</p>
                <strong class="sales-agent-stat-value">${agent.totalTickets}</strong>
              </div>
              <div>
                <p class="sales-agent-stat-label">Sales</p>
                <strong class="sales-agent-stat-value">${formatCurrency(agent.totalSales)}</strong>
              </div>
            </div>
          </button>
        `
      )
      .join("")}
  `;
}

function renderAdminSalesTransactions(container, sales, options = {}) {
  if (!container) {
    return;
  }

  if (!sales.length) {
    const hasActiveFilter = Boolean(options.hasActiveFilter);
    container.innerHTML = `
      <tr>
        <td colspan="6">
          <div class="empty-state empty-state--compact py-10">
            <i data-lucide="receipt-text"></i>
            <p class="text-lg font-semibold text-ink">${hasActiveFilter ? "No matching sales found" : "No sales transactions yet"}</p>
            <p class="mt-3 text-sm leading-6 text-muted">
              ${hasActiveFilter
                ? "Try adjusting the search term, filter, or selected agent."
                : "Agent sales transactions will appear here once records are available."}
            </p>
          </div>
        </td>
      </tr>
    `;
    if (window.lucide && typeof window.lucide.createIcons === "function") {
      window.lucide.createIcons();
    }
    return;
  }

  container.innerHTML = sales
    .map(
      (sale) => `
        <tr>
          <td data-label="Agent">${sale.agentName}</td>
          <td data-label="Outlet">${sale.outlet}</td>
          <td data-label="Game">${sale.gameName}</td>
          <td data-label="Tickets">${sale.tickets}</td>
          <td data-label="Sales">${formatCurrency(sale.salesAmount)}</td>
          <td data-label="Date">${formatDate(sale.soldAt)}</td>
        </tr>
      `
    )
    .join("");
}

function getAdminLottoMonitorRows(state) {
  return getSortedAgentGameHistory(state).sort((a, b) => String(a.agentName || "").localeCompare(String(b.agentName || "")));
}

function getAdminLottoMonitorSummary(state) {
  const rows = getAdminLottoMonitorRows(state);
  return {
    totalGamesPlayed: rows.reduce((sum, entry) => sum + Number(entry.totalGames || 0), 0),
    totalAmountEarned: rows.reduce((sum, entry) => sum + Number(entry.totalStakeAmount || 0), 0),
    rows
  };
}

function getAdminCashbackMonitorRows(state) {
  return getSortedCashbackHistory(state).sort((a, b) => String(a.agentName || "").localeCompare(String(b.agentName || "")));
}

function getAdminCashbackMonitorSummary(state) {
  const rows = getAdminCashbackMonitorRows(state);
  return {
    totalRecords: rows.length,
    totalGamesPlayed: rows.length,
    totalAmountEarned: rows.reduce((sum, entry) => sum + Number(entry.stakeAmount || 0), 0),
    totalAgents: new Set(rows.map((entry) => `${entry.agentName || ""}__${entry.outlet || ""}`)).size,
    rows
  };
}

function getAdminCashbackMonitorAgents(state) {
  const map = new Map();

  getSortedCashbackHistory(state).forEach((entry) => {
    const key = `${entry.agentName || ""}__${entry.outlet || ""}`;
    const current = map.get(key) || {
      agentKey: key,
      agentName: entry.agentName || "Samuel Ade",
      agentCode: entry.agentCode || "AG014",
      outlet: entry.outlet || "Surulere Outlet",
      totalEntries: 0,
      totalAmount: 0,
      lastPlayedAt: entry.playedAt
    };

    current.totalEntries += 1;
    current.totalAmount += Number(entry.stakeAmount || 0);
    current.lastPlayedAt = Math.max(current.lastPlayedAt || 0, entry.playedAt || 0);
    map.set(key, current);
  });

  return [...map.values()].sort((a, b) => b.totalAmount - a.totalAmount || b.lastPlayedAt - a.lastPlayedAt);
}

function getAdminCashbackFilterMatch(record, filter) {
  if (filter === "high-value") {
    return Number(record.stakeAmount || 0) >= 5000;
  }

  if (filter === "recent") {
    return Number(record.playedAt || 0) >= Date.now() - 24 * 60 * 60 * 1000;
  }

  return true;
}

function renderAdminCashbackMonitorAgents(container, agents, selectedAgentKey) {
  if (!container) {
    return;
  }

  if (!agents.length) {
    container.innerHTML = `
      <div class="empty-state empty-state--compact">
        <i data-lucide="users"></i>
        <p class="text-lg font-semibold text-ink">No agents match this view</p>
        <p class="mt-3 text-sm leading-6 text-muted">
          Try adjusting the search term or activity filter to reveal cash back records.
        </p>
      </div>
    `;
    if (window.lucide && typeof window.lucide.createIcons === "function") {
      window.lucide.createIcons();
    }
    return;
  }

  container.innerHTML = `
    <button type="button" class="sales-agent-card ${selectedAgentKey ? "" : "is-active"}" data-cashback-agent="all">
      <div class="sales-agent-card-head">
        <div>
          <p class="sales-agent-name">All Agents</p>
          <p class="sales-agent-meta">Combined cash back stream</p>
        </div>
        <span class="status-pill">Overview</span>
      </div>
      <div class="sales-agent-stats">
        <div>
          <p class="sales-agent-stat-label">Agents</p>
          <strong class="sales-agent-stat-value">${agents.length}</strong>
        </div>
      </div>
    </button>
    ${agents
      .map(
        (agent) => `
          <button type="button" class="sales-agent-card ${selectedAgentKey === agent.agentKey ? "is-active" : ""}" data-cashback-agent="${agent.agentKey}">
            <div class="sales-agent-card-head">
              <div>
                <p class="sales-agent-name">${agent.agentName}</p>
                <p class="sales-agent-meta">${agent.outlet}</p>
              </div>
              <span class="sales-agent-date">${formatDate(agent.lastPlayedAt)}</span>
            </div>
            <div class="sales-agent-stats">
              <div>
                <p class="sales-agent-stat-label">Entries</p>
                <strong class="sales-agent-stat-value">${agent.totalEntries}</strong>
              </div>
              <div>
                <p class="sales-agent-stat-label">Agent Code</p>
                <strong class="sales-agent-stat-value">${agent.agentCode}</strong>
              </div>
              <div>
                <p class="sales-agent-stat-label">Amount</p>
                <strong class="sales-agent-stat-value">${formatCurrency(agent.totalAmount)}</strong>
              </div>
            </div>
          </button>
        `
      )
      .join("")}
  `;
}

function renderAdminCashbackMonitorTransactions(container, rows, options = {}) {
  if (!container) {
    return;
  }

  if (!rows.length) {
    const hasActiveFilter = Boolean(options.hasActiveFilter);
    container.innerHTML = `
      <tr>
        <td colspan="7">
          <div class="empty-state empty-state--compact py-10">
            <i data-lucide="badge-dollar-sign"></i>
            <p class="text-lg font-semibold text-ink">${hasActiveFilter ? "No matching cash back records found" : "No cash back records yet"}</p>
            <p class="mt-3 text-sm leading-6 text-muted">
              ${hasActiveFilter
                ? "Try adjusting the search term, filter, or selected agent."
                : "Agent cash back transactions will appear here once tickets are submitted."}
            </p>
          </div>
        </td>
      </tr>
    `;
    if (window.lucide && typeof window.lucide.createIcons === "function") {
      window.lucide.createIcons();
    }
    return;
  }

  container.innerHTML = rows
    .map(
      (entry) => `
        <tr>
          <td data-label="Agent">${entry.agentName || "Samuel Ade"}</td>
          <td data-label="Agent Code">${entry.agentCode || "AG014"}</td>
          <td data-label="Outlet">${entry.outlet || "Surulere Outlet"}</td>
          <td data-label="Game">${entry.gameName}</td>
          <td data-label="Cash Back ID">${entry.cashBackId}</td>
          <td data-label="Amount">${formatCurrency(entry.stakeAmount)}</td>
          <td data-label="Date">${formatDate(entry.playedAt)}</td>
        </tr>
      `
    )
    .join("");
}

function renderAdminLottoMonitorTable(container, rows) {
  if (!container) {
    return;
  }

  if (!rows.length) {
    container.innerHTML = `
      <tr>
        <td colspan="7">
          <div class="empty-state empty-state--compact py-10">
            <i data-lucide="gamepad-2"></i>
            <p class="text-lg font-semibold text-ink">No lotto play records yet</p>
            <p class="mt-3 text-sm leading-6 text-muted">
              Agent lotto play transactions will appear here once agents start submitting games.
            </p>
          </div>
        </td>
      </tr>
    `;
    if (window.lucide && typeof window.lucide.createIcons === "function") {
      window.lucide.createIcons();
    }
    return;
  }

  container.innerHTML = rows
    .map(
      (entry) => `
        <tr>
          <td data-label="Agent">${entry.agentName || "Samuel Ade"}</td>
          <td data-label="Agent Code">${entry.agentCode || "AG014"}</td>
          <td data-label="Outlet">${entry.outlet || "Surulere Outlet"}</td>
          <td data-label="Ticket">${entry.ticketCode}</td>
          <td data-label="Games Played">${entry.totalGames}</td>
          <td data-label="Amount Earned">${formatCurrency(entry.totalStakeAmount)}</td>
          <td data-label="Date">${formatDate(entry.playedAt)}</td>
        </tr>
      `
    )
    .join("");
}

function renderAdminCashbackMonitorTable(container, rows) {
  if (!container) {
    return;
  }

  if (!rows.length) {
    container.innerHTML = `
      <tr>
        <td colspan="7">
          <div class="empty-state empty-state--compact py-10">
            <i data-lucide="badge-dollar-sign"></i>
            <p class="text-lg font-semibold text-ink">No cash back records yet</p>
            <p class="mt-3 text-sm leading-6 text-muted">
              Agent cash back transactions will appear here once agents start submitting tickets.
            </p>
          </div>
        </td>
      </tr>
    `;
    if (window.lucide && typeof window.lucide.createIcons === "function") {
      window.lucide.createIcons();
    }
    return;
  }

  container.innerHTML = rows
    .map(
      (entry) => `
        <tr>
          <td data-label="Agent">${entry.agentName || "Samuel Ade"}</td>
          <td data-label="Agent Code">${entry.agentCode || "AG014"}</td>
          <td data-label="Outlet">${entry.outlet || "Surulere Outlet"}</td>
          <td data-label="Game">${entry.gameName}</td>
          <td data-label="Cash Back ID">${entry.cashBackId}</td>
          <td data-label="Amount Earned">${formatCurrency(entry.stakeAmount)}</td>
          <td data-label="Date">${formatDate(entry.playedAt)}</td>
        </tr>
      `
    )
    .join("");
}

function renderAgentPlayHistory(container, history, options = {}) {
  if (!container) {
    return;
  }

  if (!history.length) {
    const hasActiveFilter = Boolean(options.hasActiveFilter);
    container.innerHTML = `
      <tr>
        <td colspan="7">
          <div class="empty-state empty-state--compact py-10">
            <i data-lucide="gamepad-2"></i>
            <p class="text-lg font-semibold text-ink">${hasActiveFilter ? "No matching transactions found" : "No transactions available"}</p>
            <p class="mt-3 text-sm leading-6 text-muted">
              ${hasActiveFilter
                ? "Try adjusting the search term or status filter, or submit a new game transaction."
                : "No game history has been recorded yet. Once the agent submits a ticket, the transaction will appear here."}
            </p>
          </div>
        </td>
      </tr>
    `;
    if (window.lucide && typeof window.lucide.createIcons === "function") {
      window.lucide.createIcons();
    }
    return;
  }

  container.innerHTML = history
    .map(
      (entry) => `
        <tr>
          <td data-label="Ticket">${entry.ticketCode}</td>
          <td data-label="Game Summary">
            <div class="space-y-2">
              ${entry.items
                .map(
                  (item) => `
                    <div>
                      <p class="text-sm font-semibold text-ink">${item.gameName}</p>
                      <p class="mt-1 text-xs text-muted">${item.betType}</p>
                    </div>
                  `
                )
                .join("")}
            </div>
          </td>
          <td data-label="Selected Numbers">
            <div class="space-y-3">
              ${entry.items
                .map(
                  (item, index) => `
                    <div>
                      <p class="mb-2 text-xs font-semibold uppercase tracking-[0.18em] text-muted">Game ${index + 1}</p>
                      <div class="number-chip-row">
                        ${item.selections.map((number) => `<span class="number-chip">${number}</span>`).join("")}
                      </div>
                    </div>
                  `
                )
                .join("")}
            </div>
          </td>
          <td data-label="Total Games">${entry.totalGames}</td>
          <td data-label="Grand Stake">${formatCurrency(entry.totalStakeAmount)}</td>
          <td data-label="Date">${formatDate(entry.playedAt)}</td>
          <td data-label="Status"><span class="status-pill ${getStatusTone(entry.status)}">${entry.status}</span></td>
        </tr>
      `
    )
    .join("");
}

function renderCashbackHistory(container, history, options = {}) {
  if (!container) {
    return;
  }

  if (!history.length) {
    const hasActiveFilter = Boolean(options.hasActiveFilter);
    container.innerHTML = `
      <tr>
        <td colspan="7">
          <div class="empty-state empty-state--compact py-10">
            <i data-lucide="badge-dollar-sign"></i>
            <p class="text-lg font-semibold text-ink">${hasActiveFilter ? "No matching cash back tickets found" : "No cash back tickets available"}</p>
            <p class="mt-3 text-sm leading-6 text-muted">
              ${hasActiveFilter
                ? "Try adjusting the search term or status filter."
                : "Once a cash back game is submitted, the ticket will appear here."}
            </p>
          </div>
        </td>
      </tr>
    `;
    if (window.lucide && typeof window.lucide.createIcons === "function") {
      window.lucide.createIcons();
    }
    return;
  }

  container.innerHTML = history
    .map(
      (entry) => `
        <tr>
          <td data-label="Ticket">${entry.ticketCode}</td>
          <td data-label="Game">${entry.gameName}</td>
          <td data-label="Cash Back Type">${entry.cashBackType}</td>
          <td data-label="Stake Amount">${formatCurrency(entry.stakeAmount)}</td>
          <td data-label="Cash Back ID">${entry.cashBackId}</td>
          <td data-label="Date">${formatDate(entry.playedAt)}</td>
          <td data-label="Status"><span class="status-pill ${getStatusTone(entry.status)}">${entry.status}</span></td>
        </tr>
      `
    )
    .join("");
}

function renderSelectedPlayNumbers(container, numbers) {
  if (!container) {
    return;
  }

  if (!numbers.length) {
    container.innerHTML = `
      <div class="empty-state empty-state--compact w-full">
        <i data-lucide="hash"></i>
        <p class="text-lg font-semibold text-ink">No numbers selected yet</p>
        <p class="mt-3 text-sm leading-6 text-muted">
          Choose up to 20 numbers from the board to prepare a game.
        </p>
      </div>
    `;
    if (window.lucide && typeof window.lucide.createIcons === "function") {
      window.lucide.createIcons();
    }
    return;
  }

  container.innerHTML = numbers
    .map((number) => `<span class="selected-number-chip">${formatPlayNumber(number)}</span>`)
    .join("");
}

function renderPlayNumberGrid(container, selectedNumbers) {
  if (!container) {
    return;
  }

  const selectedSet = new Set(selectedNumbers);

  container.innerHTML = Array.from({ length: 90 }, (_, index) => {
    const number = index + 1;
    const isSelected = selectedSet.has(number);
    const isDisabled = !isSelected && selectedNumbers.length >= 20;

    return `
      <button
        class="play-number-button ${isSelected ? "is-selected" : ""} ${isDisabled ? "is-disabled" : ""}"
        type="button"
        data-play-number="${number}"
        ${isDisabled ? "aria-disabled=\"true\"" : ""}
      >
        ${formatPlayNumber(number)}
      </button>
    `;
  }).join("");
}

function renderDraftGames(container, draftGames, options = {}) {
  if (!container) {
    return;
  }

  const mode = options.mode || "lotto";

  if (!draftGames.length) {
    container.innerHTML = `
      <div class="empty-state empty-state--compact">
        <i data-lucide="files"></i>
        <p class="text-lg font-semibold text-ink">No staged games yet</p>
        <p class="mt-3 text-sm leading-6 text-muted">
          Add a game from the builder and it will appear here ready for printing.
        </p>
      </div>
    `;
    if (window.lucide && typeof window.lucide.createIcons === "function") {
      window.lucide.createIcons();
    }
    return;
  }

  container.innerHTML = draftGames
    .map(
      (game, index) => `
        <article class="draft-game-card">
          <div class="flex items-start justify-between gap-3">
            <div>
              <p class="text-sm font-semibold text-ink">${game.gameName}</p>
              <p class="mt-1 text-sm text-muted">${mode === "cashback" ? game.cashBackType : game.betType}</p>
            </div>
            <span class="status-pill">${index + 1}</span>
          </div>
          <div class="draft-game-meta">
            <div class="number-chip-row">
              ${game.selections.map((item) => `<span class="number-chip">${item}</span>`).join("")}
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
              <div>
                <p class="result-label">Stake Amount</p>
                <p class="mt-2 text-sm font-semibold text-ink">${formatCurrency(game.stakeAmount)}</p>
              </div>
              <div>
                <p class="result-label">${mode === "cashback" ? "Cash Back ID" : "Unit Per Perm"}</p>
                <p class="mt-2 text-sm font-semibold text-ink">${mode === "cashback" ? game.cashBackId : game.unitPerPerm}</p>
              </div>
            </div>
          </div>
          <div class="draft-game-actions">
            <button class="action-button action-button-soft" type="button" data-edit-draft-game="${game.id}">
              Edit
            </button>
            <button class="action-button action-button-danger" type="button" data-delete-draft-game="${game.id}">
              Delete
            </button>
          </div>
        </article>
      `
    )
    .join("");
}

function renderReceiptPreview(container, receipt) {
  if (!container || !receipt) {
    return;
  }

  const totalNumbers = (receipt.items || []).reduce((sum, item) => sum + (item.selections?.length || 0), 0);
  const storedAgent = (() => {
    try {
      return JSON.parse(localStorage.getItem("agent_profile") || "null");
    } catch {
      return null;
    }
  })();
  const agentName = receipt.agentName || storedAgent?.name || "Agent";
  const terminalName = receipt.terminalName || "POS-MOZ";

  container.innerHTML = `
    <article class="ticket-slip">
      <div class="ticket-topline">
        <span>Blue-Extra Lotto - SALES TICKET</span>
        <span class="ticket-url">${window.location.origin}/lt/agent/placebet</span>
      </div>
      <div class="ticket-logo">
        <img src="/lt/public/assets/img/logo_1.png" alt="Blue Extra Lotto" />
      </div>
      <div class="ticket-title">
        <p class="ticket-brand">BLUE-EXTRA LOTTO</p>
        <p class="ticket-subtitle">SALES TICKET</p>
        <p class="ticket-code">Ticket: ${receipt.ticketCode}</p>
      </div>

      <div class="ticket-divider ticket-divider--dashed"></div>

      <div class="ticket-meta">
        <div>
          <p>Date: ${formatDateOnly(receipt.playedAt)}</p>
          <p>Time: ${formatTimeOnly(receipt.playedAt)}</p>
        </div>
        <div class="text-right">
          <p>Games: ${receipt.totalGames}</p>
        </div>
      </div>

      <div class="ticket-agent">
        <p>Agent: ${agentName}</p>
        <p>Terminal: ${terminalName}</p>
      </div>

      ${receipt.items
        .map(
          (item, index) => `
            <div class="ticket-game">
              <div class="ticket-game-head">
                <span>Game ${index + 1}: ${item.gameName}</span>
                <span class="ticket-game-type">${String(item.betType || "").toUpperCase()}</span>
              </div>
              <div class="ticket-numbers">
                ${item.selections.map((number) => `<span>${number}</span>`).join("")}
              </div>
              <div class="ticket-amount">? ${Number(item.amountPlayed || 0).toFixed(2)}</div>
            </div>
          `
        )
        .join("")}

      <div class="ticket-divider ticket-divider--strong"></div>

      <div class="ticket-totals">
        <div><span>Total Games:</span><strong>${receipt.totalGames}</strong></div>
        <div><span>Total Numbers:</span><strong>${totalNumbers}</strong></div>
      </div>

      <div class="ticket-grand">GRAND TOTAL: ? ${Number(receipt.totalStakeAmount || 0).toFixed(2)}</div>

      <div class="ticket-divider"></div>

      <div class="ticket-footer">
        <p>Thank you for playing with Blue-Extra Lotto!</p>
        <p class="ticket-goodluck">GOOD LUCK!</p>
        <p class="ticket-terms">
          Terms: All sales are final. Please verify your numbers before leaving.
          Draw dates and times are as announced. Keep this receipt for reference.
        </p>
      </div>
    </article>
  `;
}

function renderAgentsCards(container, agents) {
  if (!container) {
    return;
  }

  const state = getState();

  container.innerHTML = agents
    .map(
      (agent) => {
        const agentGames = (state.agentGameHistory || []).filter((entry) => entry.agentCode === agent.agentCode);
        const gamesPlayed = agentGames.reduce((total, entry) => total + Number(entry.totalGames || 0), 0);
        const totalEarned = agentGames.reduce((total, entry) => total + Number(entry.earnedAmount || 0), 0);

        return `
        <article class="agent-card">
          <div class="agent-card-head">
            <div class="agent-card-profile">
              <span class="initial-avatar">${getInitials(agent.name)}</span>
              <div>
                <p class="agent-card-name">${agent.name}</p>
                <p class="agent-card-meta">${agent.agentCode} · ${agent.outlet}</p>
              </div>
            </div>
            <span class="status-pill ${getStatusTone(agent.status)}">${agent.status}</span>
          </div>

          <div class="agent-wallet-panel">
            <p class="agent-wallet-label">Wallet Balance</p>
            <p class="agent-wallet-value">${formatCurrency(agent.balance || 0).replace("N", "₦")}</p>
          </div>

          <div class="agent-card-stats">
            <div class="agent-card-stat">
              <p class="agent-card-stat-label">Games Played</p>
              <strong class="agent-card-stat-value">${gamesPlayed}</strong>
            </div>
            <div class="agent-card-stat">
              <p class="agent-card-stat-label">Amount Earned</p>
              <strong class="agent-card-stat-value">${formatCurrency(totalEarned).replace("N", "₦")}</strong>
            </div>
          </div>

          <div class="agent-card-submeta">
            <span>${agent.region}</span>
            <span>${agent.phone}</span>
          </div>

          <div class="agent-card-actions">
            <button class="action-button action-button-soft" type="button" data-view-agent="${agent.id}">
              View
            </button>
            <button class="action-button action-button-soft" type="button" data-edit-agent="${agent.id}">Edit</button>
          </div>
        </article>
      `;
      }
    )
    .join("");
}

function renderAgentsEmptyState(container) {
  if (!container) {
    return;
  }

  container.innerHTML = `
    <div class="empty-state">
      <i data-lucide="users"></i>
      <p class="text-lg font-semibold text-ink">No agents found</p>
      <p class="mt-3 text-sm leading-6 text-muted">
        Try adjusting the search or filter, or create a new agent.
      </p>
    </div>
  `;

  if (window.lucide && typeof window.lucide.createIcons === "function") {
    window.lucide.createIcons();
  }
}

function renderAgentSkeletons(container, count = 3) {
  if (!container) {
    return;
  }

  container.innerHTML = Array.from({ length: count })
    .map(
      () => `
        <article class="skeleton-card">
          <div class="flex items-start justify-between gap-4">
            <div class="flex items-center gap-3">
              <div class="skeleton-avatar skeleton-shimmer"></div>
              <div class="space-y-3">
                <div class="skeleton-line skeleton-line--lg skeleton-shimmer w-32"></div>
                <div class="skeleton-line skeleton-shimmer w-24"></div>
              </div>
            </div>
            <div class="skeleton-line skeleton-shimmer w-20"></div>
          </div>
          <div class="mt-6 space-y-3">
            <div class="skeleton-line skeleton-shimmer w-full"></div>
            <div class="skeleton-line skeleton-shimmer w-4/5"></div>
            <div class="skeleton-line skeleton-shimmer w-3/5"></div>
          </div>
        </article>
      `
    )
    .join("");
}

function renderAgentView(container, agent) {
  if (!container || !agent) {
    return;
  }

  container.innerHTML = `
    <div class="flex items-start gap-4">
      <span class="initial-avatar initial-avatar--large">${getInitials(agent.name)}</span>
      <div>
        <p class="text-2xl font-semibold text-ink">${agent.name}</p>
        <p class="mt-2 text-sm text-muted">${agent.outlet}, ${agent.region}</p>
        <p class="mt-3"><span class="status-pill ${getStatusTone(agent.status)}">${agent.status}</span></p>
      </div>
    </div>
    <div class="mt-6 grid gap-4 sm:grid-cols-2">
      <div class="soft-card">
        <p class="result-label">Agent Code</p>
        <p class="mt-2 text-lg font-semibold text-ink">${agent.agentCode}</p>
      </div>
      <div class="soft-card">
        <p class="result-label">Phone</p>
        <p class="mt-2 text-lg font-semibold text-ink">${agent.phone}</p>
      </div>
      <div class="soft-card">
        <p class="result-label">Username</p>
        <p class="mt-2 text-lg font-semibold text-ink">${agent.username}</p>
      </div>
      <div class="soft-card">
        <p class="result-label">Password</p>
        <p class="mt-2 text-lg font-semibold text-ink">${agent.password}</p>
      </div>
      <div class="soft-card">
        <p class="result-label">Balance</p>
        <p class="mt-2 text-lg font-semibold text-ink">${formatCurrency(agent.balance || 0)}</p>
      </div>
      <div class="soft-card">
        <p class="result-label">Quick Actions</p>
        <div class="agent-card-actions mt-4">
          <button class="action-button action-button-soft" type="button" data-modal-toggle-agent="${agent.id}">
            ${agent.status === "active" ? "Suspend" : "Activate"}
          </button>
          <button class="action-button" type="button" data-modal-credit-agent="${agent.id}">
            Credit
          </button>
        </div>
      </div>
    </div>
  `;
}

function renderAgentStats(state) {
  const agents = getSortedAgents(state);
  const totalAgents = agents.length;
  const activeAgents = agents.filter((item) => item.status === "active").length;
  const suspendedAgents = agents.filter((item) => item.status === "suspended").length;
  const totalBalance = agents.reduce((sum, item) => sum + Number(item.balance || 0), 0);

  updateText("totalAgentsCount", String(totalAgents));
  updateText("activeAgentsCount", String(activeAgents));
  updateText("suspendedAgentsCount", String(suspendedAgents));
  updateText("agentsBalanceCount", formatCurrency(totalBalance));
}

function updateText(id, value) {
  const node = document.getElementById(id);
  if (node) {
    node.textContent = value;
  }
}

function renderAdminDashboard(state) {
  // Logic moved to admin-dashboard.php
  return;
}

function renderAgentDashboard(state) {
  const results = getSortedResults(state);
  const sales = getSortedSales(state)[0];

  updateText("agentCurrentDraw", results[0]?.gameName || "No live result");
  updateText("agentSalesToday", sales ? formatCurrency(sales.salesAmount) : "N 0");
  renderLatestResults(document.getElementById("agentLatestResults"), results);
}

function setupAdminResultsPage(state) {
  // Logic moved to admin-results.php
  return;
}

function setupAdminGamesPage(state) {
  const form = document.getElementById("addGameForm");
  const list = document.getElementById("gameList");
  const logsContainer = document.getElementById("gameLogs");
  const openModalButton = document.getElementById("openAllGamesModal");
  const modal = document.getElementById("allGamesModal");
  const closeModalButton = document.getElementById("closeAllGamesModal");
  const allGamesList = document.getElementById("allGamesList");

  renderLogs(logsContainer, state.logs || []);

  let allGames = [];

  function getRecentGames(games, days = 3) {
    const threshold = Date.now() - days * 24 * 60 * 60 * 1000;
    return games.filter((game) => {
      const createdAt = parseDbDate(game.created_at) || parseDbDate(game.cutoff_time);
      if (!createdAt) {
        return false;
      }
      return createdAt.getTime() >= threshold;
    });
  }

  function renderLists() {
    const recentGames = getRecentGames(allGames, 3);
    renderGames(list, recentGames);
    renderGames(allGamesList, allGames);
  }

  async function fetchGames() {
    try {
      const response = await fetch(`${API_BASE_PATH}api/game/all`, {
        headers: { "Content-Type": "application/json" }
      });
      const payload = await response.json();
      if (payload && payload.state && Array.isArray(payload.message)) {
        allGames = payload.message;
      } else {
        allGames = [];
      }
      renderLists();
    } catch (error) {
      allGames = [];
      renderLists();
    }
  }

  async function deleteGameApi(gameId) {
    const response = await fetch(`${API_BASE_PATH}api/game/delete`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ game_id: gameId })
    });
    const payload = await response.json().catch(() => ({}));
    if (payload && payload.state) {
      return true;
    }
    throw new Error(payload?.message || "Failed to delete game.");
  }

  async function handleDeleteClick(event) {
    const trigger = event.target.closest("[data-delete-game]");
    if (!trigger) {
      return;
    }
    const gameId = trigger.getAttribute("data-delete-game");
    if (!gameId) {
      return;
    }

    try {
      await deleteGameApi(gameId);
      await fetchGames();
      notify("Game deleted successfully.", "success", "Game removed");
    } catch (error) {
      notify(error.message || "Failed to delete game.", "error", "Delete failed");
    }
  }

  list?.addEventListener("click", handleDeleteClick);
  allGamesList?.addEventListener("click", handleDeleteClick);

  function openModal() {
    modal?.classList.add("is-open");
    document.body.classList.add("overflow-hidden");
  }

  function closeModal() {
    modal?.classList.remove("is-open");
    document.body.classList.remove("overflow-hidden");
  }

  openModalButton?.addEventListener("click", openModal);
  closeModalButton?.addEventListener("click", closeModal);
  modal?.addEventListener("click", (event) => {
    if (event.target === modal) {
      closeModal();
    }
  });

  window.refreshAdminGames = fetchGames;

  fetchGames();
}



function setupAdminCashbackMonitorPage(state) {
  // Logic moved to admin-cashback-monitor.php
  return;
}

function setupAdminAgentsPage(state) {
  // Logic moved to admin-agents.php
  return;
}

function setupAgentResultsPage(state) {
  const results = getSortedResults(state);
  renderLatestResults(document.getElementById("agentResultsList"), results);
  renderResultsHistory(document.getElementById("agentResultsHistory"), results);
}

function setupAgentPlayPage(state) {
  const playButton = document.getElementById("openPlayGameAction");
  const modal = document.getElementById("playGameModal");
  const closeButton = document.getElementById("closePlayGameModal");
  const historySearchInput = document.getElementById("agentPlaySearchInput");
  const historyFilterTabs = document.querySelectorAll("[data-play-filter]");
  const builderStep = document.getElementById("playBuilderStep");
  const receiptStep = document.getElementById("playReceiptStep");
  const numberGrid = document.getElementById("playNumberGrid");
  const selectedNumbersDisplay = document.getElementById("selectedNumbersDisplay");
  const clearSelectionButton = document.getElementById("clearSelectedNumbers");
  const addMoreGamesButton = document.getElementById("addMoreGamesAction");
  const updateGameButton = document.getElementById("saveGameUpdateAction");
  const draftGamesList = document.getElementById("draftGamesList");
  const proceedButton = document.getElementById("proceedToPrintingAction");
  const receiptPreview = document.getElementById("receiptPreviewBody");
  const backToBuilderButton = document.getElementById("backToBuilderAction");
  const submitReceiptButton = document.getElementById("submitReceiptAction");
  const gameSelect = document.getElementById("playGameSelect");
  const betTypeSelect = document.getElementById("playBetType");
  const stakeAmountInput = document.getElementById("playStakeAmount");
  const unitPerPermInput = document.getElementById("playUnitPerPerm");
  const editingDraftIdInput = document.getElementById("editingDraftId");
  const builderPrimaryActionLabel = document.getElementById("builderPrimaryActionLabel");
  let selectedNumbers = [];
  let draftGames = [];
  let currentReceipt = null;
  let currentHistorySearch = "";
  let currentHistoryFilter = "all";

  function normalizeGameRow(game) {
    const name = game.name || game.game_name || "Game";
    let drawTimeText = "Not set";
    if (game.drawTime) {
      drawTimeText = game.drawTime;
    } else if (game.cutoff_time) {
      const parsed = parseDbDate(game.cutoff_time);
      drawTimeText = parsed ? formatDate(parsed) : "Not set";
    }
    const category = String(game.category || game.game_category || "").toLowerCase();
    return { id: game.id, name, drawTime: drawTimeText, category };
  }

  async function loadLottoGames() {
    try {
      const response = await fetch(`${API_BASE_PATH}api/game/all`, {
        headers: { "Content-Type": "application/json" }
      });
      const payload = await response.json();
      const rows = payload && payload.state && Array.isArray(payload.message) ? payload.message : [];
      const normalized = rows.map(normalizeGameRow);
      const lottoGames = normalized.filter((game) =>
        ["lotto", "placebet"].includes(game.category)
      );
      commitState((nextState) => {
        nextState.games = lottoGames;
        return nextState;
      });
      renderGameSelect(gameSelect, lottoGames);
    } catch (error) {
      renderGameSelect(gameSelect, state.games);
    }
  }

  loadLottoGames();

  function getFilteredPlayHistory(nextState) {
    return getSortedAgentGameHistory(nextState).filter((entry) => {
      const matchesFilter = currentHistoryFilter === "all" ? true : entry.status === currentHistoryFilter;
      const haystack = [
        entry.ticketCode,
        entry.status,
        ...entry.items.flatMap((item) => [
          item.gameName,
          item.betType,
          ...(item.selections || [])
        ])
      ]
        .join(" ")
        .toLowerCase();
      const matchesSearch = haystack.includes(currentHistorySearch);
      return matchesFilter && matchesSearch;
    });
  }

  function renderPlayStats(nextState) {
    if (window.useLiveAgentPlay) {
      return;
    }
    const history = getSortedAgentGameHistory(nextState);
    const filteredHistory = getFilteredPlayHistory(nextState);
    const todayThreshold = Date.now() - 24 * 60 * 60 * 1000;
    const todayHistory = history.filter((entry) => entry.playedAt >= todayThreshold);
    const totalEarned = todayHistory.reduce((sum, entry) => sum + Number(entry.earnedAmount || 0), 0);

    updateText("agentAmountEarnedToday", formatCurrency(totalEarned));
    updateText("agentGamesPlayedToday", String(todayHistory.length));
    renderLatestResultSneakPeek(document.getElementById("agentPlayLatestResult"), getSortedResults(nextState));
    renderAgentPlayHistory(document.getElementById("agentPlayHistoryTable"), filteredHistory, {
      hasActiveFilter: currentHistoryFilter !== "all" || Boolean(currentHistorySearch)
    });
  }

  function syncSelectionUI() {
    updateText("playSelectionCount", String(selectedNumbers.length));
    renderPlayNumberGrid(numberGrid, selectedNumbers);
    renderSelectedPlayNumbers(selectedNumbersDisplay, selectedNumbers);
  }

  function resetBuilder() {
    selectedNumbers = [];
    editingDraftIdInput.value = "";
    if (betTypeSelect) {
      betTypeSelect.value = "";
    }
    if (stakeAmountInput) {
      stakeAmountInput.value = "";
    }
    if (unitPerPermInput) {
      unitPerPermInput.value = "";
    }
    addMoreGamesButton?.classList.remove("hidden");
    updateGameButton?.classList.add("hidden");
    if (builderPrimaryActionLabel) {
      builderPrimaryActionLabel.textContent = "Add More Games";
    }
    syncSelectionUI();
  }

  function renderDraftSummary() {
    renderDraftGames(draftGamesList, draftGames, { mode: "cashback" });
    updateText("draftGamesCount", String(draftGames.length));
    updateText("draftGamesTotalCount", String(draftGames.length));
    updateText(
      "draftGamesTotalStake",
      formatCurrency(draftGames.reduce((sum, item) => sum + Number(item.amountPlayed || 0), 0))
    );
  }

  function getFormPayload() {
    const gameId = gameSelect?.value || "";
    const game = getState().games.find((item) => item.id === gameId);
    const betType = betTypeSelect?.value || "";
    const stakeAmount = Number(stakeAmountInput?.value || 0);
    const unitPerPerm = Number(unitPerPermInput?.value || 0);

    if (selectedNumbers.length > 20) {
      notify("You can only select up to 20 numbers per game.", "error", "Selection limit");
      return null;
    }
    if (selectedNumbers.length < 1) {
      notify("Select at least one number before adding the game.", "error", "Incomplete selection");
      return null;
    }

    if (!game || !betType || !stakeAmount || !unitPerPerm) {
      notify("Complete the game, bet type, stake amount, and unit per perm fields.", "error", "Missing details");
      return null;
    }

    return {
      id: editingDraftIdInput.value || createId("draft"),
      gameId,
      gameName: game.name,
      betType,
      stakeAmount,
      unitPerPerm,
      amountPlayed: stakeAmount * unitPerPerm,
      earnedAmount: stakeAmount,
      selections: selectedNumbers.map((number) => formatPlayNumber(number))
    };
  }

  function openEditDraft(draftId) {
    const draft = draftGames.find((item) => item.id === draftId);
    if (!draft) {
      return;
    }

    editingDraftIdInput.value = draft.id;
    if (gameSelect) {
      gameSelect.value = draft.gameId;
    }
    if (betTypeSelect) {
      betTypeSelect.value = draft.betType;
    }
    if (stakeAmountInput) {
      stakeAmountInput.value = draft.stakeAmount;
    }
    if (unitPerPermInput) {
      unitPerPermInput.value = draft.unitPerPerm;
    }
    selectedNumbers = draft.selections.map((value) => Number(value));
    addMoreGamesButton?.classList.add("hidden");
    updateGameButton?.classList.remove("hidden");
    syncSelectionUI();
    notify("Staged game loaded for editing.", "info", "Edit game");
  }

  function closeModal() {
    modal?.classList.remove("is-open");
    document.body.classList.remove("overflow-hidden");
    builderStep?.classList.remove("hidden");
    receiptStep?.classList.add("hidden");
    currentReceipt = null;
    resetBuilder();
  }

  renderPlayStats(state);
  syncSelectionUI();
  renderDraftSummary();

  playButton?.addEventListener("click", () => {
    modal?.classList.add("is-open");
    document.body.classList.add("overflow-hidden");
  });

  historySearchInput?.addEventListener("input", (event) => {
    currentHistorySearch = event.target.value.trim().toLowerCase();
    renderPlayStats(getState());
  });

  historyFilterTabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      historyFilterTabs.forEach((item) => item.classList.remove("is-active"));
      tab.classList.add("is-active");
      currentHistoryFilter = tab.dataset.playFilter || "all";
      renderPlayStats(getState());
    });
  });

  closeButton?.addEventListener("click", closeModal);

  modal?.addEventListener("click", (event) => {
    if (event.target === modal) {
      closeModal();
    }
  });

  numberGrid?.addEventListener("click", (event) => {
    const trigger = event.target.closest("[data-play-number]");
    if (!trigger) {
      return;
    }

    const number = Number(trigger.getAttribute("data-play-number"));
    const exists = selectedNumbers.includes(number);

    if (exists) {
      selectedNumbers = selectedNumbers.filter((item) => item !== number);
      syncSelectionUI();
      return;
    }

    if (selectedNumbers.length >= 20) {
      notify("You can only select 20 numbers for one game.", "error", "Selection limit");
      return;
    }

    selectedNumbers = [...selectedNumbers, number].sort((a, b) => a - b);
    syncSelectionUI();
  });

  clearSelectionButton?.addEventListener("click", () => {
    selectedNumbers = [];
    syncSelectionUI();
  });

  addMoreGamesButton?.addEventListener("click", () => {
    if (window.useLiveAgentCashback && draftGames.length >= 1) {
      notify("Only one game is allowed for cash back.", "error", "Limit reached");
      return;
    }
    const payload = getFormPayload();
    if (!payload) {
      return;
    }

    draftGames.unshift(payload);
    renderDraftSummary();
    resetBuilder();
    notify("Game added to print queue.", "success", "Game staged");
  });

  updateGameButton?.addEventListener("click", () => {
    const payload = getFormPayload();
    if (!payload) {
      return;
    }

    draftGames = draftGames.map((item) => item.id === payload.id ? payload : item);
    renderDraftSummary();
    resetBuilder();
    notify("Staged game updated successfully.", "success", "Game updated");
  });

  draftGamesList?.addEventListener("click", (event) => {
    const editTrigger = event.target.closest("[data-edit-draft-game]");
    const deleteTrigger = event.target.closest("[data-delete-draft-game]");

    if (editTrigger) {
      openEditDraft(editTrigger.getAttribute("data-edit-draft-game"));
      return;
    }

    if (deleteTrigger) {
      const draftId = deleteTrigger.getAttribute("data-delete-draft-game");
      draftGames = draftGames.filter((item) => item.id !== draftId);

      if (editingDraftIdInput.value === draftId) {
        resetBuilder();
      }

      renderDraftSummary();
      notify("Staged game removed.", "success", "Game deleted");
    }
  });

  proceedButton?.addEventListener("click", () => {
    if (!draftGames.length) {
      notify("Add at least one game before proceeding to printing.", "error", "Nothing to print");
      return;
    }

    currentReceipt = {
      ticketCode: `TK-${Math.floor(10000 + Math.random() * 89999)}`,
      playedAt: Date.now(),
      totalGames: draftGames.length,
      totalStakeAmount: draftGames.reduce((sum, item) => sum + Number(item.amountPlayed || 0), 0),
      earnedAmount: draftGames.reduce((sum, item) => sum + Number(item.earnedAmount || 0), 0),
      status: "printed",
      items: draftGames.map((item) => ({
        gameName: item.gameName,
        betType: item.betType,
        selections: item.selections,
        stakeAmount: item.stakeAmount,
        unitPerPerm: item.unitPerPerm,
        amountPlayed: item.amountPlayed
      }))
    };

    renderReceiptPreview(receiptPreview, currentReceipt);
    builderStep?.classList.add("hidden");
    receiptStep?.classList.remove("hidden");
  });

  backToBuilderButton?.addEventListener("click", () => {
    receiptStep?.classList.add("hidden");
    builderStep?.classList.remove("hidden");
  });

  submitReceiptButton?.addEventListener("click", async () => {
    if (!currentReceipt) {
      notify("Prepare the receipt before submitting.", "error", "Missing receipt");
      return;
    }

    if (typeof window.handleAgentPlaySubmit === "function") {
      try {
        const handled = await window.handleAgentPlaySubmit(currentReceipt, draftGames);
        if (handled) {
          return;
        }
      } catch (error) {
        notify(error?.message || "Failed to submit transaction.", "error", "Submission failed");
        return;
      }
    }

    const nextState = addAgentGameEntries(
      currentReceipt.items.map((item) => ({
        ...item,
        earnedAmount: item.stakeAmount
      })),
      {
        ticketCode: currentReceipt.ticketCode,
        playedAt: currentReceipt.playedAt
      }
    );

    renderPlayStats(nextState);
    sessionStorage.setItem("blueextra-receipt", JSON.stringify(currentReceipt));
    sessionStorage.setItem(
      "blueextra-toast",
      JSON.stringify({
        message: "Ticket submitted successfully. Receipt is ready to print.",
        type: "success",
        title: "Transaction submitted"
      })
    );

    draftGames = [];
    renderDraftSummary();
    closeModal();
    window.location.href = "./agent-receipt.html";
  });
}

function setupAgentCashbackPage(state) {
  const playButton = document.getElementById("openPlayGameAction");
  const modal = document.getElementById("playGameModal");
  const closeButton = document.getElementById("closePlayGameModal");
  const historySearchInput = document.getElementById("agentCashbackSearchInput");
  const historyFilterTabs = document.querySelectorAll("[data-cashback-filter]");
  const builderStep = document.getElementById("playBuilderStep");
  const receiptStep = document.getElementById("playReceiptStep");
  const numberGrid = document.getElementById("playNumberGrid");
  const selectedNumbersDisplay = document.getElementById("selectedNumbersDisplay");
  const clearSelectionButton = document.getElementById("clearSelectedNumbers");
  const addMoreGamesButton = document.getElementById("addMoreGamesAction");
  const updateGameButton = document.getElementById("saveGameUpdateAction");
  const draftGamesList = document.getElementById("draftGamesList");
  const proceedButton = document.getElementById("proceedToPrintingAction");
  const receiptPreview = document.getElementById("receiptPreviewBody");
  const backToBuilderButton = document.getElementById("backToBuilderAction");
  const submitReceiptButton = document.getElementById("submitReceiptAction");
  const gameSelect = document.getElementById("playGameSelect");
  const cashBackTypeSelect = document.getElementById("cashbackType");
  const stakeAmountInput = document.getElementById("playStakeAmount");
  const cashBackIdInput = document.getElementById("cashbackId");
  const editingDraftIdInput = document.getElementById("editingDraftId");
  const builderPrimaryActionLabel = document.getElementById("builderPrimaryActionLabel");
  let selectedNumbers = [];
  let draftGames = [];
  let currentReceipt = null;
  let currentHistorySearch = "";
  let currentHistoryFilter = "all";

  renderGameSelect(gameSelect, state.games);

  function getFilteredPlayHistory(nextState) {
    return getSortedCashbackHistory(nextState).filter((entry) => {
      const matchesFilter = currentHistoryFilter === "all" ? true : entry.status === currentHistoryFilter;
      const haystack = [
        entry.ticketCode,
        entry.gameName,
        entry.cashBackType,
        entry.cashBackId,
        entry.status,
        ...(entry.selections || [])
      ]
        .join(" ")
        .toLowerCase();
      const matchesSearch = haystack.includes(currentHistorySearch);
      return matchesFilter && matchesSearch;
    });
  }

  function renderPlayStats(nextState) {
    if (window.useLiveAgentCashback) {
      return;
    }
    const history = getSortedCashbackHistory(nextState);
    const filteredHistory = getFilteredPlayHistory(nextState);
    const todayThreshold = Date.now() - 24 * 60 * 60 * 1000;
    const todayHistory = history.filter((entry) => entry.playedAt >= todayThreshold);
    const totalEarned = todayHistory.reduce((sum, entry) => sum + Number(entry.stakeAmount || 0), 0);

    updateText("agentAmountEarnedToday", formatCurrency(totalEarned));
    updateText("agentGamesPlayedToday", String(todayHistory.length));
    renderLatestResultSneakPeek(document.getElementById("agentPlayLatestResult"), getSortedResults(nextState));
    renderCashbackHistory(document.getElementById("agentCashbackHistoryTable"), filteredHistory, {
      hasActiveFilter: currentHistoryFilter !== "all" || Boolean(currentHistorySearch)
    });
  }

  function syncSelectionUI() {
    updateText("playSelectionCount", String(selectedNumbers.length));
    renderPlayNumberGrid(numberGrid, selectedNumbers);
    renderSelectedPlayNumbers(selectedNumbersDisplay, selectedNumbers);
  }

  function resetBuilder() {
    selectedNumbers = [];
    editingDraftIdInput.value = "";
    if (cashBackTypeSelect) {
      cashBackTypeSelect.value = "";
    }
    if (stakeAmountInput) {
      stakeAmountInput.value = "";
    }
    if (cashBackIdInput) {
      cashBackIdInput.value = "";
    }
    if (builderPrimaryActionLabel) {
      builderPrimaryActionLabel.textContent = "Save Game";
    }
    addMoreGamesButton?.classList.remove("hidden");
    updateGameButton?.classList.add("hidden");
    syncSelectionUI();
  }

  function renderDraftSummary() {
    renderDraftGames(draftGamesList, draftGames);
    updateText("draftGamesCount", String(draftGames.length));
    updateText("draftGamesTotalCount", String(draftGames.length));
    updateText(
      "draftGamesTotalStake",
      formatCurrency(draftGames.reduce((sum, item) => sum + Number(item.amountPlayed || 0), 0))
    );
  }

  function getFormPayload() {
    const gameId = gameSelect?.value || "";
    const game = getState().games.find((item) => item.id === gameId);
    const cashBackType = cashBackTypeSelect?.value || "";
    const stakeAmount = Number(stakeAmountInput?.value || 0);
    const cashBackId = String(cashBackIdInput?.value || "").trim();

    if (selectedNumbers.length !== 20) {
      notify("Select exactly 20 numbers before saving the game.", "error", "Incomplete selection");
      return null;
    }

    if (!game || !cashBackType || !stakeAmount || !cashBackId) {
      notify("Complete the game, cash back type, stake amount, and cash back id fields.", "error", "Missing details");
      return null;
    }

    return {
      id: editingDraftIdInput.value || createId("draft"),
      gameId,
      gameName: game.name,
      cashBackType,
      stakeAmount,
      cashBackId,
      amountPlayed: stakeAmount,
      selections: selectedNumbers.map((number) => formatPlayNumber(number))
    };
  }

  function openEditDraft(draftId) {
    const draft = draftGames.find((item) => item.id === draftId);
    if (!draft) {
      return;
    }

    editingDraftIdInput.value = draft.id;
    if (gameSelect) {
      gameSelect.value = draft.gameId;
    }
    if (cashBackTypeSelect) {
      cashBackTypeSelect.value = draft.cashBackType;
    }
    if (stakeAmountInput) {
      stakeAmountInput.value = draft.stakeAmount;
    }
    if (cashBackIdInput) {
      cashBackIdInput.value = draft.cashBackId;
    }
    selectedNumbers = draft.selections.map((value) => Number(value));
    addMoreGamesButton?.classList.add("hidden");
    updateGameButton?.classList.remove("hidden");
    syncSelectionUI();
    notify("Cash back game loaded for editing.", "info", "Edit game");
  }

  function closeModal() {
    modal?.classList.remove("is-open");
    document.body.classList.remove("overflow-hidden");
    builderStep?.classList.remove("hidden");
    receiptStep?.classList.add("hidden");
    currentReceipt = null;
    resetBuilder();
  }

  renderPlayStats(state);
  syncSelectionUI();
  renderDraftSummary();

  playButton?.addEventListener("click", () => {
    modal?.classList.add("is-open");
    document.body.classList.add("overflow-hidden");
  });

  historySearchInput?.addEventListener("input", (event) => {
    currentHistorySearch = event.target.value.trim().toLowerCase();
    renderPlayStats(getState());
  });

  historyFilterTabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      historyFilterTabs.forEach((item) => item.classList.remove("is-active"));
      tab.classList.add("is-active");
      currentHistoryFilter = tab.dataset.cashbackFilter || "all";
      renderPlayStats(getState());
    });
  });

  closeButton?.addEventListener("click", closeModal);

  modal?.addEventListener("click", (event) => {
    if (event.target === modal) {
      closeModal();
    }
  });

  numberGrid?.addEventListener("click", (event) => {
    const trigger = event.target.closest("[data-play-number]");
    if (!trigger) {
      return;
    }

    const number = Number(trigger.getAttribute("data-play-number"));
    const exists = selectedNumbers.includes(number);

    if (exists) {
      selectedNumbers = selectedNumbers.filter((item) => item !== number);
      syncSelectionUI();
      return;
    }

    if (selectedNumbers.length >= 20) {
      notify("You can only select 20 numbers for one cash back game.", "error", "Selection limit");
      return;
    }

    selectedNumbers = [...selectedNumbers, number].sort((a, b) => a - b);
    syncSelectionUI();
  });

  clearSelectionButton?.addEventListener("click", () => {
    selectedNumbers = [];
    syncSelectionUI();
  });

  addMoreGamesButton?.addEventListener("click", () => {
    const payload = getFormPayload();
    if (!payload) {
      return;
    }

    draftGames = [payload];
    renderDraftSummary();
    resetBuilder();
    notify("Cash back game saved.", "success", "Game staged");
  });

  updateGameButton?.addEventListener("click", () => {
    const payload = getFormPayload();
    if (!payload) {
      return;
    }

    draftGames = [payload];
    renderDraftSummary();
    resetBuilder();
    notify("Cash back game updated successfully.", "success", "Game updated");
  });

  draftGamesList?.addEventListener("click", (event) => {
    const editTrigger = event.target.closest("[data-edit-draft-game]");
    const deleteTrigger = event.target.closest("[data-delete-draft-game]");

    if (editTrigger) {
      openEditDraft(editTrigger.getAttribute("data-edit-draft-game"));
      return;
    }

    if (deleteTrigger) {
      const draftId = deleteTrigger.getAttribute("data-delete-draft-game");
      draftGames = draftGames.filter((item) => item.id !== draftId);

      if (editingDraftIdInput.value === draftId) {
        resetBuilder();
      }

      renderDraftSummary();
      notify("Cash back game removed.", "success", "Game deleted");
    }
  });

  proceedButton?.addEventListener("click", () => {
    if (!draftGames.length) {
      notify("Save a cash back game before proceeding to printing.", "error", "Nothing to print");
      return;
    }

    currentReceipt = {
      ticketCode: `CB-${Math.floor(10000 + Math.random() * 89999)}`,
      playedAt: Date.now(),
      mode: "cashback",
      totalGames: draftGames.length,
      totalStakeAmount: draftGames.reduce((sum, item) => sum + Number(item.amountPlayed || 0), 0),
      earnedAmount: draftGames.reduce((sum, item) => sum + Number(item.amountPlayed || 0), 0),
      status: "printed",
      items: draftGames.map((item) => ({
        gameName: item.gameName,
        betType: item.cashBackType,
        selections: item.selections,
        stakeAmount: item.stakeAmount,
        unitPerPerm: item.cashBackId,
        amountPlayed: item.amountPlayed
      }))
    };

    renderReceiptPreview(receiptPreview, currentReceipt);
    builderStep?.classList.add("hidden");
    receiptStep?.classList.remove("hidden");
  });

  backToBuilderButton?.addEventListener("click", () => {
    receiptStep?.classList.add("hidden");
    builderStep?.classList.remove("hidden");
  });

  submitReceiptButton?.addEventListener("click", async () => {
    if (!currentReceipt) {
      notify("Prepare the receipt before submitting.", "error", "Missing receipt");
      return;
    }

    if (typeof window.handleAgentCashbackSubmit === "function") {
      try {
        const handled = await window.handleAgentCashbackSubmit(currentReceipt, draftGames);
        if (handled) {
          return;
        }
      } catch (error) {
        notify(error?.message || "Failed to submit transaction.", "error", "Submission failed");
        return;
      }
    }

    const nextState = addCashbackEntry(
      {
        gameName: currentReceipt.items[0].gameName,
        cashBackType: currentReceipt.items[0].betType,
        stakeAmount: currentReceipt.items[0].stakeAmount,
        cashBackId: currentReceipt.items[0].unitPerPerm,
        selections: currentReceipt.items[0].selections
      },
      {
        ticketCode: currentReceipt.ticketCode,
        playedAt: currentReceipt.playedAt
      }
    );

    renderPlayStats(nextState);
    sessionStorage.setItem("blueextra-receipt", JSON.stringify(currentReceipt));
    sessionStorage.setItem(
      "blueextra-toast",
      JSON.stringify({
        message: "Cash back ticket submitted successfully. Receipt is ready to print.",
        type: "success",
        title: "Transaction submitted"
      })
    );

    draftGames = [];
    renderDraftSummary();
    closeModal();
    window.location.href = "./agent-receipt.html";
  });
}

function setupAgentReceiptPage() {
  const receiptContainer = document.getElementById("receiptPageBody");
  const printButton = document.getElementById("printReceiptAction");
  const storedReceipt = sessionStorage.getItem("blueextra-receipt");

  if (!storedReceipt) {
    renderReceiptPreview(receiptContainer, {
      ticketCode: "No active receipt",
      playedAt: Date.now(),
      totalGames: 0,
      totalStakeAmount: 0,
      items: []
    });
  } else {
    try {
      renderReceiptPreview(receiptContainer, JSON.parse(storedReceipt));
    } catch {
      renderReceiptPreview(receiptContainer, {
        ticketCode: "Receipt unavailable",
        playedAt: Date.now(),
        totalGames: 0,
        totalStakeAmount: 0,
        items: []
      });
    }
  }

  printButton?.addEventListener("click", () => {
    window.print();
  });
}

function initializePlatformPage() {
  let state = getState();
  const page = document.body.dataset.page;

  if (page === "agent-dashboard") {
    renderAgentDashboard(state);
  }

  if (page === "admin-games") {
    setupAdminGamesPage(state);
  }



  if (page === "agent-results") {
    setupAgentResultsPage(state);
  }

  if (page === "agent-play") {
    setupAgentPlayPage(state);
  }

  if (page === "agent-cashback") {
    setupAgentCashbackPage(state);
  }

  if (page === "agent-receipt") {
    setupAgentReceiptPage();
  }

}

initializePlatformPage();
