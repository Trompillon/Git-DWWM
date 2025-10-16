// let outputDiv = document.getElementById("output");

// let button = document.getElementById("myButton"); // Récupère le bouton
// button.addEventListener("click", () => { // Ajoute un événement au clic
//     outputDiv.innerHTML = `<p> Quelle est la différence entre un tas de bébés morts et une ferrari ?</p>`;
// button.addEventListener("click", () => {
//     outputDiv.innerHTML = `<p> J'ai pas de ferrari dans mon garage </p>`;
// })});

let outputDiv = document.getElementById("output");

let tableau1 = [
  "Un marsouin énervé",
  "Bernard Henri Levy",
  "Vladimir Poutine",
  "Clément le délégué",
  "Tiboinshape",
  "Godzilla",
  "Nicolas Sarkozy",
  "Jimmy le kangourou",
  "Gérard Depardieu",
];
let tableau2 = [
  "chante du Kendji Girac",
  "fait une déclaration d'amour",
  "fait du surf",
  "récite du baudelaire",
  "mange une banane",
  "conduit un karting",
  "fait un calin",
  "boit du champagne",
  "prends de la coke",
];
let tableau3 = [
  "à Acapulco",
  "dans le froid glacial du Groënland",
  "dans la cave de Julien",
  "dans une boite gay à San Francisco",
  "au milieu de l'océan",
  "dans un salon de massage",
  "chez les Verdunois",
  "dans un tripot de Bangkok",
  "avec les ch'tis à Mykonos",
];

// let button = document.getElementById("myButton");
// button.addEventListener("click", () => {
//     outputDiv.innerHTML = `<p>${getRandomElement(tableau1)}</p>`;
//     outputDiv.innerHTML += `<p>${getRandomElement(tableau2)}</p>`;
//     outputDiv.innerHTML += `<p>${getRandomElement(tableau3)}</p>`;
//     });

// // // --- 6. Les tableaux ---
// let fruits = ["Pomme", "Banane", "Orange"]; // Déclare un tableau
//     outputDiv.innerHTML += `<p>Deuxième fruit: ${fruits[1]}</p>`; // Affiche le deuxième élément du tableau

// let outputDiv = document.getElementById("output"); // Récupère l'élément HTML avec l'ID "output"
//     outputDiv.innerHTML += `<p>Bonjour, je m'appelle ${prenom} ${nom} et j'ai ${age + 5} ans.</p>`;

//   const hex = Math.floor(Math.random() * 16777215)

// // // --- 12. Les chaînes de caractères ---
// let greeting = "Bonjour, " + prenom + " " + nom; // Concaténation de chaînes
// outputDiv.innerHTML += `<p>${greeting}</p>`; // Affichage du message de salutation

let clics = 1;
let button = document.getElementById("myButton");
button.addEventListener("click", () => {
  let index = Math.floor(Math.random() * tableau1.length);
  let choix1;

  switch (index) {
    case 0:
      choix1 = tableau1[0];
      break;
    case 1:
      choix1 = tableau1[1];
      break;
    case 2:
      choix1 = tableau1[2];
      break;
    case 3:
      choix1 = tableau1[3];
      break;
    case 4:
      choix1 = tableau1[4];
      break;
    case 5:
      choix1 = tableau1[5];
      break;
    case 6:
      choix1 = tableau1[6];
      break;
    case 7:
      choix1 = tableau1[7];
      break;
    case 8:
      choix1 = tableau1[8];
      break;
  }

  let index2 = Math.floor(Math.random() * tableau2.length);
  let choix2;

  switch (index2) {
    case 0:
      choix2 = tableau2[0];
      break;
    case 1:
      choix2 = tableau2[1];
      break;
    case 2:
      choix2 = tableau2[2];
      break;
    case 3:
      choix2 = tableau2[3];
      break;
    case 4:
      choix2 = tableau2[4];
      break;
    case 5:
      choix2 = tableau2[5];
      break;
    case 6:
      choix2 = tableau2[6];
      break;
    case 7:
      choix2 = tableau2[7];
      break;
    case 8:
      choix2 = tableau2[8];
      break;
  }

  let index3 = Math.floor(Math.random() * tableau3.length);
  let choix3;

  switch (index3) {
    case 0:
      choix3 = tableau3[0];
      break;
    case 1:
      choix3 = tableau3[1];
      break;
    case 2:
      choix3 = tableau3[2];
      break;
    case 3:
      choix3 = tableau3[3];
      break;
    case 4:
      choix3 = tableau3[4];
      break;
    case 5:
      choix3 = tableau3[5];
      break;
    case 6:
      choix3 = tableau3[6];
      break;
    case 7:
      choix3 = tableau3[7];
      break;
    case 8:
      choix3 = tableau3[8];
      break;
  }

  switch (clics) {
    case 1:
      outputDiv.innerHTML = `<p> ${choix1}</p>`;
      clics++;
      break;
    case 2:
      outputDiv.innerHTML += `<p> ${choix2}</p>`;
      clics++;
      break;
    case 3:
      outputDiv.innerHTML += `<p> ${choix3}</p>`;
      clics++;
      break;
  }
  if (clics > 3) {
    clics = 1;
  }
});

// let button = document.getElementById("myButton");
// button.addEventListener ("click", () => {
//     outputDiv.innerHTML = `<p> ${choix1}</p>`;
// button.addEventListener("click", () => {
//     outputDiv.innerHTML += `<p> ${choix2}</p>`;
// button.addEventListener("click", () => {
//     outputDiv.innerHTML += `<p> ${choix3}</p>`;
// })})});
