<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190313151139 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE code ADD image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE instructor CHANGE id id INT AUTO_INCREMENT NOT NULL');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE code DROP image');
        $this->addSql('ALTER TABLE instructor CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF642186A73');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF62DA58A17');
    }
}
