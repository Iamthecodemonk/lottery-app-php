<script src="/lt/public/assets/js/platform.js"></script>
  <script src="/lt/public/assets/js/app.js"></script>
  <script>
    if ("serviceWorker" in navigator) {
      window.addEventListener("load", () => {
        navigator.serviceWorker.register("/lt/sw.js").catch(() => {});
      });
    }
  </script>
