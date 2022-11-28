<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221128101016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX Existe ON login');
        $this->addSql('DROP INDEX `primary` ON participation');
        $this->addSql('ALTER TABLE participation ADD PRIMARY KEY (id_personne, id_formation)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX Existe ON login (numero_beneficiaire)');
        $this->addSql('DROP INDEX `PRIMARY` ON participation');
        $this->addSql('ALTER TABLE participation ADD PRIMARY KEY (id_formation, id_personne)');
    }
}
