<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190307161701 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car ADD id INT AUTO_INCREMENT NOT NULL, ADD purchased_at DATETIME NOT NULL, ADD is_available TINYINT(1) NOT NULL, DROP idCar, DROP purchaseDate, DROP km, ADD PRIMARY KEY (id)');
//        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF642186A73 FOREIGN KEY (idc_id) REFERENCES fos_user (id)');
//        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF62DA58A17 FOREIGN KEY (idi_id) REFERENCES fos_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE car DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE car ADD idCar INT NOT NULL, ADD purchaseDate DATE DEFAULT NULL, ADD km INT DEFAULT NULL, DROP id, DROP purchased_at, DROP is_available');
        $this->addSql('ALTER TABLE instructor CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF642186A73');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF62DA58A17');
    }
}
