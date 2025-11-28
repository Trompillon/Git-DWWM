<!-- 🧠 Exercice : générateur de message d’utilisateur

Créer une fonction creerMessageUtilisateur qui prend 5 arguments, chacun d’un type différent :

string : $nom

int : $age

bool : $premium

float : $solde

array : $centresInteret

La fonction doit retourner une phrase personnalisée comme :

Bonjour Thomas, vous avez 29 ans.
Votre compte est premium / gratuit.
Votre solde est de 42.50€.
Vos centres d’intérêt sont : jeux vidéo, cinema, sport.
et la meme en JS -->

<?php

    function creerMessageUtilisateur (string $nom, int $age, bool $premium, float $solde, array $centresInteret) {

        if ($premium = true) {
            $premium = "premium";
        }
        else {
            $premium = "gratuit";
        }

        $list = implode(", ", $centresInteret);

        // $list = "";

        //     foreach ($centresInteret as $ci) {
        //     $list .= $ci;
        //     }

        $soldeFormat = number_format($solde, 2);

        return '<p>Bonjour '.$nom.', vous avez '.$age.' ans. Votre compte est ' .$premium. '. Votre solde est de ' .$soldeFormat.' €. Vos centres d\'intérêt sont : ' .$list.'.</p>';
    }

    echo creerMessageUtilisateur ("Thomas", 29, true, 42.50,["jeux vidéos", "cinéma", "sport"]);

?>