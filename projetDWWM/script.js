function useItem(itemId) {
    const formData = new FormData();
    formData.append('item_id', itemId);

    fetch('use_item.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 1. Appeler la fonction qui met à jour le HUD proprement
            updateHUD(data);

            // 2. Mettre à jour la quantité dans la modale d'inventaire
            const itemRow = document.getElementById(`item-row-${itemId}`);
            if (itemRow) {
                if (data.remaining > 0) {
                    // On cherche le span qui contient le chiffre de la quantité
                    const qtyVal = itemRow.querySelector('.qty-val');
                    if (qtyVal) qtyVal.innerText = data.remaining;
                } else {
                    itemRow.remove(); // Plus de potion ? On enlève la ligne
                }
            }
            console.log("Objet utilisé et HUD mis à jour !");
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Erreur Fetch:', error));
}

function updateHUD(data) {
    console.log("Données reçues :", data);
    // 1. Mise à jour PV
    const hpText = document.getElementById('hp-text');
    const hpFill = document.getElementById('hp-fill');
    
    if (hpText) {
        // On récupère le MAX qui est déjà écrit dans le texte (ex: "10 / 30 PV")
        const parts = hpText.textContent.split('/');
        const hpMax = parts[1] ? parts[1].trim() : "30 PV"; // On garde la partie droite
        
        // On réécrit le tout proprement
        hpText.textContent = `${data.newHp} / ${hpMax}`;
        
        if (hpFill) {
            const maxVal = parseInt(hpMax);
            hpFill.style.width = (data.newHp / maxVal * 100) + '%';
        }
    }

    // 2. Mise à jour Mana
    const manaText = document.getElementById('mana-text');
    const manaFill = document.getElementById('mana-fill');
    
    if (manaText && data.newMana !== undefined) {
        const parts = manaText.textContent.split('/');
        const manaMax = parts[1] ? parts[1].trim() : "50 PM";
        
        manaText.textContent = `${data.newMana} / ${manaMax}`;
        
        if (manaFill) {
            const maxVal = parseInt(manaMax);
            manaFill.style.width = (data.newMana / maxVal * 100) + '%';
        }
    }
}