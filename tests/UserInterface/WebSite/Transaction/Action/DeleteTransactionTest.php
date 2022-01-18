<?php

namespace App\Tests\UserInterface\WebSite\Transaction\Action;

use App\Core\Transaction\Application\Command\DeleteTransactionCommand;
use App\Infrastructure\Doctrine\DataFixtures\TransactionData;
use App\Shared\Transaction\Domain\TransactionId;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Messenger\TraceableMessageBus;

final class DeleteTransactionTest extends WebTestCase
{
    /**
     * @test
     */
    public function shouldDeleteATransaction(): void
    {
        $client = static::createClient();

        $client->request('GET', '/transaction/delete/'.TransactionData::TRANSACTION_WITH_CREDIT_REF);

        self::assertTrue(self::getContainer()->has('command.bus'));

        $expectedCommand = DeleteTransactionCommand::generate(new TransactionId(TransactionData::TRANSACTION_WITH_CREDIT_REF));

        /** @var TraceableMessageBus $transport */
        $transport = self::getContainer()->get('command.bus');
        $message = $transport->getDispatchedMessages()[0]['message'];

        self::assertInstanceOf(DeleteTransactionCommand::class, $message);
        self::assertSame($expectedCommand->transactionId()->value(), $message->transactionId()->value());

        self::assertResponseRedirects('/transaction/list');
        $client->followRedirect();

        $this->assertResponseIsSuccessful();

        $responseContent = $client->getResponse()->getContent();
        self::assertStringContainsString('Transaction supprimée', $responseContent);
    }
}
