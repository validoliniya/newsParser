<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415131420 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, resource_id INT NOT NULL, header VARCHAR(500) NOT NULL, INDEX IDX_23A0E6689329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_content (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, content LONGTEXT NOT NULL, img_sources LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_1317741E7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_resource (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6689329D25 FOREIGN KEY (resource_id) REFERENCES news_resource (id)');
        $this->addSql('ALTER TABLE article_content ADD CONSTRAINT FK_1317741E7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_content DROP FOREIGN KEY FK_1317741E7294869C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6689329D25');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_content');
        $this->addSql('DROP TABLE news_resource');
    }
}
