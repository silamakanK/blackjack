<?php

namespace App\Tests\Service;

use App\Entity\Card;
use App\Entity\Hand;
use App\Service\HandService;
use PHPUnit\Framework\TestCase;

class HandServiceTest extends TestCase
{
    private HandService $handService;

    protected function setUp(): void
    {
        $this->handService = new HandService();
    }

    public function testBlackjackWithAceAndKing(): void
    {
        $hand = new Hand();
        $hand->addCard(new Card('spade', 'A'));
        $hand->addCard(new Card('heart', 'K'));

        [$updatedHand, $err] = $this->handService->calculateScore($hand);

        $this->assertNull($err);
        $this->assertEquals(21, $updatedHand->getScore());
        $this->assertTrue($updatedHand->getIsBlackjack());
    }

    public function testAceAsElevenThenOne(): void
    {
        $hand = new Hand();
        $hand->addCard(new Card('spade', 'A')); 
        $hand->addCard(new Card('club', '9'));
        $hand->addCard(new Card('diamond', 'A')); 

        [$updatedHand, $err] = $this->handService->calculateScore($hand);

        $this->assertNull($err);
        $this->assertEquals(21, $updatedHand->getScore());
        $this->assertFalse($updatedHand->getIsBusted());
    }

    public function testBustedWithAceForcedToOne(): void
    {
        $hand = new Hand();
        $hand->addCard(new Card('spade', 'A'));
        $hand->addCard(new Card('club', 'K')); 
        $hand->addCard(new Card('heart', '9')); 

        [$updatedHand, $err] = $this->handService->calculateScore($hand);

        $this->assertNull($err);
        $this->assertEquals(20, $updatedHand->getScore());
        $this->assertFalse($updatedHand->getIsBusted());
    }
}
