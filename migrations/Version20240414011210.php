<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240414011210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, panier_id INT DEFAULT NULL, date_commande DATE NOT NULL, id_user INT NOT NULL, etat VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6EEAA67DF77D927C (panier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_oeuvre (commande_id INT NOT NULL, oeuvre_id INT NOT NULL, INDEX IDX_37AAD52B82EA2E54 (commande_id), INDEX IDX_37AAD52B88194DE8 (oeuvre_id), PRIMARY KEY(commande_id, oeuvre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oeuvre (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, anne_creation VARCHAR(255) NOT NULL, dimention VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, disponibilite TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, accecible VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier_oeuvre (panier_id INT NOT NULL, oeuvre_id INT NOT NULL, INDEX IDX_8007CCE0F77D927C (panier_id), INDEX IDX_8007CCE088194DE8 (oeuvre_id), PRIMARY KEY(panier_id, oeuvre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, id_commande_id INT NOT NULL, etat VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, id_user INT NOT NULL, UNIQUE INDEX UNIQ_6D28840D9AF8E3A3 (id_commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DF77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE commande_oeuvre ADD CONSTRAINT FK_37AAD52B82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_oeuvre ADD CONSTRAINT FK_37AAD52B88194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier_oeuvre ADD CONSTRAINT FK_8007CCE0F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier_oeuvre ADD CONSTRAINT FK_8007CCE088194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D9AF8E3A3 FOREIGN KEY (id_commande_id) REFERENCES commande (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DF77D927C');
        $this->addSql('ALTER TABLE commande_oeuvre DROP FOREIGN KEY FK_37AAD52B82EA2E54');
        $this->addSql('ALTER TABLE commande_oeuvre DROP FOREIGN KEY FK_37AAD52B88194DE8');
        $this->addSql('ALTER TABLE panier_oeuvre DROP FOREIGN KEY FK_8007CCE0F77D927C');
        $this->addSql('ALTER TABLE panier_oeuvre DROP FOREIGN KEY FK_8007CCE088194DE8');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D9AF8E3A3');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_oeuvre');
        $this->addSql('DROP TABLE oeuvre');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE panier_oeuvre');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
