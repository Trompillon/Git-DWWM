<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>exoFetch2</title>
</head>
<body>

    <input type="search" id="search" placeholder="Taper votre recherche ici">
    <div= id="result"></div>

    <script>

        const result = document.getElementById("result");
        const search = document.getElementById("search");

        search.addEventListener("input", ()=>{

        const searchTerm = search.value;

            if(searchTerm.length > 0){
        
            fetch("getActors.php?searchWord="+ encodeURIComponent(searchTerm) +"")
            .then(function(response){
                if(response.ok){
                    return response.json();
                }
                throw new Error("ca marche pas")
            })

            .then(function(data) {

                result.innerHTML = "";

                console.log(data);

                if (data.length === 0)
                    result.innerHTML += `<p> Y'a pas !</p>`;

                else
                data.forEach(actor => {
                result.innerHTML += `<p>${actor.first_name}</p>` + `<p>${actor.last_name}</p>` + `<p>${actor.actor_id}</p>`;
                

            });
        })
    }
});

    </script>
    
</body>
</html>