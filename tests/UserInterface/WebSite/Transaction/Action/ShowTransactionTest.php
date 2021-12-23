<?php

namespace App\Tests\UserInterface\WebSite\Transaction\Action;

use App\Shared\Common\Domain\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ShowTransactionTest extends WebTestCase
{
    /**
     * @test
     */
    public function shouldShowATransaction(): void
    {
        $client = static::createClient();

        $client->request('GET', '/transaction/show/dafefa83-9e8c-477f-a414-c036826c9997');

        $this->assertResponseIsSuccessful();

        $responseContent = $client->getResponse()->getContent();

        $this->assertStringContainsString('Transaction n°dafefa83-9e8c-477f-a414-c036826c9997', $responseContent);
    }

    /**
     * @test
     */
    public function shouldHaveA404NotFound(): void
    {
        $client = static::createClient();

        $uuid = Uuid::random();

        $client->request('GET', '/transaction/show/8a11a0a7-0731-4b72-a5a4-18a5424738b3');

       // $this->assertResponseStatusCodeSame(404);

        $responseContent = $client->getResponse()->getContent();
        dd($responseContent);
       // $this->assertStringContainsString('Transaction doesn\'t not exist for id '.$uuid, $responseContent);
    }
}
