<?php

namespace App\Card;

class Player21 extends PlayerDraw
{

    private $isFinished = false;

    function __construct()
    {
        $this->deck = new CardHand21();
        $this->deck->fillWithCards();
        $this->deck->shuffleHand();

        $this->players[] = new \App\Card\CardHand21();  //player is players[0]
        $this->players[] = new \App\Card\CardHand21();  // bank is players[1]

        $this->players[0]->pickRandomCard($this->deck, 2);

        if ($this->getOptimalValueCardsPlayer() > 21) {
            $this->isFinished = true;
        }
    }

    /**
     * Returns the best outcome value of the cards in game 21.
     */
    private function getOptimalValueCardsPlayer(): int
    {
        return $this->players[0]->getOptimalValueCards();
    }

    private function isOver21($cardHand) {
        return $cardHand->getOptimalValueCards() > 21;
    }

    public function setIsFinished($boolVal) {
        $this->isFinished = $boolVal;
    }

    public function isFinished() {
        return $this->isFinished;
    }

    public function playerDrawCard() {
        $player = $this->players[0];
        $this->singlePlayerDrawCards(0, 1);
        if ($this->isOver21($player)) {
            $this->isFinished = true;
        }
    }

    private function bankDrawCard() {
        $this->singlePlayerDrawCards(1, 1);
    }

    /**
     * Returns correct data when finished game
     */
    public function getEndData()
    {
        $player = $this->players[0];
        $bank = $this->players[1];

        if ($this->isOver21($player) === false) {
            while ($bank->getValueCards() < 17) {
                $this->bankDrawCard();
            }
        }

        $data = [
            'title' => 'Games session',
            'player' => $player->getCardIllustrations(),
            'playerPoints' => $player->getOptimalValueCards(),
            'bank' => $bank->getCardIllustrations(),
            'bankPoints' => $bank->getValueCards()
        ];
        if ($bank->getValueCards() <= 21) {
            if ($player->getOptimalValueCards() > 21 || $player->getOptimalValueCards() <= $bank->getValueCards()) {
                $data['message'] = 'You lost!';
            } else {
                $data['message'] = 'You won!';
            }
        } else {
            $data['message'] = 'You won!';
        }
        return $data;
    }

    /**
     * Returns correct draw data during session
     */
    public function getCurrentData()
    {
        $player = $this->players[0];

        $data = [
            'title' => 'Games session',
            'player' => $player->getCardIllustrations(),
            'playerMaxPoints' => $player->getValueCards(),
            'playerMinPoints' => $player->getValueCardsMin()
        ];

        return $data;
    }
}