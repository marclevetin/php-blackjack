<?php

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
    $countOfCards = 2;
    $aceOver21 = 0;

    $hasAce = $this->doesHandIncludeAce(  $player->cards ); // expand this out.

    while (!$done) {
      $currentSum = $player->getCardsSum() - $aceOver21;

      if ($currentSum === 21 && $countOfCards === 2) {
        echo "Blackjack!  $player->name wins!\n";
        $done = true;
      } elseif ($currentSum === 21 && $countOfCards !== 2) {
        echo "$player->name stands at $currentSum.\n";
        $done = true;
      } elseif ($currentSum < 21) {
        $validInput = false;
        while (!$validInput) {
          $getAnotherCard = readline("Your total is $currentSum. Do you want another card? (Y/N)" . "\n>");
          $getAnotherCard = strtoupper($getAnotherCard);
          if ($getAnotherCard === 'Y' || $getAnotherCard === 'N') {
            $validInput = true;
          } else {
            echo "Please enter a 'Y' or 'N'.\n";
          }
        }
        if ($getAnotherCard == "Y") {
          $countOfCards += 1;
          $player->addCard($this->deck->deal());
        } elseif ($getAnotherCard === "N") {
          echo "$player->name stands at $currentSum.\n";
          $done = true;
        }
      } elseif ($currentSum > 21) {
        $hasAce = false;
        if ($hasAce) {
          $aceOver21 = 10;
          echo "Good thing you have an Ace!.\n";
        } else {
          echo "Your total is $currentSum.  This is over 21, and you bust.  Sorry!\n";
          $done = true;
        }
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

    if ($currentSum > 21) {
      echo "Dealer busts!\n";
    }
  }

  public function endGame() {
    $dealerScore = array_pop($this->allPlayers)->getCardsSum();

    echo "Let's see who won!\n";

    foreach ($this->allPlayers as $player) {
      $name = $player->name;
      $playerScore = $player->getCardsSum();

      // if the dealer busted, and player score is lte to 21, then the player wins.
      // if the dealer did not bust, and the player score is gte to the dealer's score, and the player's score is lte 21, then the player wins.
      // if the dealer did not bust, and the player's score is less than dealer's score, player loses.
      // if the player's score is greater than 21, he busts.

      if ($dealerScore > 21 && $playerScore <= 21) {
        echo "Dealer busts, and $name wins!\n";
      } elseif ($dealerScore <= 21 && $playerScore >= $dealerScore && $playerScore <=21) {
        echo "$name beat the dealer and wins!\n";
      } elseif ($dealerScore <= 21 && $playerScore < $dealerScore) {
        echo "$name did not beat the dealer and loses.\n";
      } elseif ($playerScore > 21) {
        echo "$name busted and loses.\n";
      }
    }
  }

  private function doesHandIncludeAce($hand) {
    if ( in_array('A', array_values($hand)) ) {
      return true;
    }
    return false;
  }

}
