// let nombre = 0;

// let outputDiv = document.getElementById("output");

// let button = document.getElementById("bouton");
// button.addEventListener("click", () => {
//     nombre++
//     outputDiv.innerHTML = `<p>Le bouton a été cliqué ${nombre} fois.</p>`;
// });

let outputDiv = document.getElementById("output");

let alphabet = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"]

let button = document.getElementById("bouton");
button.addEventListener("click", () => {
        outputDiv.innerHTML = '';
alphabet.forEach(lettre => {
    outputDiv.innerHTML += `<p>${lettre}</p>`;
});
});