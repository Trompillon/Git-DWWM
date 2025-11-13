/**
* Fonction principale pour effectuer le chiffrement ou le déchiffrement de César.
* @param {string} texte - Le texte à traiter (clair ou chiffré).
* @param {number} cle - La clé de décalage.
* @param {boolean} chiffrer - True pour chiffrer, False pour déchiffrer.
* @returns {string} - Le texte résultant.
*/
function chiffrerCesar(texte, cle, chiffrer) {
    // Convertir le texte en majuscules pour simplifier (la clé ne s'applique qu'aux lettres).
    let resultat = "";
    
    // Si on veut déchiffrer, on utilise une clé négative (décalage inverse)
    const decalage = chiffrer ? cle : -cle; 
    
    // Assure que le décalage reste dans l'alphabet (26 lettres)
    const cleModulee = (decalage % 26 + 26) % 26; 
    
    for (let i = 0; i < texte.length; i++) {
        const caractere = texte[i];
        const codeASCII = caractere.toUpperCase().charCodeAt(0);
        
        // Traiter uniquement les lettres de A (65) à Z (90)
        if (codeASCII >= 65 && codeASCII <= 90) {
            // Calculer l'indice de la lettre (0 pour A, 25 pour Z)
            const indexOriginal = codeASCII - 65;
            
            // Appliquer le décalage et gérer le "retour à la ligne" (modulo 26)
            let nouvelIndex = (indexOriginal + cleModulee) % 26;
            
            // Calculer le nouveau code ASCII
            const nouveauCodeASCII = nouvelIndex + 65;
            
            // Ajouter la nouvelle lettre
            resultat += String.fromCharCode(nouveauCodeASCII);
        } else {
            // Conserver les espaces, chiffres, ponctuations, etc. tels quels
            resultat += caractere;
        }
    }
    
    return resultat;
}

// --- Événements et Logique de l'Interface ---

// Récupération des éléments du DOM
const inputTexteACoder = document.getElementById('texteACoder');
const inputTexteADecoder = document.getElementById('texteADecoder');
const inputCle = document.getElementById('cle');
const inputResultat = document.getElementById('resultat');
const boutonCoder = document.getElementById('coder');
const boutonDecoder = document.getElementById('decoder');


// Fonction pour gérer le Codage (Chiffrement)
boutonCoder.addEventListener('click', () => {
    const texte = inputTexteACoder.value.trim();
    const cle = parseInt(inputCle.value, 10);
    
    if (texte && !isNaN(cle)) {
        const texteChiffre = chiffrerCesar(texte, cle, true); // true = chiffrer
        inputResultat.value = texteChiffre;
    } else {
        inputResultat.value = "Veuillez entrer le texte et une clé valide.";
    }
});


// Fonction pour gérer le Décodage (Déchiffrement)
boutonDecoder.addEventListener('click', () => {
    const texteChiffre = inputTexteADecoder.value.trim();
    const cle = parseInt(inputCle.value, 10);
    
    if (texteChiffre && !isNaN(cle)) {
        const texteClair = chiffrerCesar(texteChiffre, cle, false); // false = déchiffrer
        inputResultat.value = texteClair;
    } else {
        inputResultat.value = "Veuillez entrer le texte chiffré et une clé valide.";
    }
});


// Initialiser la clé par défaut si elle est vide au chargement
document.addEventListener('DOMContentLoaded', () => {
    if (!inputCle.value) {
        inputCle.value = '3'; // Clé par défaut
    }
});


// /**
//  * Returns the letter position in the alphabet
//  *
//  * @param {string} letter - A letter to transform
//  * @return {number} number - The position in the alphabet
//  */
// function letterToNumber(letter) {
//   return parseInt(letter, 36) - 9;
// }

// const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("");

// /**
//  * Returns if the letter is in the alphabet
//  *
//  * @param {string} letter - A letter to transform
//  * @return {boolean} true if the letter is present in the alphabet
//  */
// function isLetterInAlphabet(letter) {
//   return alphabet.includes(letter.toUpperCase());
// }

// /**
//  * Returns the letter position in the alphabet
//  *
//  * @param {string} letter - A letter to transform
//  * @return {number} number - The position in the alphabet
//  */
// function letterToNumber(letter) {
//   if (!isLetterInAlphabet(letter)) {
//     return false;
//   }

//   return alphabet.indexOf(letter.toUpperCase()) + 1;
// }

// /**
//  * Returns the shifted letter of an offset in the alphabet
//  *
//  * @param {string} letter
//  * @param {number} offset
//  * @return {number} The shifted letter
//  */
// function shiftLetter(letter, offset) {
//   if (!isLetterInAlphabet(letter)) {
//     return letter;
//   }

//   return numberToLetter(letterToNumber(letter) + offset);
// }

// /**
//  * Returns the message encoded with the Caesar cipher, the offset depends on key
//  *
//  * @param {string} message
//  * @param {number} key
//  * @param {boolean} isDecoding - true to decode instead of encode
//  * @return {string} The encoded message
//  */
// function encodeCaesar(message, key, isDecoding) {
//   return message
//     .split("")
//     .map(function(letter) {
//       if (!isLetterInAlphabet(letter)) {
//         return letter;
//       }

//       return shiftLetter(letter, isDecoding ? -key : key);
//     })
//     .join("");
// }

