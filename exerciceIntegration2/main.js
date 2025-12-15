(function(){
  "use strict";

  // const slideTimeout = 10000;
  const prevBtn = document.getElementById('prev');
  const nextBtn = document.getElementById('next');
  const inner = document.querySelector('.carousel-inner');
  const slides = Array.from(document.querySelectorAll('.slide'));
  const dotsContainer = document.querySelector('.carousel-dots');
  const carousel = document.querySelector('.carousel');

  let current = 0;
  let intervalId = null;
  let startX = 0;

  if (!inner || slides.length === 0) return; // sécurité

  // crée les dots
  slides.forEach((_, i) => {
    const dot = document.createElement('span');
    dot.className = (i === 0) ? 'dot active' : 'dot';
    dot.setAttribute('data-index', i);
    dot.setAttribute('role','button');
    dot.setAttribute('aria-label','Aller à la diapositive '+(i+1));
    dotsContainer.appendChild(dot);
  });
  const dots = Array.from(dotsContainer.querySelectorAll('.dot'));

  function updateDots(){
    dots.forEach((d, i) => d.classList.toggle('active', i === current));
  }

  function slideTo(index){
    if (index >= slides.length) index = 0;
    if (index < 0) index = slides.length - 1;
    current = index;
    inner.style.transform = `translateX(-${current * 100}%)`;
    updateDots();
  }

  function next(){
    slideTo(current + 1);
  }
  function prev(){
    slideTo(current - 1);
  }

  // events
  nextBtn.addEventListener('click', () => { next(); resetInterval(); });
  prevBtn.addEventListener('click', () => { prev(); resetInterval(); });

  dots.forEach(dot => {
    dot.addEventListener('click', (e) => {
      const idx = Number(e.currentTarget.getAttribute('data-index'));
      slideTo(idx);
      resetInterval();
    });
  });

  // auto play
  function startInterval(){
    if (intervalId) return;
    intervalId = setInterval(next, slideTimeout);
  }
  function stopInterval(){
    if (!intervalId) return;
    clearInterval(intervalId);
    intervalId = null;
  }
  function resetInterval(){
    stopInterval();
    startInterval();
  }

  // pause on hover
  carousel.addEventListener('mouseenter', stopInterval);
  carousel.addEventListener('mouseleave', startInterval);

  // touch support (swipe)
  inner.addEventListener('touchstart', (e) => {
    stopInterval();
    startX = e.touches[0].clientX;
  }, {passive:true});

  inner.addEventListener('touchend', (e) => {
    const endX = e.changedTouches[0].clientX;
    const dx = startX - endX;
    const threshold = 40; // px minimal pour considérer un swipe
    if (dx > threshold) next();
    else if (dx < -threshold) prev();
    resetInterval();
  });

  // keyboard accesibility
  document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowRight') { next(); resetInterval(); }
    if (e.key === 'ArrowLeft')  { prev(); resetInterval(); }
  });

  // initialisation
  slideTo(0);
  startInterval();

  // optionnel : redimensionner si besoin (garde le transform propre)
  window.addEventListener('resize', () => {
    // force repaint (pas strictement nécessaire)
    inner.style.transition = 'none';
    inner.style.transform = `translateX(-${current * 100}%)`;
    // remet la transition
    requestAnimationFrame(() => inner.style.transition = '');
  });
})();

        function openModal1() {
            document.querySelector('.overlay').style.display = 'block';
            document.querySelector('.modal1').style.display = 'block';

            setTimeout(closeModal, 5000);
        }

        function closeModal1() {
            document.querySelector('.overlay').style.display = 'none';
            document.querySelector('.modal1').style.display = 'none';

        }

        function openModal2() {
            document.querySelector('.overlay').style.display = 'block';
            document.querySelector('.modal2').style.display = 'block';

            setTimeout(closeModal, 5000);
        }

        function closeModal2() {

            document.querySelector('.overlay').style.display = 'none';
            document.querySelector('.modal2').style.display = 'none';

        }

        function openModal3() {
            document.querySelector('.overlay').style.display = 'block';
            document.querySelector('.modal3').style.display = 'block';

            setTimeout(closeModal, 5000);
        }

        function closeModal3() {

            document.querySelector('.overlay').style.display = 'none';
            document.querySelector('.modal3').style.display = 'none';

        }

// Carousel dynamique

// /const images = [
//     "Diapo1.png",
//     "Diapo2.png",
//     "Diapo3.png",
//     "Diapo4.png",
//     "Diapo5.png",
//     "Diapo6.png" // nouvelle slide ajoutée facilement
// ];

// const carouselInner = document.querySelector(".carousel-inner");

// images.forEach((src, index) => {
//     const slide = document.createElement("div");
//     slide.classList.add("slide");
//     slide.innerHTML = `<img src="${src}" alt="Image ${index + 1}">`;
//     carouselInner.appendChild(slide);
// });
