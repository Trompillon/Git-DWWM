document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Sélectionner les éléments du DOM
    const selectElement = document.getElementById('nomP');
    const type1Input = document.getElementById('type1'); 
    const type2Input = document.getElementById('type2');

    if (!selectElement) {
        return; // Sortir si l'élément n'est pas trouvé
    }

    // 2. Écouter l'événement 'change'
    selectElement.addEventListener('change', function() {
        
        // 3. Récupérer l'ID du Pokémon sélectionné (c'est la 'value' de l'option)
        const pokemonId = selectElement.value; // = this.value 'this' fait référence au 'selectElement'

        // 4. L'appel FETCH (Le Cœur de l'AJAX)
        // On envoie une requête POST à notre script PHP pour obtenir les données
        fetch('fetch.php', { // = action du form (dans adoption.php)
            method: 'POST', // méthod du form
            headers: { // envoi/simule un format form html
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            // Le corps de la requête. CLÉ : 'id_pokemon', VALEUR : l'ID récupéré
            body: 'id_pokemon=' + encodeURIComponent(pokemonId) 
        })
        
        // 5. Premièrement, vérifier la réponse réseau
        .then(response => {
            // S'il y a une erreur HTTP (comme 404, 500, ou le 400 que vous avez codé)
            if (!response.ok) { 
                throw new Error(`Erreur HTTP: ${response.status}`);
            }
            return response.json(); // On continue pour décoder le JSON
        })
        
        // 6. Utiliser les données du Pokémon (l'objet 'data')
        .then(data => {
            console.log("Données reçues du serveur :", data);
            
            // On vérifie que les données contiennent bien un type pour éviter les erreurs
            if (data.type1) { 
                type1Input.value = data.type1;
                // Si 'data.type2' existe, on l'utilise, sinon on vide le champ
                type2Input.value = data.type2 ? data.type2 : ''; 
            } else {
                 // Si le serveur a renvoyé un message d'erreur ou rien
                 type1Input.value = "Introuvable";
                 type2Input.value = "";
            }
        }) 
        
        // 7. Gérer les erreurs (réseau ou JSON)
        .catch(error => {
            console.error('Problème AJAX:', error);
            type1Input.value = "Erreur !";
            type2Input.value = "Erreur !";
        });
        
    });
});