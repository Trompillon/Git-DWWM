
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


    function calculerPrixFinal (prixInitial, tauxReduction, tauxTVA, arrondir) {

        let resultat = prixInitial - (prixInitial* (tauxReduction/100));
        let resultatTVA = resultat + (resultat * (tauxTVA/100));
        let result
        if (arrondir) {
            return result = Math.round(resultatTVA)
        }
         return result = resultatTVA
    }

    console.log(calculerPrixFinal(100, 20, 5, true));


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