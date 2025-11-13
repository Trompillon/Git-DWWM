let button = document.getElementById("apiCatcher");
let img = document.getElementById("catImage");

button.addEventListener("click", () => {
  fetch("https://api.thecatapi.com/v1/images/search?limit=1", {
    headers: { "x-api-key": "DEMO-API-KEY" }
  })
    .then(response => response.json())
    .then(data => {
        img.src = data[0].url;
        console.log(data);
    })
    .catch(error => console.log("error", error));
});




