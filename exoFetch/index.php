<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>ExoFetch</title>
</head>
<body>
    
<input type="search" id="search" placeholder="Taper votre recherche ici">
<div= id="result"></div>

</body>

<script defer>
    
const result = document.getElementById("result");
const search = document.getElementById("search");

search.addEventListener("input", ()=>{

    const searchTerm = search.value;

    if(searchTerm.length > 1){
        
            fetch("getIngredients.php?searchWord="+ encodeURIComponent(searchTerm) +"")
            .then(function(response){
                if(response.ok){
                    return response.json();
                }
                throw new Error("ca marche pas")
            })

            .then(function(data) {

                result.innerHTML = ""

                if (data.length === 0)
                    result.innerHTML += `<p> Y'a pas !</p>`;

                else
                data.forEach(ingredient => {
                result.innerHTML += `<p>${ingredient.IngredientNameFR}</p>`;
                

            });
        })
    }
});

</script>
</html>