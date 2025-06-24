<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\TurnService;
use App\Entity\Card;

class TurnServiceTest extends TestCase
{
    public function testGenerateDeckContainsCorrectAces()
    {
        $deck = TurnService::generateDeck();

        $this->assertCount(52, $deck, "Le deck doit contenir 52 cartes.");

        $aces = array_filter($deck, function(Card $card) {
            return $card->getValue() === 'A';
        });

        $this->assertCount(4, $aces, "Le deck doit contenir 4 As avec la valeur 'A'.");

        $ones = array_filter($deck, function(Card $card) {
            return $card->getValue() === '1';
        });
        $this->assertCount(0, $ones, "Le deck ne doit contenir aucune carte avec la valeur '1'.");
    }
}