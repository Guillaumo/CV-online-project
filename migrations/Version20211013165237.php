<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211013165237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, heading_id INT NOT NULL, picture VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, place VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_23A0E6662FE64EC (heading_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cv (id INT AUTO_INCREMENT NOT NULL, identity_id INT NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_B66FFE92FF3ED4A8 (identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE heading (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE heading_cv (heading_id INT NOT NULL, cv_id INT NOT NULL, INDEX IDX_6BA8FD2E62FE64EC (heading_id), INDEX IDX_6BA8FD2ECFE419E2 (cv_id), PRIMARY KEY(heading_id, cv_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE identity (id INT AUTO_INCREMENT NOT NULL, picture VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, zipcode VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, state VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6662FE64EC FOREIGN KEY (heading_id) REFERENCES heading (id)');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT FK_B66FFE92FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES identity (id)');
        $this->addSql('ALTER TABLE heading_cv ADD CONSTRAINT FK_6BA8FD2E62FE64EC FOREIGN KEY (heading_id) REFERENCES heading (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE heading_cv ADD CONSTRAINT FK_6BA8FD2ECFE419E2 FOREIGN KEY (cv_id) REFERENCES cv (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE heading_cv DROP FOREIGN KEY FK_6BA8FD2ECFE419E2');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6662FE64EC');
        $this->addSql('ALTER TABLE heading_cv DROP FOREIGN KEY FK_6BA8FD2E62FE64EC');
        $this->addSql('ALTER TABLE cv DROP FOREIGN KEY FK_B66FFE92FF3ED4A8');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE cv');
        $this->addSql('DROP TABLE heading');
        $this->addSql('DROP TABLE heading_cv');
        $this->addSql('DROP TABLE identity');
    }
}
