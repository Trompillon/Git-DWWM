// async function afficherChats() {
//   const reponse = await fetch("https://www.thecatapi.com/");
//   const chats = await reponse.json();
//   console.log(chats);
// }

// const headers = new Headers({
//   "Content-Type": "application/json",
//   "x-api-key": "DEMO-API-KEY"
// });

// let requestOptions = {
//   method: 'GET',
//   headers: headers,
//   redirect: 'follow'
// };

// function afficherChats() {
// fetch("https://api.thecatapi.com/v1/images/search?size=med&mime_types=jpg&format=json&has_breeds=true&order=RANDOM&page=0&limit=1", requestOptions)
//     .then(response => response.json())
//     .then(result => console.log(result))
//     .catch(error => console.log('error', error));        
// }

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




