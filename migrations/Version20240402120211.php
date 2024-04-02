<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402120211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, page_id INT NOT NULL, type_id INT NOT NULL, title VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, ordre INT NOT NULL, parameters JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', col_width INT NOT NULL, INDEX IDX_C242628C4663E4 (page_id), INDEX IDX_C242628C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, type_id INT NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, ordre INT NOT NULL, parameters JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', date_creation DATE NOT NULL, INDEX IDX_140AB620727ACA70 (parent_id), INDEX IDX_140AB620C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_module (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_page (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, is_special TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628C54C8C93 FOREIGN KEY (type_id) REFERENCES type_module (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620727ACA70 FOREIGN KEY (parent_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620C54C8C93 FOREIGN KEY (type_id) REFERENCES type_page (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628C4663E4');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628C54C8C93');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620727ACA70');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620C54C8C93');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE type_module');
        $this->addSql('DROP TABLE type_page');
    }
}
