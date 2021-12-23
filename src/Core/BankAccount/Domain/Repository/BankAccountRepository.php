<?php

declare(strict_types=1);

namespace App\Core\BankAccount\Domain\Repository;

use App\Core\BankAccount\Domain\Exception\BankAccountNotFound;
use App\Core\BankAccount\Domain\Model\BankAccount;
use App\Shared\BankAccount\Domain\BankAccountId;

interface BankAccountRepository
{
    public function add(BankAccount $bankAccount): void;

    /**
     * @throws BankAccountNotFound
     */
    public function get(BankAccountId $bankAccountId): BankAccount;

    /**
     * @psalm-return null|list<BankAccount>
     */
    public function list(): ?array;

    public function update(BankAccountId $bankAccountId): void;

    public function delete(BankAccountId $bankAccountId): void;
}
