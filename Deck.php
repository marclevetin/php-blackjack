<?php

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

  public function shuffle () {
    shuffle($this->whole_deck);
  }

  public function deal() {
    return array_shift($this->whole_deck);
  }
}
