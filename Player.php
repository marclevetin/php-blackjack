<?php

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
