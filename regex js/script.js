const user = document.getElementById("user")
const mail = document.getElementById("mail")
const psw = document.getElementById("psw")
const submitBtn = document.getElementById("submit");

const regexUser = /^[a-zA-Z0-9_]{3,16}$/;
const regexMail = /^[a-zA-Z]+\.[a-zA-Z]+@[a-zA-Z]+\.[a-zA-Z]{2,4}$/i;
const regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{};:'",.<>\/?\\|`~]).{8,}$/;

function validateInput(input, regex) {
  input.addEventListener("input", () => {
    if (regex.test(input.value)) {
      input.classList.add("valid");
      input.classList.remove("invalid");
    } else {
      input.classList.add("invalid");
      input.classList.remove("valid");
    }
  });
}

validateInput(user, regexUser);
validateInput(mail, regexMail);
validateInput(psw, regexPassword);

// submitBtn.addEventListener("click", ()=> {

//     const userValue = user.value;
//     const emailValue = mail.value;
//     const passwordValue = psw.value;

//     if (!regexUser.test(userValue)) {
//         alert("Nom d'utilisateur invalide !");
//         return;
//     }

//     if (!regexMail.test(emailValue)) {
//         alert("Email invalide !");
//         return;
//     }

//     if (!regexPassword.test(passwordValue)) {
//         alert("Mot de passe invalide !");
//         return;
//     }

//     alert("Tout est valide ! Formulaire prêt à être envoyé.");
// });