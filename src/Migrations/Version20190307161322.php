<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190307161322 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');


        $this->addSql('ALTER TABLE fos_user ADD instructor INT DEFAULT NULL, ADD status VARCHAR(10) DEFAULT NULL, ADD is_instructor TINYINT(1) DEFAULT NULL, ADD hours_done INT DEFAULT NULL, ADD hours_left INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fos_user ADD CONSTRAINT FK_957A647931FC43DD FOREIGN KEY (instructor) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_957A647931FC43DD ON fos_user (instructor)');
        $this->addSql('ALTER TABLE candidate DROP FOREIGN KEY FK_C8B28E448C4FC193');
        $this->addSql('ALTER TABLE candidate DROP FOREIGN KEY FK_C8B28E44BF396750');
        $this->addSql('DROP INDEX IDX_C8B28E448C4FC193 ON candidate');
        $this->addSql('ALTER TABLE candidate DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE candidate ADD id_candidate INT NOT NULL, ADD surname VARCHAR(50) DEFAULT NULL, ADD firstname VARCHAR(50) DEFAULT NULL, ADD adress VARCHAR(150) DEFAULT NULL, ADD city VARCHAR(50) DEFAULT NULL, ADD registration_date DATETIME DEFAULT NULL, ADD idi INT NOT NULL, DROP id, DROP instructor_id, DROP hours_done, DROP hours_left, CHANGE status status VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE candidate ADD PRIMARY KEY (id_candidate)');
        $this->addSql('ALTER TABLE car ADD id INT AUTO_INCREMENT NOT NULL, ADD purchased_at DATETIME NOT NULL, ADD is_available TINYINT(1) NOT NULL, DROP idCar, DROP idI, DROP purchaseDate, DROP km, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF642186A73 FOREIGN KEY (idc_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF62DA58A17 FOREIGN KEY (idi_id) REFERENCES fos_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE candidate DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE candidate ADD id INT NOT NULL, ADD instructor_id INT DEFAULT NULL, ADD hours_done INT NOT NULL, ADD hours_left INT NOT NULL, DROP id_candidate, DROP surname, DROP firstname, DROP adress, DROP city, DROP registration_date, DROP idi, CHANGE status status VARCHAR(15) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE candidate ADD CONSTRAINT FK_C8B28E448C4FC193 FOREIGN KEY (instructor_id) REFERENCES instructor (id)');
        $this->addSql('ALTER TABLE candidate ADD CONSTRAINT FK_C8B28E44BF396750 FOREIGN KEY (id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_C8B28E448C4FC193 ON candidate (instructor_id)');
        $this->addSql('ALTER TABLE candidate ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE car MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE car DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE car ADD idCar INT NOT NULL, ADD idI INT NOT NULL, ADD purchaseDate DATE DEFAULT NULL, ADD km INT DEFAULT NULL, DROP id, DROP purchased_at, DROP is_available');
        $this->addSql('CREATE INDEX idI ON car (idI)');
        $this->addSql('ALTER TABLE fos_user DROP FOREIGN KEY FK_957A647931FC43DD');
        $this->addSql('DROP INDEX IDX_957A647931FC43DD ON fos_user');
        $this->addSql('ALTER TABLE fos_user ADD dtype VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP instructor, DROP status, DROP is_instructor, DROP hours_done, DROP hours_left');
        $this->addSql('ALTER TABLE instructor ADD car_id INT DEFAULT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE instructor ADD CONSTRAINT FK_31FC43DDBF396750 FOREIGN KEY (id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF642186A73');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF62DA58A17');
    }
}
