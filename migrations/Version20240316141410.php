<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240316141410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dispo (id INT AUTO_INCREMENT NOT NULL, dispo DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dispo_user (dispo_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_EAC7511BA18C1CC9 (dispo_id), INDEX IDX_EAC7511BA76ED395 (user_id), PRIMARY KEY(dispo_id, user_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dispo_user ADD CONSTRAINT FK_EAC7511BA18C1CC9 FOREIGN KEY (dispo_id) REFERENCES dispo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dispo_user ADD CONSTRAINT FK_EAC7511BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dispo_user DROP FOREIGN KEY FK_EAC7511BA18C1CC9');
        $this->addSql('ALTER TABLE dispo_user DROP FOREIGN KEY FK_EAC7511BA76ED395');
        $this->addSql('DROP TABLE dispo');
        $this->addSql('DROP TABLE dispo_user');
    }
}
