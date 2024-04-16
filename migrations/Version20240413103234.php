<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240413103234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portfolio ADD id_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE portfolio ADD CONSTRAINT FK_A9ED106279F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A9ED106279F37AE5 ON portfolio (id_user_id)');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(255) NOT NULL, DROP roles');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portfolio DROP FOREIGN KEY FK_A9ED106279F37AE5');
        $this->addSql('DROP INDEX UNIQ_A9ED106279F37AE5 ON portfolio');
        $this->addSql('ALTER TABLE portfolio DROP id_user_id');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL COMMENT \'(DC2Type:json)\', DROP role');
    }
}
