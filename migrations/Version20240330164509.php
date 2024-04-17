<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240330164509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mise ADD id_enchere INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mise ADD CONSTRAINT FK_96C4BF8FE64C2E7F FOREIGN KEY (id_enchere) REFERENCES enchere (id)');
        $this->addSql('CREATE INDEX IDX_96C4BF8FE64C2E7F ON mise (id_enchere)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mise DROP FOREIGN KEY FK_96C4BF8FE64C2E7F');
        $this->addSql('DROP INDEX IDX_96C4BF8FE64C2E7F ON mise');
        $this->addSql('ALTER TABLE mise DROP id_enchere');
    }
}
