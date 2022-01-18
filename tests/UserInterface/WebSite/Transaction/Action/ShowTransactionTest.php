<?php

namespace App\Tests\UserInterface\WebSite\Transaction\Action;

use App\Infrastructure\Doctrine\DataFixtures\TransactionData;
use App\Shared\Common\Domain\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ShowTransactionTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function shouldShowATransaction(): void
    {
        $client = static::createClient();

        $client->request('GET', '/transaction/show/'.TransactionData::TRANSACTION_WITH_CREDIT_REF);

        $this->assertResponseIsSuccessful();

        $responseContent = $client->getResponse()->getContent();

        $this->assertStringContainsString('Transaction n°'.TransactionData::TRANSACTION_WITH_CREDIT_REF, $responseContent);
    }

    /**
     * @test
     */
    public function shouldHaveA404NotFound(): void
    {
        $client = static::createClient();

        $uuid = Uuid::random();

        $client->request('GET', '/transaction/show/'.$uuid);

        $this->assertResponseStatusCodeSame(404);

        $responseContent = $client->getResponse()->getContent();
        $this->assertStringContainsString('Transaction doesn\'t not exist for id '.$uuid, $responseContent);
    }
}
