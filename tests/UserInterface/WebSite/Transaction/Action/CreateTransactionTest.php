<?php

namespace App\Tests\UserInterface\WebSite\Transaction\Action;

use App\Core\Transaction\Application\Command\CreateTransactionCommand;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Messenger\TraceableMessageBus;

final class CreateTransactionTest extends WebTestCase
{
    /**
     * @dataProvider getAvailableFields
     * @test
     */
    public function shouldRenderForm(string $availableField): void
    {
        $client = static::createClient();

        $client->request('GET', '/transaction/create');

        $this->assertResponseIsSuccessful();

        $responseContent = $client->getResponse()->getContent();

        $this->assertStringContainsString('<form name="create_transaction"', $responseContent);

        $field = 'create_transaction['.$availableField.']';

        $this->assertStringContainsString($field, $responseContent);
    }

    /**
     * @test
     */
    public function submitFormWithDataShouldCreateCommand(): void
    {
        $client = static::createClient();

        $transactionName = 'Transaction ok';
        $transactionAmount = 125.52;
        $transactionDate = new DateTimeImmutable();
        $transactionType = 1;

        $formValue = [
            'create_transaction[name]' => $transactionName,
            'create_transaction[amount]' => $transactionAmount,
            'create_transaction[transactionDate]' => $transactionDate->format('Y-m-d'),
            'create_transaction[type]' => $transactionType,
        ];
        $formData = [
            'name' => $transactionName,
            'amount' => $transactionAmount,
            'transactionDate' => $transactionDate,
            'type' => $transactionType,
        ];

        $client->request('GET', '/transaction/create');

        $expectedCommand = CreateTransactionCommand::fromFormData($formData);

        $client->submitForm('Submit', $formValue);

        self::assertTrue(self::getContainer()->has('command.bus'));

        /** @var TraceableMessageBus $transport */
        $transport = self::getContainer()->get('command.bus');

        self::assertResponseRedirects('/transaction/list');

        $client->followRedirect();

        $responseContent = $client->getResponse()->getContent();
        self::assertStringContainsString('Transaction prise en compte', $responseContent);
        $message = $transport->getDispatchedMessages()[0]['message'];

        self::assertInstanceOf(CreateTransactionCommand::class, $message);
        self::assertSame($expectedCommand->name(), $message->name());
    }

    /**
     * @test
     */
    public function submitWithNullAmountShouldFailAndDisplayError(): void
    {
        $client = static::createClient();

        $transactionName = 'Transaction Failed';
        $transactionAmount = 0;
        $transactionDate = new DateTimeImmutable();
        $transactionType = 1;

        $formValue = [
            'create_transaction[name]' => $transactionName,
            'create_transaction[amount]' => $transactionAmount,
            'create_transaction[transactionDate]' => $transactionDate->format('Y-m-d'),
            'create_transaction[type]' => $transactionType,
        ];

        $client->request('GET', '/transaction/create');

        $client->submitForm('Submit', $formValue);

        $this->assertResponseIsSuccessful();

        $responseContent = $client->getResponse()->getContent();

        $this->assertStringContainsString('Amount cannot be null', $responseContent);
    }

    /**
     * @test
     */
    public function submitWithNegativeAmountShouldFailAndDisplayError(): void
    {
        $client = static::createClient();

        $transactionName = 'Transaction Failed';
        $transactionAmount = -125.52;
        $transactionDate = new DateTimeImmutable();
        $transactionType = 1;

        $formValue = [
            'create_transaction[name]' => $transactionName,
            'create_transaction[amount]' => $transactionAmount,
            'create_transaction[transactionDate]' => $transactionDate->format('Y-m-d'),
            'create_transaction[type]' => $transactionType,
        ];

        $client->request('GET', '/transaction/create');

        $client->submitForm('Submit', $formValue);

        $this->assertResponseIsSuccessful();

        $responseContent = $client->getResponse()->getContent();

        $this->assertStringContainsString('Amount cannot be negative', $responseContent);
    }

    /**
     * @return iterable<array<string>>
     */
    public function getAvailableFields(): iterable
    {
        yield ['name'];
        yield ['amount'];
        yield ['transactionDate'];
        yield ['type'];
    }
}
