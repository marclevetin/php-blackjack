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

  public function getNumericValue () {
    if ($this->number < 11) {
      return $this->number;
    } else if ($this->number == 'A') {
      return 'A';
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
}

$deck = new Deck;
$deck->shuffle();
