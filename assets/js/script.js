const themeToggle = document.getElementById('themeToggle');

let isDarkMode = false;

themeToggle.addEventListener('click', () => {
    if (!isDarkMode) {
        document.documentElement.style.setProperty('--background', 'var(--dark-mode-background)');
        document.documentElement.style.setProperty('--font-primary', 'var(--dark-mode-font)');
        document.documentElement.style.setProperty('--highlight1', '#F2CC8F');
        themeToggle.textContent = 'Switch to Light Mode';
    } else {
        document.documentElement.style.setProperty('--background', '#F4F1DE');
        document.documentElement.style.setProperty('--font-primary', '#3D405B');
        document.documentElement.style.setProperty('--highlight1', '#E07A5F');
        themeToggle.textContent = 'Switch to Dark Mode';
    }
    isDarkMode = !isDarkMode;
});
