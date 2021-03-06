<?php

namespace App\Card;

class CardHandJoker extends CardHand
{
    private int $jokerNum = 2;


    /**
     * Fill hand with the typical deck cards. Also adds two jokers.
     */
    public function fillWithCards(): void
    {
        foreach ($this->possibleColors as $col) {
            foreach ($this->possibleValues as $key => $val) {
                $newCard = new Card($col, $val, $key);
                $this->hand[] = $newCard;
            }
        }
        for ($i = 1; $i <= $this->jokerNum; $i++) {
            $this->hand[] = new Card('joker', '', 15);
        }
    }
}
