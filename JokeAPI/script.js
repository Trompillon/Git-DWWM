fetch("https://v2.jokeapi.dev/joke/Any?lang=fr&type=single", {
  })
    .then(response => response.json())
    .then(data => {
        console.log(data);
    })
    .catch(error => console.log("error", error));

const language = document.getElementById("language");
const category = document.getElementById("category");
const type = document.getElementById("type");
const exclude = document.querySelectorAll('input[type="radio"][name="exclude"]')
const joketype = document.getElementById("joketype");

language.addEventListener("change", (event) => {
let choiceLanguage = (event.target.value);
})

category.addEventListener("change", (event) => {
let choiceCategory = (event.target.value);
})