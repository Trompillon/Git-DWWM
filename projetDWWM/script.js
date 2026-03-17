function useItem(itemId) {
    const formData = new FormData();
    formData.append('item_id', itemId);

    fetch('use_item.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Dans script.js, à l'intérieur de .then(data => { ... })
if (data.success) {
    if (data.type === 'damage') {
        // --- CAS ATTACK ---
        const monsterText = document.getElementById('monster-hp-text');
        const monsterFill = document.getElementById('monster-hp-fill');
        
        if (monsterText) {
            // On récupère le HP Max qui est déjà écrit dans le span (ex: "50 / 100 HP")
            const parts = monsterText.textContent.split('/');
            const maxHp = parts[1] ? parts[1].trim() : "??"; 
            
            // On met à jour le texte (ex: "40 / 100 HP")
            monsterText.textContent = `${data.newMonsterHp} / ${maxHp}`;
            
            // On met à jour la barre visuelle
            if (monsterFill) {
                const percent = (data.newMonsterHp / parseInt(maxHp)) * 100;
                monsterFill.style.width = percent + '%';
            }
        }
        console.log("Dégâts infligés au monstre !");
    } else {
        // --- CAS SOIN (ce qu'on avait avant) ---
        updateHUD(data);
    }

    // Dans tous les cas, on met à jour l'inventaire
    updateInventoryUI(itemId, data.remaining);
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

function updateInventoryUI(itemId, remaining) {
    const itemRow = document.getElementById(`item-row-${itemId}`);
    if (itemRow) {
        const qtyVal = itemRow.querySelector('.qty-val');
        if (qtyVal) {
            const currentQty = parseInt(remaining);
            if (currentQty > 0) {
                qtyVal.innerText = currentQty;
            } else {
                itemRow.remove();
            }
        }
    }
}