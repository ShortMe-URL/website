// Toggle active class for navbar
document.getElementById("nav_btn")?.addEventListener("click", () => {
    document.querySelector("nav .container .list")?.classList.toggle("active");
});

// Theme switcher
const themeSwitcher = document.getElementById("theme-switcher");
themeSwitcher?.addEventListener("click", () => {
    const isDark = themeSwitcher.classList.contains("dark");
    setCookie("theme", isDark ? "dark" : "light", 1);
    updateTheme();
});

function updateTheme() {
    const theme = getCookie("theme");
    const icon = themeSwitcher.querySelector("i");
    const isDark = theme === "dark";
    
    themeSwitcher.classList.toggle("dark", !isDark);
    themeSwitcher.classList.toggle("light", isDark);
    icon.classList.toggle("fa-moon-stars", !isDark);
    icon.classList.toggle("fa-sun", isDark);
    document.body.classList.toggle("dark", isDark);
}

function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
    document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/`;
}

function getCookie(name) {
    const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    return match ? match[2] : "";
}

updateTheme();