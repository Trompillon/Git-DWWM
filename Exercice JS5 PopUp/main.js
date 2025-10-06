// let popupAlreadyShowed = false

// window.addEventListener('scroll', function(e) {
//   if( ! popupAlreadyShowed ) {
//     setTimeout( () => {
//       document.getElementById('popup').style.display = 'block'
//     }, 3000 )
//     popupAlreadyShowed = true
//   }
// });

// document.getElementById('popupFermeture').addEventListener('click', function(e) {
//   document.getElementById('popup').style.display = 'none'
// })

let popupAlreadyShowed = false

window.addEventListener('scroll', () => {
  if( !popupAlreadyShowed ) {
    document.getElementById('popup').style.display = 'block'
    popupAlreadyShowed = true
  }
});

document.getElementById('popupFermeture').addEventListener('click', () => {
  document.getElementById('popup').style.display = 'none'
})
