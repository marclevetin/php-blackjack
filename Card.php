<?php

class Card {
  public function __construct ($number, $suit) {
    $this->number = $number;
    $this->suit = $suit;
  }

  public function getPrettyName () {
    return "$this->number" . "$this->suit";
  }

  public function getNumericValue () {
    $facecards = ['K', 'Q', 'J'];

    if ($this->number === 'A') {
      return 11;
    } elseif (in_array($this->number, $facecards)) {
      return 10;
    } else {
      return intval($this->number);
    }
  }
}
