<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240316122816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE process ADD workstation_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D18967FEBD122 FOREIGN KEY (workstation_id_id) REFERENCES work_station (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_861D18967FEBD122 ON process (workstation_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE process DROP CONSTRAINT FK_861D18967FEBD122');
        $this->addSql('DROP INDEX IDX_861D18967FEBD122');
        $this->addSql('ALTER TABLE process DROP workstation_id_id');
    }
}
