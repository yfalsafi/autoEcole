<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190315095634 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pass DROP FOREIGN KEY FK_CE70D42427DAFE17');
        $this->addSql('DROP INDEX IDX_CE70D42427DAFE17 ON pass');
        $this->addSql('ALTER TABLE pass DROP code_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pass ADD code_id INT NOT NULL');
        $this->addSql('ALTER TABLE pass ADD CONSTRAINT FK_CE70D42427DAFE17 FOREIGN KEY (code_id) REFERENCES code (id)');
        $this->addSql('CREATE INDEX IDX_CE70D42427DAFE17 ON pass (code_id)');
    }
}
