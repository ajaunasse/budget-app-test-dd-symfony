<?php

declare(strict_types=1);

namespace App\Core\BankAccount\Domain\Repository;

use App\Core\BankAccount\Domain\Exception\BankAccountActivityNotFound;
use App\Core\BankAccount\Domain\Model\BankAccountActivity;

interface BankAccountActivityRepository
{
    public function add(BankAccountActivity $bankAccountActivity): void;

    /**
     * @throws BankAccountActivityNotFound
     */
    public function get(int $id): BankAccountActivity;

    /**
     * @psalm-return null|list<BankAccountActivity>
     */
    public function list(): ?array;
}
