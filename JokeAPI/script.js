fetch("https://v2.jokeapi.dev/joke/Any?lang=fr&type=single", {
  })
    .then(response => response.json())
    .then(data => {
        console.log(data);
    })
    .catch(error => console.log("error", error));

let language = document.getElementById("language");

language.addEventListener("change", (event) => {
console.log(event.target.value);
})