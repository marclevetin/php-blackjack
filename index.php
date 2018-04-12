<?php
// pseudocode
// 1. Initialize game.
// 2. Get player names.  Add dealer to the end.
// 3. Shuffle deck.
// 4. Deal two cards to each player.
      // If any player has Blackjack, they win.
// 5. Player turn: ask if they want to hit or stay
//    If hit, give them a card.
//    If stay, move to next player.
//    If total is over 21, player loses.
// 6. Dealer turn:
//    Dealer must hit until their total is >=17.
// 7. Win?
//    If a player's score is greater than the dealer's, they win.

// Blackjack = Initial deal is 1 Ace and 1 10 or facecard.
// Cards values = value printed on card; Ace is 1 or 11; Face cards are a 10.

// Out of scope for now, future possibilities:
// Splitting a hand
// Multiple decks in the shoe
// Betting
// GUI

require './Card.php';
require './Deck.php';
require './Player.php';
require './Game.php';

// Get player names
$game = new Game();
$game->beginGame();

// opening deal (2 cards to each player: 1 to each player, repeat)
for ($i=0; $i <2 ; $i++) {
  foreach ($game->allPlayers as $player) {
    $game->dealCard($player);
  }
}

// player turns
foreach ($game->allPlayers as $player) {
  if (!$player->isDealer) {
    $game->playerTurn($player);
  }
}

// dealer's turn
foreach ($game->allPlayers as $player) {
  if ($player->isDealer) {
    $game->dealerTurn($player);
  }
}

$game->endGame();
