<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240131160438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__destination AS SELECT id, name, description, price, duration, image_size FROM destination');
        $this->addSql('DROP TABLE destination');
        $this->addSql('CREATE TABLE destination (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, image_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, price DOUBLE PRECISION NOT NULL, duration INTEGER NOT NULL, CONSTRAINT FK_3EC63EAA3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO destination (id, name, description, price, duration, image_id) SELECT id, name, description, price, duration, image_size FROM __temp__destination');
        $this->addSql('DROP TABLE __temp__destination');
        $this->addSql('CREATE INDEX IDX_3EC63EAA3DA5256D ON destination (image_id)');
        $this->addSql('ALTER TABLE image ADD COLUMN updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__destination AS SELECT id, image_id, name, description, price, duration FROM destination');
        $this->addSql('DROP TABLE destination');
        $this->addSql('CREATE TABLE destination (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, image_size INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, price DOUBLE PRECISION NOT NULL, duration INTEGER NOT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO destination (id, image_size, name, description, price, duration) SELECT id, image_id, name, description, price, duration FROM __temp__destination');
        $this->addSql('DROP TABLE __temp__destination');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, file_path FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, file_path VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO image (id, file_path) SELECT id, file_path FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
    }
}
