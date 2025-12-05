// Fonction générique pour ouvrir un modal
function openModal(modalClass, autoClose = false, duration = 2000) {
    const modal = document.querySelector(`.${modalClass}`);
    modal.style.display = 'block';

    if (autoClose) {
        setTimeout(() => closeModal(modalClass), duration);
    }
}

// Fonction générique pour fermer un modal
function closeModal(modalClass) {
    const modal = document.querySelector(`.${modalClass}`);
    modal.style.display = 'none';
}
