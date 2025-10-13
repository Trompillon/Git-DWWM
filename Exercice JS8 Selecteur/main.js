const firstList = document.getElementById('firstList');   //* liste de départ
const secondList = document.getElementById('secondList'); // liste d'arrivée
const button = document.getElementById('myButton');

// on crée un tableau avec tous les éléments de la première liste
let remaining = Array.from(firstList.children);

button.addEventListener('click', () => {
    if (remaining.length === 0) return; // plus d'éléments à choisir

    // choisir un index au hasard
    const index = Math.floor(Math.random() * remaining.length);
    const chosen = remaining.splice(index, 1)[0]; // retirer de remaining

    firstList.removeChild(chosen);      // enlever de la première liste
    secondList.appendChild(chosen);     // ajouter à la deuxième liste
});