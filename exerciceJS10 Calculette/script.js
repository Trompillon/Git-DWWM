const screen = document.querySelector('.screen')
const buttons = document.querySelectorAll('.button');
let expression = "";

buttons.forEach(button => {
    button.addEventListener('click', () => {
    const value = button.textContent;

    if (value === "C") {
        expression = "";

    } else if 
        (value === "=") {
        expression = eval(expression).toString();
        
    } else {
        expression += value;
    }

    screen.textContent = expression;
    
    });

});