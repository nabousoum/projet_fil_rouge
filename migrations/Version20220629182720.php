<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220629182720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A934A7843DC');
        $this->addSql('DROP INDEX IDX_7D053A934A7843DC ON menu');
        $this->addSql('ALTER TABLE menu DROP catalogue_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu ADD catalogue_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A934A7843DC FOREIGN KEY (catalogue_id) REFERENCES catalogue (id)');
        $this->addSql('CREATE INDEX IDX_7D053A934A7843DC ON menu (catalogue_id)');
    }
}
