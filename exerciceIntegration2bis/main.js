(function(){
  "use strict";

  // === TABLEAUX DYNAMIQUES ===
  const carouselImages = [
    "Diapo1.png",
    "Diapo2.png",
    "Diapo3.png",
    "Diapo4.png",
    "Diapo5.png"
  ];

  const products = [
    {
      name: "Argent",
      price: "125,00 €",
      description: "Acheter de l'argent !",
      image: "argent.jpg"
    },
    {
      name: "Une paire de couilles",
      price: "200,00 €",
      description: "Acheter une paire de couilles !",
      image: "couilles.png"
    },
    {
      name: "Air de Montcuq",
      price: "75,00 €",
      description: "Acheter de l'air de Montcuq !",
      image: "airdeMontcuq.png"
    }
  ];

  // === GENERATION DYNAMIQUE DU CAROUSEL ===
  const inner = document.querySelector('.carousel-inner');
  const dotsContainer = document.querySelector('.carousel-dots');
  const prevBtn = document.getElementById('prev');
  const nextBtn = document.getElementById('next');
  const carousel = document.querySelector('.carousel');

  carouselImages.forEach((src, index) => {
    const slide = document.createElement('div');
    slide.classList.add('slide');
    slide.innerHTML = `<img src="${src}" alt="Image ${index+1}">`;
    inner.appendChild(slide);

    const dot = document.createElement('span');
    dot.className = (index === 0) ? 'dot active' : 'dot';
    dot.dataset.index = index;
    dotsContainer.appendChild(dot);
  });

  const slides = Array.from(inner.querySelectorAll('.slide'));
  const dots = Array.from(dotsContainer.querySelectorAll('.dot'));
  let current = 0;

  function updateCarousel(){
    inner.style.transform = `translateX(-${current*100}%)`;
    dots.forEach((d,i) => d.classList.toggle('active', i===current));
  }

  function nextSlide(){ current = (current+1)%slides.length; updateCarousel(); }
  function prevSlide(){ current = (current-1+slides.length)%slides.length; updateCarousel(); }

  nextBtn.addEventListener('click', nextSlide);
  prevBtn.addEventListener('click', prevSlide);
  dots.forEach(dot => {
    dot.addEventListener('click', e => {
      current = Number(dot.dataset.index);
      updateCarousel();
    });
  });

  updateCarousel();

  // === GENERATION DYNAMIQUE DES PUBLICITES ET MODALES ===
  const pubContainer = document.querySelector('.containerPub');
  const modalContainer = document.querySelector('.mainModal');
  const overlay = document.querySelector('.overlay');

  products.forEach((product, index) => {
    // PUB
    const div = document.createElement('div');
    div.classList.add('pub');
    div.innerHTML = `
      <img src="${product.image}" alt="${product.name}" style="height:150px;width:250px;">
      <div class="pubText">
        <p>${product.description}</p>
        <p id="tarif">${product.price}</p>
        <button class="buttonOpen">Voir plus</button>
      </div>
    `;
    pubContainer.appendChild(div);

    // MODALE
    const modal = document.createElement('div');
    modal.classList.add('modal');
    modal.style.display = 'none';
    modal.innerHTML = `
      <div class="modalHeader"><h2>${product.name}</h2></div>
      <div class="modalBody">
        <img src="${product.image}" alt="${product.name}" style="max-width:100%">
        <p>${product.description}</p>
        <p>${product.price}</p>
        <button class="commandez">Je commande !</button>
      </div>
      <div class="modalFooter">
        <button class="modalClose">Fermer</button>
      </div>
    `;
    modalContainer.appendChild(modal);

    const button = div.querySelector('.buttonOpen');
    const closeBtn = modal.querySelector('.modalClose');

    button.addEventListener('click', () => {
      overlay.style.display = 'block';
      modal.style.display = 'block';
    });
    closeBtn.addEventListener('click', () => {
      overlay.style.display = 'none';
      modal.style.display = 'none';
    });
  });

  overlay.addEventListener('click', () => {
    overlay.style.display = 'none';
    modalContainer.querySelectorAll('.modal').forEach(m => m.style.display='none');
  });

})();
