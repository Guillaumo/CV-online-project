<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211014170841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin ADD identity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES identity (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76FF3ED4A8 ON admin (identity_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76FF3ED4A8');
        $this->addSql('DROP INDEX UNIQ_880E0D76FF3ED4A8 ON admin');
        $this->addSql('ALTER TABLE admin DROP identity_id');
    }
}
