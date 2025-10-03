// On récupère le bouton grâce à son id
const bouton = document.getElementById("switchColor");

// On teste avec un petit message dans la console
console.log("Le bouton existe", bouton);

function getRandomColor() {
  // Math.random() donne un nombre entre 0 et 1
  // On multiplie par 16777215 (0xFFFFFF en décimal)
  // pour obtenir toutes les couleurs possibles en hex
  const hex = Math.floor(Math.random() * 16777215)
                .toString(16)          // conversion en hexadécimal
                .padStart(6, '0');     // ajoute des 0 devant si nécessaire
  return '#' + hex;              // retourne une couleur au format #RRGGBB
}

bouton.addEventListener('click', () => {
    const couleur = getRandomColor();           // génère une couleur aléatoire
    document.body.style.backgroundColor = couleur; // applique la couleur au fond
    console.log(document.body.style.backgroundColor)
    console.log(12 + 5)
    console.log(5 * 4)
    console.log(50 / 5)
    console.log(20 - 5)
});

