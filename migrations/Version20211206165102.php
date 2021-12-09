<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211206165102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(32) NOT NULL, escudo VARCHAR(255) NOT NULL, limite_salarial DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE empleado (id INT AUTO_INCREMENT NOT NULL, club_id INT NOT NULL, nombre VARCHAR(32) NOT NULL, email VARCHAR(32) NOT NULL, telefono VARCHAR(32) DEFAULT NULL, salario DOUBLE PRECISION DEFAULT NULL, fecha_nacimiento DATE NOT NULL, posicion SMALLINT DEFAULT NULL, tipo_empleado SMALLINT NOT NULL, INDEX IDX_D9D9BF5261190A32 (club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF5261190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF5261190A32');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE empleado');
    }
}
