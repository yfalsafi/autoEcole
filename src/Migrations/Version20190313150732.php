<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190313150732 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE code (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, a VARCHAR(255) NOT NULL, b VARCHAR(255) NOT NULL, question2 VARCHAR(255) DEFAULT NULL, c VARCHAR(255) DEFAULT NULL, d VARCHAR(255) DEFAULT NULL, answer VARCHAR(5) NOT NULL, justification LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
//        $this->addSql('ALTER TABLE instructor CHANGE id id INT AUTO_INCREMENT NOT NULL');
//        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF642186A73 FOREIGN KEY (idc_id) REFERENCES fos_user (id)');
//        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF62DA58A17 FOREIGN KEY (idi_id) REFERENCES fos_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE code');
        $this->addSql('ALTER TABLE instructor CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF642186A73');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF62DA58A17');
    }
}
