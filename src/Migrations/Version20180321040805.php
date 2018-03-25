<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180321040805 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, co_firstname VARCHAR(255) NOT NULL, co_lastname VARCHAR(255) NOT NULL, co_email VARCHAR(255) NOT NULL, co_date DATETIME NOT NULL, co_type TINYINT(1) NOT NULL, co_number INT NOT NULL, co_code VARCHAR(50) NOT NULL, co_total NUMERIC(2, 0) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tickets (id INT AUTO_INCREMENT NOT NULL, booking_id INT NOT NULL, co_firstname VARCHAR(255) NOT NULL, co_lastname VARCHAR(255) NOT NULL, co_discount TINYINT(1) NOT NULL, co_birth DATETIME NOT NULL, co_country VARCHAR(255) NOT NULL, co_price NUMERIC(2, 0) NOT NULL, INDEX IDX_54469DF43301C60 (booking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF43301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF43301C60');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE tickets');
    }
}
