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

    <button id="displayAnswers">Afficher/Cacher les réponses</button>

    <div id="answersContainer"></div>

    <button id="next">Question suivante</button>

    <script>
        
        let result = document.getElementById("result");
        let answersContainer = document.getElementById("answersContainer");
        let next = document.getElementById("next");

        function getFetch(){
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

            <h3> ${data.question}</h3>

            <h3> ${data.difficulty}</p>
    
        </div> `;

        const answers = [
            data.bonne_reponse,
            data.mauvaise_reponse1,
            data.mauvaise_reponse2,
            data.mauvaise_reponse3,
        ];

        shuffle(answers);

        function shuffle(array){
            for(let i= array.length - 1; i > 0; i--){
                const random = Math.floor(Math.random() * (i + 1));

                [array[i], array[random]] = [array[random], array[i]]
            }
        }

        const display = document.createElement("div");
            display.classList.add("display"); 

            answersContainer.innerHTML = "";

            answers.forEach(answer => {
                const btn = document.createElement("button");
                btn.classList.add("button");
                btn.textContent = answer;
                display.appendChild(btn);
            });

            answersContainer.appendChild(display);

        displayAnswers.addEventListener("click", () => {
            display.classList.toggle("visible");
        })

        let button = document.querySelectorAll(".button");
        button.forEach(btn => {

        btn.addEventListener("click", () => {
            if (btn.textContent === data.bonne_reponse) {
                result.innerHTML += `<p>Correct !</p>`;
                btn.style.backgroundColor = "#008000";
            }
            else {
                result.innerHTML += `<p>C'est perdu !</p>`;
                btn.style.backgroundColor = "#FF0000";
            }})

        })
        })
        }

        getFetch();

        next.addEventListener("click", () => {
            getFetch();

        })
    
    </script>

</body>
</html>

