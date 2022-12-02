<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221202101748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE consigne_hebergement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, texte LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etage CHANGE numero_etage numero_etage INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE login CHANGE role role VARCHAR(10) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX numero_beneficiaire ON login (numero_beneficiaire)');
        $this->addSql('DROP INDEX `primary` ON participation');
        $this->addSql('ALTER TABLE participation ADD PRIMARY KEY (id_personne, id_formation)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE consigne_hebergement');
        $this->addSql('ALTER TABLE etage CHANGE numero_etage numero_etage INT NOT NULL');
        $this->addSql('DROP INDEX numero_beneficiaire ON login');
        $this->addSql('ALTER TABLE login CHANGE role role VARCHAR(100) NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON participation');
        $this->addSql('ALTER TABLE participation ADD PRIMARY KEY (id_formation, id_personne)');
    }
}
