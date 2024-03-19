// script.js

// Game logic
let coinsLeft = 21;
let currentPlayer = 'human';

// Function to handle player's move
function playerMove(num) {
    if (num < 1 || num > 4 || num > coinsLeft) {
        alert('Invalid move! Please pick between 1 and 4 coins.');
        return;
    }
    coinsLeft -= num;
    if (coinsLeft === 0) {
        endGame('human');
    } else {
        currentPlayer = 'ai';
        aiMove();
    }
}

// Function to handle AI's move
function aiMove() {
    let aiCoins = Math.min(coinsLeft, Math.floor(Math.random() * 4) + 1);
    coinsLeft -= aiCoins;
    if (coinsLeft === 0) {
        endGame('ai');
    } else {
        currentPlayer = 'human';
    }
}

// Function to end the game
function endGame(winner) {
    if (winner === 'human') {
        alert('You win!');
    } else {
        alert('AI wins!');
    }
    resetGame();
}

// Function to reset the game
function resetGame() {
    coinsLeft = 21;
    currentPlayer = 'human';
}
