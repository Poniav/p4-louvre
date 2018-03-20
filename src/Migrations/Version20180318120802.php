<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180318120802 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE booking (id INTEGER NOT NULL, co_firstname VARCHAR(255) NOT NULL, co_lastname VARCHAR(255) NOT NULL, co_email VARCHAR(255) NOT NULL, co_date DATETIME NOT NULL, co_type BOOLEAN NOT NULL, co_number INTEGER NOT NULL, co_code VARCHAR(50) NOT NULL, co_total NUMERIC(2, 0) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tickets (id INTEGER NOT NULL, booking_id INTEGER NOT NULL, co_firstname VARCHAR(255) NOT NULL, co_lastname VARCHAR(255) NOT NULL, co_discount BOOLEAN NOT NULL, co_birth DATETIME NOT NULL, co_country VARCHAR(255) NOT NULL, co_price NUMERIC(2, 0) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_54469DF43301C60 ON tickets (booking_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE tickets');
    }
}
