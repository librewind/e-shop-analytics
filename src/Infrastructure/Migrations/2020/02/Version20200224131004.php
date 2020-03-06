<?php

declare(strict_types=1);

namespace Infrastructure\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200224131004 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE fact_sale_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE fact_sale (id INT NOT NULL, date DATE NOT NULL, customer_id INT NOT NULL, customer_first_name VARCHAR(255) NOT NULL, customer_last_name VARCHAR(255) NOT NULL, customer_date_of_birth DATE NOT NULL, product_id INT NOT NULL, product_sku VARCHAR(255) NOT NULL, product_name VARCHAR(255) NOT NULL, quantity INT NOT NULL, net_price DOUBLE PRECISION NOT NULL, discount_price DOUBLE PRECISION NOT NULL, promotion_id INT DEFAULT NULL, promotion_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN fact_sale.date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN fact_sale.customer_date_of_birth IS \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE fact_sale_id_seq CASCADE');
        $this->addSql('DROP TABLE fact_sale');
    }
}
