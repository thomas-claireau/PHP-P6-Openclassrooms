<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200209134613 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE main_picture (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE figures ADD main_picture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE figures ADD CONSTRAINT FK_ABF1009AD6BDC9DC FOREIGN KEY (main_picture_id) REFERENCES main_picture (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ABF1009AD6BDC9DC ON figures (main_picture_id)');
        $this->addSql('ALTER TABLE picture CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE token token VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE figures DROP FOREIGN KEY FK_ABF1009AD6BDC9DC');
        $this->addSql('DROP TABLE main_picture');
        $this->addSql('DROP INDEX UNIQ_ABF1009AD6BDC9DC ON figures');
        $this->addSql('ALTER TABLE figures DROP main_picture_id');
        $this->addSql('ALTER TABLE picture CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE token token VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
