<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200518184339 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE deal (id INT AUTO_INCREMENT NOT NULL, budget_card_id INT NOT NULL, amount_id INT NOT NULL, INDEX IDX_E3FEC116884FD0C1 (budget_card_id), INDEX IDX_E3FEC1169BB17698 (amount_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC116884FD0C1 FOREIGN KEY (budget_card_id) REFERENCES budget_card (id)');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC1169BB17698 FOREIGN KEY (amount_id) REFERENCES amount (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE deal');
    }
}
