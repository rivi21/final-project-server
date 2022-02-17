<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220217202208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, agent_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, country VARCHAR(64) NOT NULL, phone_number VARCHAR(64) NOT NULL, email VARCHAR(64) NOT NULL, web VARCHAR(64) DEFAULT NULL, INDEX IDX_81398E0946EAB62F (agent_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery (id INT AUTO_INCREMENT NOT NULL, order_id_id INT NOT NULL, shipping_date DATE NOT NULL, delivery_date DATE NOT NULL, shipping_coditions VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3781EC10FCDAEAAA (order_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, order_id_id INT NOT NULL, payment_term VARCHAR(255) NOT NULL, total_price DOUBLE PRECISION NOT NULL, due_date DATE NOT NULL, UNIQUE INDEX UNIQ_90651744FCDAEAAA (order_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, customer_id_id INT NOT NULL, product_id_id INT NOT NULL, date DATE NOT NULL, INDEX IDX_F5299398B171EB6C (customer_id_id), INDEX IDX_F5299398DE18E50B (product_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(128) NOT NULL, model VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, stock INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shopping_cart_item (id INT AUTO_INCREMENT NOT NULL, customer_id_id INT NOT NULL, product_id_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_E59A1DF4B171EB6C (customer_id_id), INDEX IDX_E59A1DF4DE18E50B (product_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E0946EAB62F FOREIGN KEY (agent_id_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC10FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398B171EB6C FOREIGN KEY (customer_id_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398DE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE shopping_cart_item ADD CONSTRAINT FK_E59A1DF4B171EB6C FOREIGN KEY (customer_id_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE shopping_cart_item ADD CONSTRAINT FK_E59A1DF4DE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398B171EB6C');
        $this->addSql('ALTER TABLE shopping_cart_item DROP FOREIGN KEY FK_E59A1DF4B171EB6C');
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC10FCDAEAAA');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744FCDAEAAA');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398DE18E50B');
        $this->addSql('ALTER TABLE shopping_cart_item DROP FOREIGN KEY FK_E59A1DF4DE18E50B');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE shopping_cart_item');
        $this->addSql('ALTER TABLE agent CHANGE name name VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE last_name last_name VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE address address VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone_number phone_number VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
