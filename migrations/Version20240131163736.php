<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240131163736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__destination AS SELECT id, name, description, price, duration FROM destination');
        $this->addSql('DROP TABLE destination');
        $this->addSql('CREATE TABLE destination (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, price DOUBLE PRECISION NOT NULL, duration INTEGER NOT NULL, image VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO destination (id, name, description, price, duration) SELECT id, name, description, price, duration FROM __temp__destination');
        $this->addSql('DROP TABLE __temp__destination');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, file_path, updated_at FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO image (id, file_path, updated_at) SELECT id, file_path, updated_at FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__destination AS SELECT id, name, description, price, duration FROM destination');
        $this->addSql('DROP TABLE destination');
        $this->addSql('CREATE TABLE destination (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, image_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, price DOUBLE PRECISION NOT NULL, duration INTEGER NOT NULL, CONSTRAINT FK_3EC63EAA3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO destination (id, name, description, price, duration) SELECT id, name, description, price, duration FROM __temp__destination');
        $this->addSql('DROP TABLE __temp__destination');
        $this->addSql('CREATE INDEX IDX_3EC63EAA3DA5256D ON destination (image_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, file_path, updated_at FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO image (id, file_path, updated_at) SELECT id, file_path, updated_at FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
    }
}
