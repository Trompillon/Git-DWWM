//sound

let jumpSound = new Audio("./sounds/jump-rudolph.mp3");
let music = new Audio("./sounds/music-rudolph.mp3");
let gameOverMusic = new Audio("./sounds/game-over.mp3");

//board

let board;
let boardWidth = 750;
let boardHeight = 250;
let context;


//rudolph
let rudoWidth = 88;
let rudoHeight = 94;
let rudoX = 50;
let rudoY = boardHeight - rudoHeight;
let rudoImg;

let rudo = {
    x : rudoX,
    y : rudoY,
    width : rudoWidth,
    height : rudoHeight
}

//cadeaux
let giftArray = [];

let gift1Width = 34;
let gift2Width = 69;
let gift3Width = 102;

let giftHeight = 70;
let giftX = 700;
let giftY = boardHeight - giftHeight;

let gift1Img;
let gift2Img;
let gift3Img;

//physics
let velocityX = -8; //gifts moving left speed
let velocityY = 0;
let gravity = .4;

let gameStarted = false;
let gameOver = false;
let score = 0;

window.onload = function() {
    board = document.getElementById("board");
    board.height = boardHeight;
    board.width = boardWidth;

    context = board.getContext("2d"); //used for drawing on the board

    rudoImg = new Image();
    rudoImg.src = "./img/rudolph.png";
    rudoImg.onload = function() {
    context.drawImage(rudoImg, rudo.x, rudo.y, rudo.width, rudo.height);
    }

    gift1Img = new Image();
    gift1Img.src = "./img/sucre-dorge.png";

    gift2Img = new Image();
    gift2Img.src = "./img/candy.png";

    gift3Img = new Image();
    gift3Img.src = "./img/blue-gift.png";

    music = new Audio("./sounds/music-rudolph.mp3");
    music.loop = true;
    music.play();

    requestAnimationFrame(update);
    setInterval(placeGift, 1000); //1000 milliseconds = 1 second
    document.addEventListener("keydown", moveRudo);

}

function update() {
    requestAnimationFrame(update);
    if (gameOver) {
        return;
    }
    context.clearRect(0, 0, board.width, board.height);

    //rudolph
    velocityY += gravity;
    rudo.y = Math.min(rudo.y + velocityY, rudoY); //apply gravity to current rudo.y, making sure it doesn't exceed the ground
    context.drawImage(rudoImg, rudo.x, rudo.y, rudo.width, rudo.height);

    //gift
    for (let i = 0; i < giftArray.length; i++) {
        let gift = giftArray[i];
        gift.x += velocityX;
        context.drawImage(gift.img, gift.x, gift.y, gift.width, gift.height);

        if (detectCollision(rudo, gift)) {
        gameOver = true;

            // Rudolph mort
            rudoImg.src = "./img/rudo-dead.png";
            rudoImg.onload = function() {
                context.drawImage(rudoImg, rudo.x, rudo.y, rudo.width, rudo.height);
            }

            // Image Game Over
            let gameOverImg = new Image();
            gameOverImg.src = "./img/game-over.png";
            gameOverImg.onload = function() {
                context.drawImage(gameOverImg, boardWidth/2 - 150, boardHeight/2 - 50, 300, 100);
            }

            // Arrêt musique
            music.pause();
            music.currentTime = 0;
            gameOverMusic.play();
}

    }

    //score
    context.fillStyle="black";
    context.font="20px courier";
    score++;
    context.fillText(score, 5, 20);
}

function moveRudo(e) {
    if (gameOver) {
        return;
    }

    if ((e.code == "Space" || e.code == "ArrowUp") && rudo.y == rudoY) {
        //jump
        velocityY = -10;
        jumpSound.play();
    }
}

function placeGift() {
    if (gameOver) {
        return;
    }

    //place gift
    let gift = {
        img : null,
        x : giftX,
        y : giftY,
        width : null,
        height: giftHeight
    }

    let placeGiftChance = Math.random(); //0 - 0.9999...

    if (placeGiftChance > .90) { //10% you get gift3
        gift.img = gift3Img;
        gift.width = gift3Width;
        giftArray.push(gift);
    }
    else if (placeGiftChance > .70) { //30% you get gift2
        gift.img = gift2Img;
        gift.width = gift2Width;
        giftArray.push(gift);
    }
    else if (placeGiftChance > .50) { //50% you get gift1
        gift.img = gift1Img;
        gift.width = gift1Width;
        giftArray.push(gift);
    }

    if (giftArray.length > 5) {
        giftArray.shift(); //remove the first element from the array so that the array doesn't constantly grow
    }
}

function detectCollision(a, b) {
    return a.x < b.x + b.width &&   //a's top left corner doesn't reach b's top right corner
           a.x + a.width > b.x &&   //a's top right corner passes b's top left corner
           a.y < b.y + b.height &&  //a's top left corner doesn't reach b's bottom left corner
           a.y + a.height > b.y;    //a's bottom left corner passes b's top left corner
}