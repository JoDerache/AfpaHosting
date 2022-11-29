<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221121155622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avertissement (id_avertissement INT AUTO_INCREMENT NOT NULL, id_incident INT DEFAULT NULL, date_avertissement DATE NOT NULL, UNIQUE INDEX avertissement_incident_AK (id_incident), PRIMARY KEY(id_avertissement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bail (id_bail INT AUTO_INCREMENT NOT NULL, id_personne INT DEFAULT NULL, numero_chambre INT DEFAULT NULL, date_entree DATE NOT NULL, date_sortie DATE NOT NULL, INDEX bail_personne0_FK (id_personne), INDEX bail_chambre_FK (numero_chambre), PRIMARY KEY(id_bail)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chambre (numero_chambre INT AUTO_INCREMENT NOT NULL, numero_etage INT DEFAULT NULL, numero_clefs VARCHAR(10) NOT NULL, condamne TINYINT(1) NOT NULL, INDEX chambre_etage_FK (numero_etage), PRIMARY KEY(numero_chambre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etage (numero_etage INT AUTO_INCREMENT NOT NULL, reserver_femme TINYINT(1) NOT NULL, PRIMARY KEY(numero_etage)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat_des_lieux (id_etat_lieux INT AUTO_INCREMENT NOT NULL, id_type_etat_lieux INT DEFAULT NULL, id_bail INT DEFAULT NULL, date DATE NOT NULL, commentaire LONGTEXT NOT NULL, INDEX etat_des_lieux_type_etat_lieux0_FK (id_type_etat_lieux), INDEX etat_des_lieux_bail_FK (id_bail), PRIMARY KEY(id_etat_lieux)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (annee INT NOT NULL, numero_facture INT NOT NULL, id_bail INT DEFAULT NULL, id_paiement INT DEFAULT NULL, montant_total INT NOT NULL, montant_deja_reglee INT NOT NULL, montant_a_percevoir INT NOT NULL, date_de_paiement DATE NOT NULL, date_facturation DATE NOT NULL, INDEX facture_type_paiement0_FK (id_paiement), INDEX facture_bail_FK (id_bail), PRIMARY KEY(annee, numero_facture)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE financeur (id_financeur INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id_financeur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formations (id_formation INT AUTO_INCREMENT NOT NULL, nom_formation VARCHAR(255) NOT NULL, numero_offre INT NOT NULL, PRIMARY KEY(id_formation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incident (id_incident INT AUTO_INCREMENT NOT NULL, id_bail INT DEFAULT NULL, id_type_incident INT DEFAULT NULL, date DATE NOT NULL, commentaire LONGTEXT NOT NULL, INDEX incident_bail_FK (id_bail), INDEX incident_type_incident0_FK (id_type_incident), PRIMARY KEY(id_incident)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE login (id_login INT AUTO_INCREMENT NOT NULL, numero_beneficiaire INT NOT NULL, mdp CHAR(100) NOT NULL, PRIMARY KEY(id_login)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages (id_message INT AUTO_INCREMENT NOT NULL, id_personne INT DEFAULT NULL, contenu LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX messages_personne_FK (id_personne), PRIMARY KEY(id_message)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parametre (id_parametre INT AUTO_INCREMENT NOT NULL, loyer NUMERIC(10, 0) NOT NULL, caution NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id_parametre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (id_formation INT NOT NULL, id_personne INT NOT NULL, id_financeur INT DEFAULT NULL, date_entree DATE NOT NULL, date_sortie DATE NOT NULL, INDEX participation_personne0_FK (id_personne), INDEX participation_financeur1_FK (id_financeur), INDEX IDX_AB55E24FC0759D98 (id_formation), PRIMARY KEY(id_formation, id_personne)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id_personne INT AUTO_INCREMENT NOT NULL, id_login INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse_postale VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, badge VARCHAR(255) NOT NULL, numero_beneficiaire VARCHAR(50) NOT NULL, is_blacklisted TINYINT(1) NOT NULL, lieu_naissance VARCHAR(255) NOT NULL, UNIQUE INDEX personne_login_AK (id_login), PRIMARY KEY(id_personne)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne_a_contacter (id_personne_contact INT AUTO_INCREMENT NOT NULL, id_personne INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone INT NOT NULL, INDEX personne_a_contacter_personne_FK (id_personne), PRIMARY KEY(id_personne_contact)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE travaux (id_travaux INT AUTO_INCREMENT NOT NULL, id_travaux_type_travaux INT DEFAULT NULL, numero_chambre INT DEFAULT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, commentaire_travaux LONGTEXT NOT NULL, INDEX travaux_chambre0_FK (numero_chambre), INDEX travaux_type_travaux_FK (id_travaux_type_travaux), PRIMARY KEY(id_travaux)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_etat_lieux (id_type_etat_lieux INT AUTO_INCREMENT NOT NULL, nom_etat_lieux VARCHAR(30) NOT NULL, PRIMARY KEY(id_type_etat_lieux)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_incident (id_type_incident INT AUTO_INCREMENT NOT NULL, nom_type_incident VARCHAR(255) NOT NULL, PRIMARY KEY(id_type_incident)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_paiement (id_paiement INT AUTO_INCREMENT NOT NULL, nom_paiement VARCHAR(50) NOT NULL, PRIMARY KEY(id_paiement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_travaux (id_travaux INT AUTO_INCREMENT NOT NULL, nom_travaux VARCHAR(255) NOT NULL, PRIMARY KEY(id_travaux)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avertissement ADD CONSTRAINT FK_8C10BF266DD84D8F FOREIGN KEY (id_incident) REFERENCES incident (id_incident)');
        $this->addSql('ALTER TABLE bail ADD CONSTRAINT FK_945BC1E5F15257A FOREIGN KEY (id_personne) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE bail ADD CONSTRAINT FK_945BC1E35DFA5E FOREIGN KEY (numero_chambre) REFERENCES chambre (numero_chambre)');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FF8283DA76 FOREIGN KEY (numero_etage) REFERENCES etage (numero_etage)');
        $this->addSql('ALTER TABLE etat_des_lieux ADD CONSTRAINT FK_F72103122C8E91BA FOREIGN KEY (id_type_etat_lieux) REFERENCES type_etat_lieux (id_type_etat_lieux)');
        $this->addSql('ALTER TABLE etat_des_lieux ADD CONSTRAINT FK_F72103128265A01C FOREIGN KEY (id_bail) REFERENCES bail (id_bail)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664108265A01C FOREIGN KEY (id_bail) REFERENCES bail (id_bail)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410E107968B FOREIGN KEY (id_paiement) REFERENCES type_paiement (id_paiement)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A8265A01C FOREIGN KEY (id_bail) REFERENCES bail (id_bail)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A4ED45783 FOREIGN KEY (id_type_incident) REFERENCES type_incident (id_type_incident)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E965F15257A FOREIGN KEY (id_personne) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F330E05D9 FOREIGN KEY (id_financeur) REFERENCES financeur (id_financeur)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FC0759D98 FOREIGN KEY (id_formation) REFERENCES formations (id_formation)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F5F15257A FOREIGN KEY (id_personne) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EF448D8A20 FOREIGN KEY (id_login) REFERENCES login (id_login)');
        $this->addSql('ALTER TABLE personne_a_contacter ADD CONSTRAINT FK_EAF2D6F75F15257A FOREIGN KEY (id_personne) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE travaux ADD CONSTRAINT FK_6C24F39B2F871742 FOREIGN KEY (id_travaux_type_travaux) REFERENCES type_travaux (id_travaux)');
        $this->addSql('ALTER TABLE travaux ADD CONSTRAINT FK_6C24F39B35DFA5E FOREIGN KEY (numero_chambre) REFERENCES chambre (numero_chambre)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avertissement DROP FOREIGN KEY FK_8C10BF266DD84D8F');
        $this->addSql('ALTER TABLE bail DROP FOREIGN KEY FK_945BC1E5F15257A');
        $this->addSql('ALTER TABLE bail DROP FOREIGN KEY FK_945BC1E35DFA5E');
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FF8283DA76');
        $this->addSql('ALTER TABLE etat_des_lieux DROP FOREIGN KEY FK_F72103122C8E91BA');
        $this->addSql('ALTER TABLE etat_des_lieux DROP FOREIGN KEY FK_F72103128265A01C');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664108265A01C');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410E107968B');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A8265A01C');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A4ED45783');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E965F15257A');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F330E05D9');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FC0759D98');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F5F15257A');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EF448D8A20');
        $this->addSql('ALTER TABLE personne_a_contacter DROP FOREIGN KEY FK_EAF2D6F75F15257A');
        $this->addSql('ALTER TABLE travaux DROP FOREIGN KEY FK_6C24F39B2F871742');
        $this->addSql('ALTER TABLE travaux DROP FOREIGN KEY FK_6C24F39B35DFA5E');
        $this->addSql('DROP TABLE avertissement');
        $this->addSql('DROP TABLE bail');
        $this->addSql('DROP TABLE chambre');
        $this->addSql('DROP TABLE etage');
        $this->addSql('DROP TABLE etat_des_lieux');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE financeur');
        $this->addSql('DROP TABLE formations');
        $this->addSql('DROP TABLE incident');
        $this->addSql('DROP TABLE login');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE parametre');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE personne_a_contacter');
        $this->addSql('DROP TABLE travaux');
        $this->addSql('DROP TABLE type_etat_lieux');
        $this->addSql('DROP TABLE type_incident');
        $this->addSql('DROP TABLE type_paiement');
        $this->addSql('DROP TABLE type_travaux');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
