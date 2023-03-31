const radioButtons = document.querySelectorAll('input[name="themeToggle"]');
const body = document.querySelector('body');

const currentTheme = localStorage.getItem('theme');
if (currentTheme) {
    for (let i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].value === currentTheme) {
            radioButtons[i].checked = true;
            body.classList.add(currentTheme);
        } else {
            radioButtons[i].checked = false;
            body.classList.remove(radioButtons[i].value);
        }
    }
}

function switchTheme(e) {
    const selectedTheme = document.querySelector('input[name="themeToggle"]:checked').value;
    body.classList.remove('light-mode', 'dark-mode');
    body.classList.add(selectedTheme);
    localStorage.setItem('theme', selectedTheme);
}

for (let i = 0; i < radioButtons.length; i++) {
    radioButtons[i].addEventListener('change', switchTheme, false);
}
