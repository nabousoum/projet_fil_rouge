<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220706143948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boisson_taille_boisson DROP FOREIGN KEY FK_3AAEDEC88421F13F');
        $this->addSql('ALTER TABLE boisson_taille_boisson DROP FOREIGN KEY FK_3AAEDEC8734B8089');
        $this->addSql('ALTER TABLE boisson_taille_boisson ADD id INT AUTO_INCREMENT NOT NULL, ADD quantite INT NOT NULL, CHANGE boisson_id boisson_id INT DEFAULT NULL, CHANGE taille_boisson_id taille_boisson_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE boisson_taille_boisson ADD CONSTRAINT FK_3AAEDEC88421F13F FOREIGN KEY (taille_boisson_id) REFERENCES taille_boisson (id)');
        $this->addSql('ALTER TABLE boisson_taille_boisson ADD CONSTRAINT FK_3AAEDEC8734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boisson_taille_boisson MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE boisson_taille_boisson DROP FOREIGN KEY FK_3AAEDEC8734B8089');
        $this->addSql('ALTER TABLE boisson_taille_boisson DROP FOREIGN KEY FK_3AAEDEC88421F13F');
        $this->addSql('ALTER TABLE boisson_taille_boisson DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE boisson_taille_boisson DROP id, DROP quantite, CHANGE boisson_id boisson_id INT NOT NULL, CHANGE taille_boisson_id taille_boisson_id INT NOT NULL');
        $this->addSql('ALTER TABLE boisson_taille_boisson ADD CONSTRAINT FK_3AAEDEC8734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boisson_taille_boisson ADD CONSTRAINT FK_3AAEDEC88421F13F FOREIGN KEY (taille_boisson_id) REFERENCES taille_boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boisson_taille_boisson ADD PRIMARY KEY (boisson_id, taille_boisson_id)');
    }
}
