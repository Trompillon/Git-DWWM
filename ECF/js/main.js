const products = [

    {
        name: "Pizza Margherita",
        price: "12,50 €",
        description: "Tomates, mozarella, basilic frais",
        image: "img/margarita.webp",
        note: "17/20"
    },
    {
        name: "Burger Gourmet",
        price: "14,00 €",
        description: "Boeuf, cheddar, oignons caramélisés",
        image: "img/burger_gourmet.jpg",
        note: "18/20",
    },
    {
        name: "Salade César",
        price: "10,00 €",
        description: "Poulet, parmesan, croûtons",
        image: "img/saladecaesar.jpg",
        note: "16/20"
    },
    
];

function displayProducts() {
    const container = document.querySelector(".main-container");
    products.forEach(product => {
        const div = document.createElement("div");
        div.classList.add("pub");
        div.innerHTML = `
        <div class="image-wrapper">
        <img class="image" src="${product.image}" alt="${product.name}">
        <span class="note"> ⭐${product.note}</span>
        </div>
        <div class="pubText">
        <h2>${product.name}</h2>
        <p>${product.description}</p>
        <p class="tarif">${product.price}</p>
    </div>
`;

        container.appendChild(div);
    });
}

displayProducts();



