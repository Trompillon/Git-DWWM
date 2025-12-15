function openModal(id, autoClose, duration) {
    const modal = document.getElementById(id);
    if (!modal) {
        console.error(`Modale ${id} introuvable`);
        return;
    }
    modal.style.display = "block";

    if (autoClose) {
        setTimeout(() => closeModal(id), duration);
    }
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (!modal) {
        console.error(`Modale ${id} introuvable`);
        return;
    }
    modal.style.display = "none";
}

// Génération dynamique des publicités

const products = [

    {
        name: "Ordinateur Portable",
        price: "899,99 €",
        description: "PC portable haute performance pour professionnels",
        image: "pc.webp",
        modalId: "modal1",
        favoriteModalId: "modalA"
    },
    {
        name: "Smartphone",
        price: "699,99 €",
        description: "Téléphone dernière génération avec appareil photo 800MP",
        image: "nokia.webp",
        modalId: "modal2",
        favoriteModalId: "modalB"
    },
    {
        name: "Casque Audio",
        price: "249,99 €",
        description: "Casque sans fil avec réduction de bruit active",
        image: "casque-audio-crabe.jpg",
        modalId: "modal3",
        favoriteModalId: "modalC"
    },
    {
        name: "Tablette",
        price: "399,99 €",
        description: "Tablette 10 pouces idéale pour la lecture et le streaming",
        image: "tablette-de-choco.jpg",
        modalId: "modal4",
        favoriteModalId: "modalD"
    },
    {
        name: "Montre connectée",
        price: "249,99 €",
        description: "Montre intelligente avec suivi santé et notifications",
        image: "connected-watch.webp",
        modalId: "modal5",
        favoriteModalId: "modalE"
    },
    {
        name: "Appareil Photo Canon ",
        price: "1299,99 €",
        description: "Appareil photo Optimus Gundam 666MP",
        image: "camera-gundam.webp",
        modalId: "modal6",
        favoriteModalId: "modalF"
    },
    {
        name: "Enceinte Bluetooth",
        price: "89,99 €",
        description: "Enceinte portable étanche avec son 360°",
        image: "bt.jpg",
        modalId: "modal7",
        favoriteModalId: "modalG"
    },
    {
        name: "Console de Jeux",
        price: "499,99 €",
        description: "Console nouvelle génération avec SSD ultra-rapide(bien sur!)",
        image: "GameWatchFire.jpg",
        modalId: "modal8",
        favoriteModalId: "modalH"
    },
    {
        name: "Clavier mécanique",
        price: "129,99 €",
        description: "Clavier gaming RGB avec switches mécaniques",
        image: "clavier.webp",
        modalId: "modal9",
        favoriteModalId: "modalI"
    },
    
];



function displayProducts() {
    const container = document.querySelector(".mainContainer");
    products.forEach(product => {
        const div = document.createElement("div");
        div.classList.add("pub");
        div.innerHTML = `
            <img src="${product.image}" alt="${product.name}">
            <div class="pubText">
                <h2>${product.name}</h2>
                <p>${product.description}</p>
                <p class="tarif">${product.price}</p>
                <div class="buttons">
                    <button class="buttonOpen1" onclick="openModal('${product.modalId}')">Voir détails</button>
                    <button class="buttonOpen2" onclick="openModal('${product.favoriteModalId}', true, 2000)">❤️</button>
                </div>
            </div>
        `;
        container.appendChild(div);
    });
}

// Création dynamique des modales produit et favoris
function createModals() {
    const modalContainer = document.querySelector(".mainModal");
    products.forEach(product => {
        // Modale produit
        const productModal = document.createElement("div");
        productModal.id = product.modalId;
        productModal.classList.add("modal");
        productModal.innerHTML = `
            <div class="modalheader1">
                <h2 class="modalHeader">${product.name}</h2>
            </div>
            <div class="modalBody1">
                <img class="imagemodal" src="${product.image}" alt="${product.name}">
                <p>${product.description}</p>
                <p class="tarif">${product.price}</p>
            </div>
            <div class="modalFooter1">
                <button class="modalFooterButton" onclick="closeModal('${product.modalId}')">Fermer</button>
            </div>
        `;
        modalContainer.appendChild(productModal);

        // Modale favoris
        const favModal = document.createElement("div");
        favModal.id = product.favoriteModalId;
        favModal.classList.add("modalFav");
        favModal.innerHTML = `<p>❤️ ${product.name} ajouté aux favoris</p>`;
        modalContainer.appendChild(favModal);
    });
}

displayProducts();
createModals();

