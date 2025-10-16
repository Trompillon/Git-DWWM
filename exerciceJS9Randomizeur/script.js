const list = document.getElementById("list");
const button = document.getElementById("relance");

function nbrPremier(nbr) {
  // 1 n'est pas premier
  if (nbr <= 1) {
    return false;
  }
  // Seuls les nombres >= 2 sont testés
  // Il suffit de tester jusqu'à la racine carrée du nombre
  for (let i = 2; i * i <= nbr; i++) {
    if (nbr % i === 0) {
      return false; // Trouvé un diviseur, donc ce n'est pas premier
    }
  }
  return true; // Aucun diviseur trouvé, c'est premier
}

button.addEventListener('click', () => {

    list.innerHTML = '';

    for (let i = 1; i <= 10; i++) { // Boucle for qui affiche 10 itérations
        let number = Math.floor(Math.random() * 9999) + 1;
        
        if (number <= 5000 && number % 4 === 0) {
            list.innerHTML += `<p style="color: red;"> ${number} </p>`;
        } 
        else if (number % 2 === 1) {
            list.innerHTML += `<p style="color: green;"> ${number} </p>`;
        }
        else if (nbrPremier(number)) {
            list.innerHTML += `<p style="color: blue;"> ${number} </p>`;
        }
        else {
            list.innerHTML += `<p> ${number} </p>`;
        }
    } 
}); 

// function nbrPremier(nbr) {
//   for(let i = 2; i < nbr; i++)
//     if(nbr%i === 0) return false;
//   return nbr > 1;
// }

// console.log(nbrPremier(2));

// if(nbr%2 == 0)
//               {
//                      alert("Nombre pair");
//               }
//               else
//               {
//                      alert("Nombre impair");
//               }

// if (number <= 5000 && number % 4 === 0) {
//     document.getElementById('list').style.color = 'red';
// } else {
    
// }

//     if (number <= 5000 && % 4 === 0) {;
//     list.style.color = 'red';
// } else {
//     ;
// }

    // if (number <= 5000 && % 4 === 0) {;
    //     function changecouleur(couleur) {
    //     document.getElementById('list').style.color = red;
    // } else {
    //     ;
    // }


//     if (number <= 5000 && % 4 === 0) {;
//     list.style.color = 'red';
// } else {
//     ;
// }

// if (age >= 18) { // Vérifie si la personne est majeure ou mineure
//     outputDiv.innerHTML += `<p>Vous êtes majeur.</p>`;
// } else {
//     outputDiv.innerHTML += `<p>Vous êtes mineur.</p>`;
// }

//     function changecouleur(couleur) {
//     document.getElementById('list').style.color = red;
// }