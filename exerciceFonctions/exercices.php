<!-- 
// Crée une fonction qui prend 4 arguments :
// prixInitial (nombre)
// tauxReduction (nombre en %)
// tauxTVA (nombre en %)
// arrondir (booléen true ou false)
// La fonction doit :
// appliquer la réduction au prix,
// appliquer ensuite la TVA,
// et si arrondir est true, arrondir à 2 décimales,
// puis renvoyer le prix final.
// Test
echo calculerPrixFinal (100, 20, 5, true); // 84 -->


<?php


    // function calculerPrixFinal($prixInitial, $tauxReduction, $tauxTVA, $boolean) {
    // $pourcentage= ($prixInitial * $tauxReduction)/100 ;
    // $resultat= $prixInitial - $pourcentage;
    // $resultatTVA= $resultat + ($resultat * ($tauxTVA/100));
    // if ($boolean = true) {
    //     return round($resultatTVA);
    // }
    // else {
    //     return ($resultatTVA);                
    // }

    // }


    function calculerPrixFinal($prixInitial, $tauxReduction, $tauxTVA, $boolean) {
    $resultat= $prixInitial- ($prixInitial * ($tauxReduction/100)) ;
    $resultatTVA= $resultat + ($resultat * ($tauxTVA/100));
    if ($boolean = true) {
        $result = round($resultatTVA, 2);
    }
        return $result;                

    }

        echo calculerPrixFinal (100, 20, 5, true);

?>