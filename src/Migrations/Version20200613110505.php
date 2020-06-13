<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200613110505 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE episode CHANGE season_id season_id INT DEFAULT NULL, CHANGE number number INT DEFAULT NULL');
        $this->addSql('ALTER TABLE program ADD slug LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE season CHANGE number number INT DEFAULT NULL, CHANGE year year INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE episode CHANGE season_id season_id INT DEFAULT NULL, CHANGE number number INT DEFAULT NULL');
        $this->addSql('ALTER TABLE program DROP slug');
        $this->addSql('ALTER TABLE season CHANGE number number INT DEFAULT NULL, CHANGE year year INT DEFAULT NULL');
    }
}
