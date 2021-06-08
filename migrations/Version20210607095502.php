<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210607095502 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, no_seance_id INT DEFAULT NULL, no_utilisateur_id INT DEFAULT NULL, no_etat_id INT DEFAULT NULL, commentaire LONGTEXT NOT NULL, numero_commentaire INT DEFAULT NULL, filename VARCHAR(50) NOT NULL, INDEX IDX_67F068BC34F5A878 (no_seance_id), INDEX IDX_67F068BCBCA70BBF (no_utilisateur_id), INDEX IDX_67F068BCB34AAA2B (no_etat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire_anonyme (id INT AUTO_INCREMENT NOT NULL, no_prestation_id INT DEFAULT NULL, no_etat_id INT DEFAULT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, date_seance DATE DEFAULT NULL, numero_commentaire INT DEFAULT NULL, commentaire LONGTEXT NOT NULL, filename VARCHAR(50) NOT NULL, INDEX IDX_87ABD7183604ABA (no_prestation_id), INDEX IDX_87ABD718B34AAA2B (no_etat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, etat VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formule (id INT AUTO_INCREMENT NOT NULL, no_prestation_id INT DEFAULT NULL, no_formule_id INT DEFAULT NULL, prix VARCHAR(10) NOT NULL, detail LONGTEXT NOT NULL, INDEX IDX_605C9C983604ABA (no_prestation_id), INDEX IDX_605C9C988303D650 (no_formule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formule_intitule (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, no_utilisateur_id INT DEFAULT NULL, no_rendez_vous_id INT DEFAULT NULL, no_etat_id INT DEFAULT NULL, telechargeable TINYINT(1) NOT NULL, filename VARCHAR(20) NOT NULL, INDEX IDX_14B78418BCA70BBF (no_utilisateur_id), INDEX IDX_14B78418D6C0945A (no_rendez_vous_id), INDEX IDX_14B78418B34AAA2B (no_etat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo_panorama (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo_prestation (id INT AUTO_INCREMENT NOT NULL, no_prestation_id INT DEFAULT NULL, filename VARCHAR(50) NOT NULL, INDEX IDX_1DAC61A53604ABA (no_prestation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestation (id INT AUTO_INCREMENT NOT NULL, menu_deroulant TINYINT(1) NOT NULL, filename VARCHAR(50) NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, no_prestation_id INT DEFAULT NULL, no_utilisateur_id INT DEFAULT NULL, no_etat_commentaire_id INT DEFAULT NULL, no_etat_seance_id INT DEFAULT NULL, no_formule_intitule_id INT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_65E8AA0A3604ABA (no_prestation_id), INDEX IDX_65E8AA0ABCA70BBF (no_utilisateur_id), INDEX IDX_65E8AA0A7E335892 (no_etat_commentaire_id), INDEX IDX_65E8AA0A54C4D688 (no_etat_seance_id), INDEX IDX_65E8AA0A2DE063D (no_formule_intitule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE renseignement (id INT AUTO_INCREMENT NOT NULL, no_prestation_id INT DEFAULT NULL, no_formule_id INT DEFAULT NULL, no_etat_renseignement_id INT DEFAULT NULL, nom VARCHAR(20) NOT NULL, date_renseignement DATE NOT NULL, date_seance DATE NOT NULL, prenom VARCHAR(20) NOT NULL, telephone VARCHAR(20) NOT NULL, mail VARCHAR(50) NOT NULL, detail_projet LONGTEXT DEFAULT NULL, INDEX IDX_A5DA59EE3604ABA (no_prestation_id), INDEX IDX_A5DA59EE8303D650 (no_formule_id), INDEX IDX_A5DA59EE6E107841 (no_etat_renseignement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, telephone VARCHAR(15) NOT NULL, mail VARCHAR(50) NOT NULL, mot_passe VARCHAR(64) NOT NULL, rue VARCHAR(50) DEFAULT NULL, code_postal VARCHAR(10) DEFAULT NULL, ville VARCHAR(30) DEFAULT NULL, date_naissance DATE DEFAULT NULL, admin TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B35126AC48 (mail), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC34F5A878 FOREIGN KEY (no_seance_id) REFERENCES rendez_vous (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCBCA70BBF FOREIGN KEY (no_utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCB34AAA2B FOREIGN KEY (no_etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE commentaire_anonyme ADD CONSTRAINT FK_87ABD7183604ABA FOREIGN KEY (no_prestation_id) REFERENCES prestation (id)');
        $this->addSql('ALTER TABLE commentaire_anonyme ADD CONSTRAINT FK_87ABD718B34AAA2B FOREIGN KEY (no_etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE formule ADD CONSTRAINT FK_605C9C983604ABA FOREIGN KEY (no_prestation_id) REFERENCES prestation (id)');
        $this->addSql('ALTER TABLE formule ADD CONSTRAINT FK_605C9C988303D650 FOREIGN KEY (no_formule_id) REFERENCES formule_intitule (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418BCA70BBF FOREIGN KEY (no_utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418D6C0945A FOREIGN KEY (no_rendez_vous_id) REFERENCES rendez_vous (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418B34AAA2B FOREIGN KEY (no_etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE photo_prestation ADD CONSTRAINT FK_1DAC61A53604ABA FOREIGN KEY (no_prestation_id) REFERENCES prestation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A3604ABA FOREIGN KEY (no_prestation_id) REFERENCES prestation (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0ABCA70BBF FOREIGN KEY (no_utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A7E335892 FOREIGN KEY (no_etat_commentaire_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A54C4D688 FOREIGN KEY (no_etat_seance_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A2DE063D FOREIGN KEY (no_formule_intitule_id) REFERENCES formule_intitule (id)');
        $this->addSql('ALTER TABLE renseignement ADD CONSTRAINT FK_A5DA59EE3604ABA FOREIGN KEY (no_prestation_id) REFERENCES prestation (id)');
        $this->addSql('ALTER TABLE renseignement ADD CONSTRAINT FK_A5DA59EE8303D650 FOREIGN KEY (no_formule_id) REFERENCES formule_intitule (id)');
        $this->addSql('ALTER TABLE renseignement ADD CONSTRAINT FK_A5DA59EE6E107841 FOREIGN KEY (no_etat_renseignement_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCB34AAA2B');
        $this->addSql('ALTER TABLE commentaire_anonyme DROP FOREIGN KEY FK_87ABD718B34AAA2B');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418B34AAA2B');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A7E335892');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A54C4D688');
        $this->addSql('ALTER TABLE renseignement DROP FOREIGN KEY FK_A5DA59EE6E107841');
        $this->addSql('ALTER TABLE formule DROP FOREIGN KEY FK_605C9C988303D650');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A2DE063D');
        $this->addSql('ALTER TABLE renseignement DROP FOREIGN KEY FK_A5DA59EE8303D650');
        $this->addSql('ALTER TABLE commentaire_anonyme DROP FOREIGN KEY FK_87ABD7183604ABA');
        $this->addSql('ALTER TABLE formule DROP FOREIGN KEY FK_605C9C983604ABA');
        $this->addSql('ALTER TABLE photo_prestation DROP FOREIGN KEY FK_1DAC61A53604ABA');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A3604ABA');
        $this->addSql('ALTER TABLE renseignement DROP FOREIGN KEY FK_A5DA59EE3604ABA');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC34F5A878');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418D6C0945A');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCBCA70BBF');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418BCA70BBF');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0ABCA70BBF');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE commentaire_anonyme');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE formule');
        $this->addSql('DROP TABLE formule_intitule');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE photo_panorama');
        $this->addSql('DROP TABLE photo_prestation');
        $this->addSql('DROP TABLE prestation');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE renseignement');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE utilisateur');
    }
}
