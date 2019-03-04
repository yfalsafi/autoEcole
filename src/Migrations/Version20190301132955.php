<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190301132955 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, package_id INT NOT NULL, buy_at DATETIME NOT NULL, quantity INT DEFAULT NULL, INDEX IDX_6117D13BA76ED395 (user_id), INDEX IDX_6117D13BF44CABFF (package_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BF44CABFF FOREIGN KEY (package_id) REFERENCES package (id)');
        $this->addSql('ALTER TABLE package CHANGE content content LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE purchase');
        $this->addSql('ALTER TABLE package CHANGE content content VARCHAR(300) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
