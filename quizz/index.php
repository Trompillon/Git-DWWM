<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Super Quizz</title>
</head>
<body>
    
    <h1>Super quizz en ligne !!</h1>

    <h2>Le principe est simple : vous allez répondre à une série de questions de difficulté variable : simple, moyenne ou difficile. Pour chaque question, vous pouvez choisir entre quatre propositions.</h2>
    <h2>Bonne chance !</h2>

    <div id="result"></div>

    <div id="answer"></div>

    <script>
        
        let result = document.getElementById("result");

        fetch("getQuestions.php")
        .then(function(response){
                if(response.ok){
                    return response.json();
                }
                throw new Error("ca marche pas")
            })

        .then(function(data) {

            result.innerHTML = `
        
        <div class="quizz">

            <h3> Catégorie ${data.theme}</h3>

            <h3>${data.question}</h3>

            <p> ${data.difficulty}</p>

            <button classe="button">${data.bonne_reponse}</button>

            <button classe="button">${data.mauvaise_reponse1}</button>

            <button classe="button">${data.mauvaise_reponse2}</button>

            <button classe="button">${data.mauvaise_reponse3}</button>

        </div>
    
        `;

        const answers = [
            data.bonne_reponse,
            data.mauvaise_reponse1,
            data.mauvaise_reponse2,
            data.mauvaise_reponse3,
        ];

        let button = document.querySelectorAll("button");
        button.addEventListener("click", () => { 
            
           
        })

        })

    </script>

</body>
</html>

