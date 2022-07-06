<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220706150011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE frite_commande (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, portion_frite_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_15E13BF882EA2E54 (commande_id), INDEX IDX_15E13BF89B17FA7B (portion_frite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE frite_commande ADD CONSTRAINT FK_15E13BF882EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE frite_commande ADD CONSTRAINT FK_15E13BF89B17FA7B FOREIGN KEY (portion_frite_id) REFERENCES portion_frite (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE frite_commande');
    }
}
