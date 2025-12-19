const switchButton = document.getElementById("switch");

const html = document.documentElement;

// Au chargement de la page : restaurer le thème
const savedTheme = localStorage.getItem('theme');

if (savedTheme === 'dark') {
    html.classList.add('dark');
}

// Au clic : basculer le thème
switchButton.addEventListener('click', () => {
    html.classList.toggle('dark');

    if (html.classList.contains('dark')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.setItem('theme', 'light');
    }
});