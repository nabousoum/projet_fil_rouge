<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220629192648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portion_frite DROP FOREIGN KEY FK_8F393CAD40D9D0AA');
        $this->addSql('DROP INDEX IDX_8F393CAD40D9D0AA ON portion_frite');
        $this->addSql('ALTER TABLE portion_frite DROP complement_id');
        $this->addSql('ALTER TABLE taille_boisson DROP FOREIGN KEY FK_59FAC26840D9D0AA');
        $this->addSql('DROP INDEX IDX_59FAC26840D9D0AA ON taille_boisson');
        $this->addSql('ALTER TABLE taille_boisson DROP complement_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portion_frite ADD complement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE portion_frite ADD CONSTRAINT FK_8F393CAD40D9D0AA FOREIGN KEY (complement_id) REFERENCES complement (id)');
        $this->addSql('CREATE INDEX IDX_8F393CAD40D9D0AA ON portion_frite (complement_id)');
        $this->addSql('ALTER TABLE taille_boisson ADD complement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE taille_boisson ADD CONSTRAINT FK_59FAC26840D9D0AA FOREIGN KEY (complement_id) REFERENCES complement (id)');
        $this->addSql('CREATE INDEX IDX_59FAC26840D9D0AA ON taille_boisson (complement_id)');
    }
}
