<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200510134956 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE budget_card CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE budget_card ADD CONSTRAINT FK_6CD09A83A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6CD09A83A76ED395 ON budget_card (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE budget_card DROP FOREIGN KEY FK_6CD09A83A76ED395');
        $this->addSql('DROP INDEX IDX_6CD09A83A76ED395 ON budget_card');
        $this->addSql('ALTER TABLE budget_card CHANGE user_id user_id INT NOT NULL');
    }
}
