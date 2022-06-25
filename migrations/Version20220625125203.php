<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220625125203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE complement_menu');
        $this->addSql('ALTER TABLE taille_boisson CHANGE complement_id complement_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE complement_menu (complement_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_C653EA6B40D9D0AA (complement_id), INDEX IDX_C653EA6BCCD7E912 (menu_id), PRIMARY KEY(complement_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE complement_menu ADD CONSTRAINT FK_C653EA6B40D9D0AA FOREIGN KEY (complement_id) REFERENCES complement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE complement_menu ADD CONSTRAINT FK_C653EA6BCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille_boisson CHANGE complement_id complement_id INT DEFAULT NULL');
    }
}
