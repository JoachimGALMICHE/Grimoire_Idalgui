<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260304193532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE creature (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(100) DEFAULT NULL, origine VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, pouvoirs LONGTEXT DEFAULT NULL, danger VARCHAR(50) DEFAULT NULL, affinites VARCHAR(255) DEFAULT NULL, voie VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, proprietaire_id INT NOT NULL, INDEX IDX_2A6C6AF476C50E4A (proprietaire_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE creature ADD CONSTRAINT FK_2A6C6AF476C50E4A FOREIGN KEY (proprietaire_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creature DROP FOREIGN KEY FK_2A6C6AF476C50E4A');
        $this->addSql('DROP TABLE creature');
    }
}
