const products = [
    {
        name: "Voyage sur la lune",
        price: "899,99 € Réduction 40%" ,
        priceT : "749,99€ avec le code Time4Fun",
        description: "Voyage et atterissage sur la lune avec SpaceX",
        image: "img/spaceX.jpg",
    },
    {
        name: "Massage",
        price: "59,99 € Réduction 30%",
        priceT : "49,99€ avec le code Time4Fun",
        description: "Un massage délicat proposé par Germaine",
        image: "img/massage.jpg",
    },
    {
        name: "Massage thai",
        price: "49,99 € Réduction 25%",
        priceT : "45,99€ avec le code Time4Fun",
        description: "Massage thai avec Anong",
        image: "img/massageThai.jpg",
    },
]

function displayProducts() {
    const container = document.querySelector(".mainContainer");
    products.forEach(product => {
        const div = document.createElement("div");
        div.classList.add("pub");
        div.innerHTML = `
            <a href="https://google.com"><img class="image" src="${product.image}" alt="${product.name}"></a>
            <div class="pubText">
                <h3>${product.name}</h3>
                <p>${product.description}</p>
                <p class="tarif">${product.price}</p>
                <p class="tarif2">${product.priceT}</p>
            </div>
        `;
        container.appendChild(div);
    });
}

displayProducts();

function displaySelect() {

    const menu = document.getElementById("categories");
    const trigger = document.getElementById("btnCategories");
    trigger.addEventListener("click", () => {
        menu.classList.toggle("hidden");
    });

};

displaySelect();

// function myFunction() {
//   var element = document.getElementById("myDIV");
//   element.classList.toggle("mystyle");
// } 