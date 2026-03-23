document.addEventListener("DOMContentLoaded", function () {
    const themeLink = document.getElementById("theme-style");
    const toggleBtn = document.getElementById("theme-toggle");

    // Safety check (prevents errors if elements don't exist)
    if (!themeLink || !toggleBtn) return;

    // Load saved theme
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme) {
        themeLink.href = savedTheme;
    }

    // Toggle theme on button click
    toggleBtn.addEventListener("click", (e) => {
        e.preventDefault(); // prevents page jump (IMPORTANT)

        const current = themeLink.getAttribute("href");

        if (current === "/css/light.css") {
            themeLink.href = "/css/dark.css";
            localStorage.setItem("theme", "/css/dark.css");
        } else {
            themeLink.href = "/css/light.css";
            localStorage.setItem("theme", "/css/light.css");
        }
    });
});