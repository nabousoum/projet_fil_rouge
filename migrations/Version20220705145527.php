<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705145527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande CHANGE client_id client_id INT NOT NULL, CHANGE date_commande date_commande DATETIME NOT NULL');
        $this->addSql('ALTER TABLE menu_burger DROP FOREIGN KEY FK_3CA402D517CE5090');
        $this->addSql('ALTER TABLE menu_burger DROP FOREIGN KEY FK_3CA402D5CCD7E912');
        $this->addSql('DROP INDEX IDX_3CA402D517CE5090 ON menu_burger');
        $this->addSql('DROP INDEX IDX_3CA402D5CCD7E912 ON menu_burger');
        $this->addSql('ALTER TABLE menu_burger ADD id INT AUTO_INCREMENT NOT NULL, ADD quantite INT NOT NULL, DROP menu_id, DROP burger_id, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande CHANGE client_id client_id INT DEFAULT NULL, CHANGE date_commande date_commande DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE menu_burger MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE menu_burger DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE menu_burger ADD burger_id INT NOT NULL, DROP id, CHANGE quantite menu_id INT NOT NULL');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D517CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D5CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_3CA402D517CE5090 ON menu_burger (burger_id)');
        $this->addSql('CREATE INDEX IDX_3CA402D5CCD7E912 ON menu_burger (menu_id)');
        $this->addSql('ALTER TABLE menu_burger ADD PRIMARY KEY (menu_id, burger_id)');
    }
}
