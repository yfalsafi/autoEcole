<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190314144300 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pass (id INT AUTO_INCREMENT NOT NULL, code_id INT NOT NULL, user_id INT NOT NULL, pass_at DATETIME NOT NULL, errors INT NOT NULL, INDEX IDX_CE70D42427DAFE17 (code_id), INDEX IDX_CE70D424A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pass ADD CONSTRAINT FK_CE70D42427DAFE17 FOREIGN KEY (code_id) REFERENCES code (id)');
        $this->addSql('ALTER TABLE pass ADD CONSTRAINT FK_CE70D424A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE code DROP question2');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF642186A73 FOREIGN KEY (idc_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF62DA58A17 FOREIGN KEY (idi_id) REFERENCES fos_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE pass');
        $this->addSql('ALTER TABLE code ADD question2 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF642186A73');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF62DA58A17');
    }
}
