<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412130333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE enchers');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE exposition');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE mise');
        $this->addSql('DROP TABLE oeuvre');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE participant_chat');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE portfolio');
        $this->addSql('DROP TABLE rate');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id_utilisateur INT DEFAULT NULL, id_Commande INT AUTO_INCREMENT NOT NULL, Prix_total DOUBLE PRECISION NOT NULL, date_creation_commande MEDIUMTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, id_Panier INT DEFAULT NULL, id_Payment INT DEFAULT NULL, INDEX id_utilisateur (id_utilisateur), INDEX fk_payment (id_Payment), INDEX fk_panier (id_Panier), PRIMARY KEY(id_Commande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE conversation (conversation_id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, sujet VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, conversation_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, visibilite VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(conversation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE enchers (id_enchers INT AUTO_INCREMENT NOT NULL, id_utilisateur INT DEFAULT NULL, type_oeuvre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, min_montant DOUBLE PRECISION NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX fk_enchers (id_utilisateur), PRIMARY KEY(id_enchers)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE evenement (Id INT AUTO_INCREMENT NOT NULL, Nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, Date_debut DATE NOT NULL, Date_fin DATE NOT NULL, Description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, Type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE exposition (id_portfolio INT DEFAULT NULL, id_Exposition INT AUTO_INCREMENT NOT NULL, image_affiche VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_debut DATE NOT NULL, date_fin DATE NOT NULL, type_expo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, localisation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX fk_portfolioexpo (id_portfolio), PRIMARY KEY(id_Exposition)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE message (message_id INT AUTO_INCREMENT NOT NULL, id_utilisateur INT DEFAULT NULL, conversation_id INT DEFAULT NULL, date_envoi DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, contenu VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX fk_utilisateur (id_utilisateur), INDEX fk_conversation (conversation_id), PRIMARY KEY(message_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE mise (id_mise INT AUTO_INCREMENT NOT NULL, id_enchers INT DEFAULT NULL, id_utilisateur INT DEFAULT NULL, max_montant DOUBLE PRECISION NOT NULL, INDEX fk_encher (id_enchers), INDEX fk_user (id_utilisateur), PRIMARY KEY(id_mise)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oeuvre (id_portfolio INT DEFAULT NULL, id_Oeuvre INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image_oeuvre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_creation DATE NOT NULL, dimension VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prix DOUBLE PRECISION NOT NULL, disponibilite TINYINT(1) NOT NULL, quantite INT DEFAULT 1, categorie VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX fk_portfolio (id_portfolio), PRIMARY KEY(id_Oeuvre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE panier (id_Panier INT AUTO_INCREMENT NOT NULL, Nbr_Commande INT NOT NULL, PRIMARY KEY(id_Panier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participant (id_participant INT AUTO_INCREMENT NOT NULL, id_evenement INT DEFAULT NULL, id_utilisateur INT DEFAULT NULL, INDEX fk_participant (id_utilisateur), INDEX fk_event (id_evenement), PRIMARY KEY(id_participant)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participant_chat (participant_id INT AUTO_INCREMENT NOT NULL, conversation_id INT DEFAULT NULL, id_utilisateur INT DEFAULT NULL, INDEX fk_conversationa (conversation_id), INDEX fk_usera (id_utilisateur), PRIMARY KEY(participant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE payment (id_Payment INT AUTO_INCREMENT NOT NULL, Montant DOUBLE PRECISION NOT NULL, type_Payment VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id_Payment)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE portfolio (id_portfolio INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, nom_Artistique VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, imageUrl VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, biographie VARCHAR(1000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, debut_carriere DATE NOT NULL, reseau_sociaux VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX uk_oeuvre (id_user), PRIMARY KEY(id_portfolio)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE rate (id_rate INT AUTO_INCREMENT NOT NULL, id_oeuvre INT DEFAULT NULL, rateNote DOUBLE PRECISION NOT NULL, id_user INT NOT NULL, INDEX rk_oeuvre (id_oeuvre), PRIMARY KEY(id_rate)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
    }
}
