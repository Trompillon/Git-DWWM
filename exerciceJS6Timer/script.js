let temps = 0;

let intervalId = null;

let outputDiv = document.getElementById("output");

const timerElement = document.getElementById("timer");

let button = document.getElementById("startTimer");
button.addEventListener("click", () => {
    intervalId = setInterval(() => {
        let minutes = parseInt(temps / 60, 10);
        let secondes = parseInt(temps % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        secondes = secondes < 10 ? "0" + secondes : secondes;

        timerElement.innerText = `${minutes}:${secondes}`;
        if (temps <= 0) {
            temps = 1;
        } else {
        temps = temps + 1;
        }
        if (temps >= 11 && temps <= 11) {
            outputDiv.innerHTML += `<p>Vous avez attendu 10 secondes !</p>`;
            let audio = new Audio("win.mp3");
            audio.play();
        }
    }, 1000);
})

// temps = temps <= 0 ? 1 : temps + 1;

document.getElementById("stopTimer").addEventListener("click", () => {
    clearInterval(intervalId);
    intervalId = null;
});

document.getElementById("resetTimer").addEventListener("click", () => {
    clearInterval(intervalId);
    intervalId = null;
    temps = 0;
    timerElement.innerText = "00:00";
});