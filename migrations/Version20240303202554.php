<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303202554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FCCFA12B8');
        $this->addSql('DROP INDEX UNIQ_8157AA0FCCFA12B8 ON profile');
        $this->addSql('ALTER TABLE profile ADD name_entreprise VARCHAR(255) DEFAULT NULL, DROP profile_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile ADD profile_id INT DEFAULT NULL, DROP name_entreprise');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FCCFA12B8 FOREIGN KEY (profile_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0FCCFA12B8 ON profile (profile_id)');
    }
}
