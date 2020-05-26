<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200525202836 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amount (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, money INT NOT NULL, UNIQUE INDEX UNIQ_8EA17042A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE budget_card (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, ceil INT NOT NULL, limit_date DATETIME NOT NULL, current_money INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_6CD09A83A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE budget_cards_favorite (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, budget_card_id INT NOT NULL, INDEX IDX_467AA3D5A76ED395 (user_id), INDEX IDX_467AA3D5884FD0C1 (budget_card_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deal (id INT AUTO_INCREMENT NOT NULL, budget_card_id INT NOT NULL, amount_id INT NOT NULL, type INT NOT NULL, money INT NOT NULL, INDEX IDX_E3FEC116884FD0C1 (budget_card_id), INDEX IDX_E3FEC1169BB17698 (amount_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, amount_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6499BB17698 (amount_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amount ADD CONSTRAINT FK_8EA17042A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE budget_card ADD CONSTRAINT FK_6CD09A83A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE budget_cards_favorite ADD CONSTRAINT FK_467AA3D5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE budget_cards_favorite ADD CONSTRAINT FK_467AA3D5884FD0C1 FOREIGN KEY (budget_card_id) REFERENCES budget_card (id)');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC116884FD0C1 FOREIGN KEY (budget_card_id) REFERENCES budget_card (id)');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC1169BB17698 FOREIGN KEY (amount_id) REFERENCES amount (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499BB17698 FOREIGN KEY (amount_id) REFERENCES amount (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE deal DROP FOREIGN KEY FK_E3FEC1169BB17698');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499BB17698');
        $this->addSql('ALTER TABLE budget_cards_favorite DROP FOREIGN KEY FK_467AA3D5884FD0C1');
        $this->addSql('ALTER TABLE deal DROP FOREIGN KEY FK_E3FEC116884FD0C1');
        $this->addSql('ALTER TABLE amount DROP FOREIGN KEY FK_8EA17042A76ED395');
        $this->addSql('ALTER TABLE budget_card DROP FOREIGN KEY FK_6CD09A83A76ED395');
        $this->addSql('ALTER TABLE budget_cards_favorite DROP FOREIGN KEY FK_467AA3D5A76ED395');
        $this->addSql('DROP TABLE amount');
        $this->addSql('DROP TABLE budget_card');
        $this->addSql('DROP TABLE budget_cards_favorite');
        $this->addSql('DROP TABLE deal');
        $this->addSql('DROP TABLE user');
    }
}
