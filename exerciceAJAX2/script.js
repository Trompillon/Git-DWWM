const btn = document.getElementById("btn");
const table = document.getElementById("table");
const tbody = table.querySelector("tbody");

btn.addEventListener("click", () => {
    fetch("https://randomuser.me/api/")
        .then(response => response.json())
        .then(data => {
            tbody.innerHTML = "";

            data.results.forEach(user => {
                const tr = document.createElement("tr");

                const tdNom = document.createElement("td");
                tdNom.textContent = user.name.last;
                tr.appendChild(tdNom);

                const tdPrenom = document.createElement("td");
                tdPrenom.textContent = user.name.first;
                tr.appendChild(tdPrenom);

                const tdPhone = document.createElement("td");
                tdPhone.textContent = user.phone;
                tr.appendChild(tdPhone);

                const tdEmail = document.createElement("td");
                tdEmail.textContent = user.email;
                tr.appendChild(tdEmail);

                const tdAdresse = document.createElement("td");
                tdAdresse.textContent = `${user.location.street.number} ${user.location.street.name}, ${user.location.city}`;
                tr.appendChild(tdAdresse);

                const tdPhoto = document.createElement("td");
                const img = document.createElement("img");
                img.src = user.picture.thumbnail;
                img.alt = "Photo profil";
                tdPhoto.appendChild(img);
                tr.appendChild(tdPhoto);

                tbody.appendChild(tr);
            });
        })
        .catch(error => console.error(error));
});

const submit = document.getElementById("submit");

submit.addEventListener("click", () => {
    const numberValue = document.getElementById("number").value;
    fetch('getData.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'number='  + encodeURIComponent(numberValue)
    })

    .then(response => response.text())
        .then(data => alert(data))
        .catch(err => alert('Erreur : ' + err));
})