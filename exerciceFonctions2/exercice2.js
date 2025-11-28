// 🧠 Exercice : générateur de message d’utilisateur

// Créer une fonction creerMessageUtilisateur qui prend 5 arguments, chacun d’un type différent :

// string : $nom

// int : $age

// bool : $premium

// float : $solde

// array : $centresInteret

// La fonction doit retourner une phrase personnalisée comme :

// Bonjour Thomas, vous avez 29 ans.
// Votre compte est premium / gratuit.
// Votre solde est de 42.50€.
// Vos centres d’intérêt sont : jeux vidéo, cinema, sport.
// et la meme en JS 


function creerMessageUtilisateur (nom,age,premium,solde,centresInteret) {

    if (premium == true) {
        premium = "premium";
    }
    else {
        premium = "gratuit";
    }

    let list = []

    centresInteret = ["jeux vidéos", "cinéma", "sport"];

    centresInteret.forEach( ci => {

        list += ci + ", ";

    })

    return `Bonjour ${nom}, vous avez ${age} ans. Votre compte est ${premium}. Votre solde est de ${solde.toFixed(2)}€. Vos centres d\'intérêt sont : ${list}`;

}

console.log (creerMessageUtilisateur ("Thomas", 29, false, 42.50, []))


