<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190227103937 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE instructor (id_instructor INT AUTO_INCREMENT NOT NULL, surname VARCHAR(50) DEFAULT NULL, firstname VARCHAR(50) DEFAULT NULL, adress VARCHAR(250) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, hiringDate DATE DEFAULT NULL, status VARCHAR(1) DEFAULT NULL, PRIMARY KEY(id_instructor)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE package (id_package INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, content VARCHAR(300) DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id_package)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, instructor INT DEFAULT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, birth DATE NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, status VARCHAR(10) DEFAULT NULL, register_at DATETIME NOT NULL, is_instructor TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token), INDEX IDX_957A647931FC43DD (instructor), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, status CHAR(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidate (id_candidate INT NOT NULL, surname VARCHAR(50) DEFAULT NULL, firstname VARCHAR(50) DEFAULT NULL, adress VARCHAR(150) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, status VARCHAR(50) NOT NULL, registration_date DATETIME DEFAULT NULL, idi INT NOT NULL, PRIMARY KEY(id_candidate)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car (id_car INT NOT NULL, idI INT NOT NULL, purchaseDate DATE DEFAULT NULL, km INT DEFAULT NULL, INDEX idI (idI), PRIMARY KEY(id_car, idI)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, idc_id INT NOT NULL, idi_id INT NOT NULL, idl_id INT DEFAULT NULL, INDEX IDX_D499BFF642186A73 (idc_id), INDEX IDX_D499BFF62DA58A17 (idi_id), INDEX IDX_D499BFF61A7B7A25 (idl_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fos_user ADD CONSTRAINT FK_957A647931FC43DD FOREIGN KEY (instructor) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF642186A73 FOREIGN KEY (idc_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF62DA58A17 FOREIGN KEY (idi_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF61A7B7A25 FOREIGN KEY (idl_id) REFERENCES lesson (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fos_user DROP FOREIGN KEY FK_957A647931FC43DD');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF642186A73');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF62DA58A17');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF61A7B7A25');
        $this->addSql('DROP TABLE instructor');
        $this->addSql('DROP TABLE package');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE candidate');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE planning');
    }
}
