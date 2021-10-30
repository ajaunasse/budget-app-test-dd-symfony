<?php

namespace App\Tests\Transaction\UseCase;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ShowTransactionTest extends WebTestCase
{
    /**
     * @test
     */
    public function shouldShowATransaction(): void
    {
        $client = static::createClient();

        $client->request('GET', '/transaction/show/1');

        $this->assertResponseIsSuccessful();

        $responseContent = $client->getResponse()->getContent();

        $this->assertStringContainsString('Transaction n°1', $responseContent);
    }

    /**
     * @test
     */
    public function shouldHaveA404NotFound(): void
    {
        $client = static::createClient();

        $client->request('GET', '/transaction/show/100000000');

        $this->assertResponseStatusCodeSame(404);

        $responseContent = $client->getResponse()->getContent();

        $this->assertStringContainsString('Transaction doesn\'t not exist for id 100000000', $responseContent);
    }
}
