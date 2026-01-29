<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>EcfAjax</title>
</head>
<body>

<h1>Faites votre recherche</h1>
    
<input type="search" id="search" placeholder="Recherche par nom ou prénom">
<div id="result"></div>

</body>

<script defer>
    
const search = document.getElementById("search");
const result = document.getElementById("result");

search.addEventListener("input", ()=>{

    const searchTerm = search.value;

    if(searchTerm.length > 1){
        
            fetch("getData.php?searchWord="+ encodeURIComponent(searchTerm) +"")
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
                data.forEach(user => {
                result.innerHTML += `<p>${user.first_name}</p>` + `<p>${user.last_name}</p>` + `<p>${user.phone}</p>` + `<p>${user.email}</p>` + `<p>${user.address}</p>` + `<img src="${user.picture_url}">` + `<hr>`;
            });
        });
    }
});

</script>
</html>