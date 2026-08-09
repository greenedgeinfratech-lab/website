document.addEventListener("DOMContentLoaded", () => {
  loadHeader();
  loadFooter();
});

function loadHeader() {
  fetch("components/header.html")
    .then((res) => res.text())
    .then((html) => {
      const mount = document.getElementById("header");
      mount.innerHTML = html;
      initHeader(mount); // <-- init after mount
    })
    .catch((err) => console.error("Error loading header:", err));
}

function initHeader(scope) {
  const menuToggle = scope.querySelector("#menuToggle");
  const menuIcon   = scope.querySelector("#menuIcon");
  const mobileMenu = scope.querySelector("#mobileMenu");

  if (!menuToggle || !menuIcon || !mobileMenu) return;

  // Toggle open/close
  menuToggle.addEventListener("click", () => {
    mobileMenu.classList.toggle("hidden");
    menuIcon.classList.toggle("fa-bars");
    // Font Awesome 6 close icon:
    menuIcon.classList.toggle("fa-xmark");
  });

  // Close when a link is clicked
  scope.querySelectorAll("#mobileMenu a").forEach((link) => {
    link.addEventListener("click", () => {
      mobileMenu.classList.add("hidden");
      menuIcon.classList.add("fa-bars");
      menuIcon.classList.remove("fa-xmark");
    });
  });
}

function loadFooter() {
  fetch("components/footer.html")
    .then((res) => res.text())
    .then((html) => {
      document.getElementById("footer").innerHTML = html;
      // Only run Lucide if it's actually loaded
      if (window.lucide && typeof lucide.createIcons === "function") {
        lucide.createIcons();
      }
    })
    .catch((err) => console.error("Error loading footer:", err));
}
