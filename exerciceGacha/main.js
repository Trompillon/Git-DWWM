const characters = [
    {
    name: "Raton Guerrier",
    rarity: "Commun",
    chance: 60,
    img: "images/raton.png"
},
    {
    name: "Loup Alpha",
    rarity: "Rare",
    chance: 25,
    img: "images/loupAlpha.png"
},
    { 
    name: "Dragon Ancien",
    rarity: "Épique",
    chance: 10,
    img: "images/dragon.png"
},
    {
    name: "Esprit Légendaire",
    rarity: "Légendaire",
    chance: 5,
    img: "images/esprit.jpg"
    }
];

    // const container = document.getElementById("main-container");
    // const button = document.getElementById("my-button");
    
    // button.addEventListener("click", () => {
    //     const div = document.createElement("div");
    //     const choice = characters[Math.floor(Math.random() * characters.length)];

    //     container.innerHTML = `
    //         <h2>${choice.name}</h2>
    //         <img id="img" src="${choice.img}" alt="${choice.name}">
            
    //     `;
    //     console.log(choice);
    // });

    const container = document.getElementById("main-container");
    const button = document.getElementById("my-button");
    
    button.addEventListener("click", () => {
        const div = document.createElement("div");
        const randomChar = getRandom();
        container.innerHTML = `
        <h2>${randomChar.name}</h2>
        <h3 class = "rarity">${randomChar.rarity}</h3>
        <img id="img" src="${randomChar.img}" alt="${randomChar.name}">
        `;

        const rarityElement = container.querySelector(".rarity");

        switch(randomChar.rarity.toLowerCase()) {
        case "commun":
            rarityElement.style.color = "gray";
            break;
        case "rare":
            rarityElement.style.color = "blue";
            break;
        case "épique":
            rarityElement.style.color = "purple";
            break;
        case "légendaire":
            rarityElement.style.color = "orange";
            break;
        default:
            rarityElement.style.color = "black";
    }
        
        console.log(getRandom());
    });

function getRandom() {
    const random = Math.random() * 100;
    let total = 0;

    for (let char of characters) {
        total += char.chance;
        if (random <= total) {
            return char;
        }
    }
}

//     function getRandom() {
//         const random = Math.random() * 100;
//         let total = 0;

//     for (let i = 0; i < characters.length; i++) {
//         total += characters[i].chance;
//         if (random <= total) {
//             return characters[i];
//         }
//     }
// }

