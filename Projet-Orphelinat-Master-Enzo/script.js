document.addEventListener('DOMContentLoaded', () => {
    const selectElement = document.getElementById('nomP');
    const type1Input = document.getElementById('type1'); 
    const type2Input = document.getElementById('type2');
    
    const recycleButtons = document.querySelectorAll('.recycle-btn');
    
    recycleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('href');
            window.location.href = url;
        });
    });

    const pokemonSprites = document.querySelectorAll('.pokemon-sprite');
    
    pokemonSprites.forEach(sprite => {
        const pokemonId = sprite.getAttribute('data-pokemon-id');
        const isShiny = sprite.getAttribute('data-is-shiny') === '1';

        console.log(`${pokemonId}, ${isShiny}`);
        
    if (pokemonId) {
        fetch(`https://tyradex.vercel.app/api/v1/pokemon/${pokemonId}`)
            .then(response => response.json())
            .then(data => {
                sprite.src = isShiny ? data.sprites.shiny : data.sprites.regular;
            })
            .catch(error => {
                console.error('Erreur lors du chargement du Pokemon:', error);
                sprite.style.display = 'none';
            });
    }
});

    if (!selectElement) {
        return;
    }

    selectElement.addEventListener('change', function() {
        const pokemonId = selectElement.value; 

        fetch('fetch.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id_pokemon=' + encodeURIComponent(pokemonId)
        })
        .then(response => {
            if (!response.ok) { 
                throw new Error(`Erreur HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Donnees recues du serveur :", data);

            if (data.type1) { 
                type1Input.value = data.type1;
                type2Input.value = data.type2 ? data.type2 : ''; 
            } else {
                 type1Input.value = "Introuvable";
                 type2Input.value = "";
            }
        }) 
        .catch(error => {
            console.error('Probleme AJAX:', error);
            type1Input.value = "Erreur !";
            type2Input.value = "Erreur !";
        });

        const pokemonType = selectElement.value;

        fetch('filtrer.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'type=' + encodeURIComponent(pokemonType)
        })

        .then(response => {
            if (!response.ok) { 
                throw new Error(`Erreur HTTP: ${response.status}`);
            }
            return response.json();
        })
        
        .then(data => {
    console.log("Données reçues du serveur :", data);

    const tbody = document.getElementById('adoption-table-body');
    tbody.innerHTML = ''; // on vide le tableau

    if (data.length > 0) {
        data.forEach(pokemon => {
            const tr = document.createElement('tr');
            tr.classList.add('input-custom', 'border-bottom', 'mb-2', 'pb-2');
            
            tr.innerHTML = `
                <td class="text-start">${pokemon.id}</td>
                <td class="text-start">${pokemon.nom}</td>
                <td class="text-start">${pokemon.surnom}</td>
                <td class="text-start">${pokemon.type1}</td>
                <td class="text-start">${pokemon.type2 || ''}</td>
                <td class="text-start">${pokemon.taille}cm</td>
                <td class="text-start">${pokemon.poids}kg</td>
                <td class="text-start">${pokemon.niveau}</td>
            `;

            tbody.appendChild(tr);
        });
    } else {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center">Aucun Pokémon disponible pour ce type</td></tr>';
    }
    })
        .catch(error => {
            console.error('Probleme AJAX:', error);
            type1Input.value = "Erreur !";
            type2Input.value = "Erreur !";
        });

    });

    const pokemonInfo = document.getElementById('pokemon-details');
    const selectPokemon = document.getElementById('ownedPokemon');

    if (selectPokemon) {
        selectPokemon.addEventListener('change', () => {
            let pokemonId = selectPokemon.value;
            console.log(pokemonId);
        });
    }
});