const language = document.getElementById("language");
const category = document.getElementById("category");
const type = document.getElementById("type");
const exclude = document.querySelectorAll('input[type="checkbox"][name="exclude"]')
const jokenumber = document.getElementById("jokenumber");

const result = document.querySelector(".mainContainer");

const jokes = document.getElementById("jokes");

let choiceLanguage = "en";
let choiceCategory = "Any";
let choiceType = "single";
let choiceExclude = [];
let choicejokenumber = 1;

language.addEventListener("change", (event) => {
choiceLanguage = (event.target.value);
})

category.addEventListener("change", (event) => {
choiceCategory = (event.target.value);
})

type.addEventListener("change", (event) => {
choiceType = (event.target.value);
})

exclude.forEach(checkbox => {
  checkbox.addEventListener("change", () => {
    choiceExclude = [];
    exclude.forEach(cb => {
      if (cb.checked) {
        choiceExclude.push(cb.value);
      }
    });
  });
});

jokenumber.addEventListener("change", (event) => {
choicejokenumber = Number (event.target.value);
})

jokes.addEventListener("click", () => {
  let url = "https://v2.jokeapi.dev/joke/Any";

  let filters = { language: choiceLanguage, category: choiceCategory, type: choiceType, exclude: choiceExclude, jokenumber: choicejokenumber }

    if (filters.category && filters.category !== "Any") {
    url = `https://v2.jokeapi.dev/joke/${filters.category}`;
  } else {
    url = "https://v2.jokeapi.dev/joke/Any";
  }

  url += `?lang=${filters.language}&type=${filters.type}`;

  if (filters.jokenumber> 1) {
    url += `&amount=${filters.jokenumber}`;
  }

  if (filters.exclude.length > 0) {
  url += `&blacklistFlags=${filters.exclude.join(",")}`;
  }

  console.log(url);

  fetch(url, {
    })
      .then(response => response.json())
      .then(data => {
        result.innerHTML = "";

        if (data.jokes) {
          data.jokes.forEach(joke => {
            if (joke.type === "single") {
              result.innerHTML += `<p>${joke.joke}</p>`;
            } else {
              result.innerHTML += `<p>${joke.setup} . ${joke.delivery}</p>`;
            }
          });
        } else {
          if (data.type === "single") {
            result.innerHTML = `<p>${data.joke}</p>`;
          } else {
            result.innerHTML = `<p>${data.setup} . ${data.delivery}</p>`;
          }
        }
          
      })
      .catch(error => console.log("error", error));
  })
