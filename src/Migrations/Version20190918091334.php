<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190918091334 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, city VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, house_number VARCHAR(255) NOT NULL, zipcode VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5E9E89CBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADB5B63A6B FOREIGN KEY (vat_id) REFERENCES vat (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADB5B63A6B ON product (vat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE location');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADB5B63A6B');
        $this->addSql('DROP INDEX IDX_D34A04ADB5B63A6B ON product');
    }
}
