<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240130111433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE destination ADD COLUMN image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE destination ADD COLUMN image_size INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE destination ADD COLUMN updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__destination AS SELECT id, name, description, price, duration, image FROM destination');
        $this->addSql('DROP TABLE destination');
        $this->addSql('CREATE TABLE destination (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, price DOUBLE PRECISION NOT NULL, duration INTEGER NOT NULL, image VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO destination (id, name, description, price, duration, image) SELECT id, name, description, price, duration, image FROM __temp__destination');
        $this->addSql('DROP TABLE __temp__destination');
    }
}
