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

class Card {
  public function __construct ($number, $suit) {
    $this->number = $number;
    $this->suit = $suit;
  }

  public function getNumber () {
    return $this->number;
  }

  public function getSuit () {
    return $this->suit;
  }

  public function getPrettyName () {
    return "$this->number" . "$this->suit";
  }

  public function getNumericValue () {
    if ($this->number < 11 && gettype($this->number) === "number") {
      return $this->number;
    } else if ($this->number == 'A') {
      return 1;
    } else {
      return 10;
    }
  }
}

class Deck {
  public function __construct ($cards = []) {
    $numbers = ['A','2','3','4','5','6','7','8','9','10','J','Q','K'];
    $suits = ['♥', '♦', '♠', '♣'];

    $this->whole_deck = $cards;

    foreach ($suits as $suit) {
      foreach ($numbers as $number) {
        $card = new Card($number,$suit);
        array_push($this->whole_deck, $card);
      }
    }
  }

  public function getDeck () {
    return $this->whole_deck;
  }

  public function shuffle () {
    shuffle($this->whole_deck);
  }

  public function deal() {
    return array_shift($this->whole_deck);
  }
}

class Player {
  public function __construct ($name, $isDealer=false) {
    $this->name = $name;
    $this->cards = [];
    $this->isDealer = $isDealer;
  }

  public function getCards() {
    return $this->cards;
  }

  public function getCardsSum() {
    $sum = 0;
    foreach ($this->cards as $card) {
      $sum = $sum + $card->getNumericValue();
    }

    return $sum;
  }

  public function getDealer() {
    return $this->isDealer;
  }

  public function addCard($card) {
    array_push($this->cards, $card);
  }
}

class Game {
  public function __construct() {
    $this->allPlayers = [];
    $this->deck = new Deck;
  }

  public function beginGame() {
    // shuffle deck
    $this->deck->shuffle();

    // players
    $numberPlayers = readline("How many players in the game?" . "\n>");
    for ($i=0; $i < $numberPlayers; $i++) {
      $adjustedIndex = $i + 1;
      $playerName = readline("What is Player $adjustedIndex's name?" . "\n>");
      $newplayer = new Player($playerName);
      array_push($this->allPlayers, $newplayer);
    }
    // dealer
    $dealer = new Player('Dealer', true);
    array_push($this->allPlayers, $dealer);
  }

  public function dealCard($player) {
    // deal two cards to each player
    $newCard = $this->deck->deal();
    $player->addCard($newCard);
  }

  public function playerTurn($player) {
    echo "Hi $player->name\n";
    $done = false;
    while (!$done) {
      $currentSum = $player->getCardsSum();
      if ($currentSum === 21) { // intended to capture a Blackjack.  Needs to be expanded out.
        echo "$player->name wins!";
        $done = true;
      } elseif ($currentSum < 21) {
        $getAnotherCard = readline("Your total is $currentSum. Do you want another card? (Y/N)" . "\n>"); //will need to sanitize this
        if ($getAnotherCard == "Y") {
          $player->addCard($this->deck->deal());
        } elseif ($getAnotherCard === "N") {
          echo "$player->name stands at $currentSum.\n";
          $done = true;
        }
      } elseif ($currentSum > 21) {
        echo "your total is $currentSum.  This is over 21, and you bust.  Sorry!\n";
        $done = true;
      }
    }
  }

  public function dealerTurn($player) {
    echo "It's the dealer's turn\n";
    $currentSum = $player->getCardsSum();
    while ( $currentSum <= 16 ) {
      echo "Dealer takes a card.\n";
      $player->addCard($this->deck->deal());
      $currentSum = $player->getCardsSum();
    }

    echo "Dealer's final score is $currentSum.\n";
  }

  public function endGame() {
    echo "Let's see who won!\n";

    $dealerScore = array_pop($this->allPlayers)->getCardsSum();

    foreach ($this->allPlayers as $player) {
      $name = $player->name;

      if ($player->getCardsSum() <= 21 && $player->getCardsSum() >= $dealerScore) {
        echo "$name beat the dealer and wins!\n";
      } elseif ($player->getCardsSum() <= 21 && $player->getCardsSum() < $dealerScore) {
        echo "$name did not beat the dealer and loses!\n";
      } elseif ($player->getCardsSum() > 21) {
        echo "$name busted and loses!\n";
      }
    }
  }

}

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

// Original code below

// this will probably be Game stuff eventually
// Get player names
// $numberPlayers = readline("How many players in the game?" . "\n>");
// $allPlayers = [];
// for ($i=0; $i < $numberPlayers; $i++) {
//   $adjustedIndex = $i + 1;
//   $playerName = readline("What is Player $adjustedIndex's name?" . "\n>");
//   $newplayer = new Player($playerName);
//   array_push($allPlayers, $newplayer);
// }

// Add dealer to the end of array
// $dealer = new Player('Dealer', true);
// array_push($allPlayers, $dealer);

// shuffle deck
// $deck = new Deck;
// $deck->shuffle();

// deal two cards to each player
// for ($i=0; $i < 2; $i++) {
//   foreach ($allPlayers as $player) {
//     $newCard = $deck->deal();
//     $player->addCard($newCard);
//   }
// }

// one player's turn
// foreach ($allPlayers as $player) {
//   echo "Hi $player->name";
//   $done = false;
//   if (!$player->isDealer) {
//     echo "player turn";
//     while (!$done) {
//       if ($player->getCardsSum() === 21) { // intended to capture a Blackjack.  Needs to be expanded out.
//         echo "$player->name wins!";
//         $done = true;
//       } elseif ($player->getCardsSum() < 21) {
//         $currentSum  = $player->getCardsSum();
//         $getAnotherCard = readline("Your total is $currentSum. Do you want another card? (Y/N)" . "\n>"); //will need to sanitize this
//         if ($getAnotherCard == "Y") {
//           $player->addCard($deck->deal());
//           // print_r ( $player->getCards() );
//           echo "show new value, loop through";
//         } elseif ($getAnotherCard === "N") {
//           echo "move to next player";
//           $done = true;
//         }
//       } elseif ($player->getCardsSum() > 21) {
//         $total = $player->getCardsSum();
//         print "your total is $total.  This is over 21, and you bust.";
//         $done = true;
//       }
//     }
//   } elseif ($player->isDealer) {
//     echo "Dealer turn";
//     while ($player->getCardsSum() <= 16 ) {
//       $player->addCard($deck->deal());
//       echo "dealer takes a card";
//     }
//   }
// }

// $dealerScore = array_pop($allPlayers)->getCardsSum();
// Win condition
// echo "let's see who won!\n";
// foreach ($allPlayers as $player) {
//   $name = $player->name;
//
//   if ($player->getCardsSum() <= 21 && $player->getCardsSum() >= $dealerScore) {
//     echo "$name beat the dealer and wins!";
//   } elseif ($player->getCardsSum() <= 21 && $player->getCardsSum() < $dealerScore) {
//     echo "$name did not beat the dealer and loses!";
//   } elseif ($player->getCardsSum() > 21) {
//     echo "$name busted and loses";
//   }
// }
