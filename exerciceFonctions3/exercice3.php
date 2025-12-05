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

Pour chaque nombre possible d’essais,
pour chaque nombre possible de transformations associé à ce nombre d’essais,
et pour chaque nombre possible de pénalités,
on calcule le total de points et on garde la combinaison si le total correspond exactement au score demandé.




<?php

    function estimateScore(int $score) {

        
            $tableauEssais = "";
            $tableauPenalites = "";
            $tableauTransformation = "";

        foreach ($nbEssais as $psbltEssai) {
            $tableauEssais .= $psbltEssai;

            foreach ($nbTransformations as $psbltTransfo) {
                $tableauTransformation .= $psbltTransfo;
            }

        }

        foreach ($nbPenalites as $psltPenalites) {
            $tableauPenalites .= $psbltPenalites;
        }


        // $psbltEssai = (int $score)/5;
        // $psbltTransfo = 

        // $nbEssais = $score/5;
        // $nbPenalites = $score/3;
        // $nbTransformations = $score/2;

        return $score = "$nbEssais | $nbTransformations | $nbPenalites"


        // $score = $nbEssais + $nbTransformations + $nbPénalités;
        // $calcul = implode(",", );

        // $points = 1;
        // $essai = $points*5;
        // $penalite = $points*3;
        // $essaiValide = boolean;
        // $transformation = boolean;

        // if ($essaiValide = true) {
        //     .= $points*5;
        // }

        // if ($essaiValide = false) {
        //     $transformation = false;
        // }

        // if ($transformation = true)
        //     .= $points*2;
        // else {
        //     .= $points+0;
        // }

        // if ($essaiValide = true) {
        //     $transformation = true or false;
        // }

    }

    echo estimateScore(8);

?>

