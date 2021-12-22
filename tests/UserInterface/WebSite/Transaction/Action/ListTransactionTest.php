<?php

namespace App\Tests\UserInterface\WebSite\Transaction\Action;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ListTransactionTest extends WebTestCase
{
    /**
     * @test
     */
    public function shouldRenderList(): void
    {
        $client = static::createClient();

        $client->request('GET', '/transaction/list');

        $this->assertResponseIsSuccessful();

        $responseContent = $client->getResponse()->getContent();

        $this->assertStringContainsString('Liste des dernières transactions', $responseContent);
    }
}
