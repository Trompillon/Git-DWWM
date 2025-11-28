<!-- 🧠 Exercice : Générateur de combinaisons de score au rugby

Écrire une fonction estimateScore(int $score) qui retourne toutes les combinaisons possibles permettant d’obtenir exactement ce score lors d’un match de rugby.
Une combinaison est définie par :

Essai : 5 points

Transformation : 2 points (uniquement s’il y a eu au moins 1 essai)

Pénalité : 3 points

La fonction doit tester toutes les possibilités réalistes et retourner les solutions sous la forme :
nbEssais | nbTransformations | nbPénalités
echo estimateScore(7);
1 1 0
estimateScore(8);
1 0 1
estimateScore(21);
0 0 7 | 2 1 3 | 3 0 2 | 3 3 0

Les transformations ne peuvent pas dépasser le nombre d’essais.

Il faut examiner toutes les possibilités sans dépasser le score.

Retourner un string contenant toutes les combinaisons possibles. -->

<?php

    function estimateScore(int $score) {

        foreach ($score as ) {
            
        }

        $points = 1;
        $essai = $points*5;
        $penalite = $points*3;
        $essaiValide = boolean;

        if ($essaiValide = true) {
                $penalite = $points*2;
        }
            else {
                $penalite = $points*0;
            }

    }

    echo estimateScore(8);

?>

