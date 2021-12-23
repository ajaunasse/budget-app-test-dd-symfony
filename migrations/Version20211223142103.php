<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211223142103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE bank_account_activity_seq INCREMENT BY 100 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE bank_account (id VARCHAR(36) NOT NULL, name VARCHAR(50) NOT NULL, start_balance INT NOT NULL, current_balance INT NOT NULL, type VARCHAR(20) NOT NULL, main_account BOOLEAN NOT NULL, created_at DATE NOT NULL, updated_at DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN bank_account.created_at IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN bank_account.updated_at IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE bank_account_activity (id INT NOT NULL, bank_account_id VARCHAR(36) NOT NULL, transaction_id VARCHAR(36) DEFAULT NULL, type VARCHAR(20) NOT NULL, old_balance INT NOT NULL, new_balance INT NOT NULL, occured_at DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX bank_account_id_idx ON bank_account_activity (bank_account_id)');
        $this->addSql('CREATE INDEX transaction_id_idx ON bank_account_activity (transaction_id)');
        $this->addSql('COMMENT ON COLUMN bank_account_activity.occured_at IS \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE transaction ALTER id TYPE VARCHAR(36)');
        $this->addSql('ALTER TABLE transaction ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE bank_account_activity_seq CASCADE');
        $this->addSql('DROP TABLE bank_account');
        $this->addSql('DROP TABLE bank_account_activity');
        $this->addSql('ALTER TABLE transaction ALTER id TYPE VARCHAR(36)');
        $this->addSql('ALTER TABLE transaction ALTER id DROP DEFAULT');
    }
}
