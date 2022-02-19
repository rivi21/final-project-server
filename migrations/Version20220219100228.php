<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220219100228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agent (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(64) NOT NULL, last_name VARCHAR(64) NOT NULL, address VARCHAR(255) NOT NULL, country VARCHAR(64) NOT NULL, phone_number VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_268B9C9DE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E093414710B');
        $this->addSql('DROP TABLE agent');
        $this->addSql('ALTER TABLE customer CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE address address VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE country country VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone_number phone_number VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE web web VARCHAR(64) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE delivery CHANGE shipping_conditions shipping_conditions VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE invoice CHANGE payment_terms payment_terms VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE product CHANGE type type VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE model model VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE stock stock VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
