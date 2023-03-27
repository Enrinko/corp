<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327142448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE individual (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, patronymic VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE individual_users (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, individual_id INT NOT NULL, UNIQUE INDEX UNIQ_46238545A76ED395 (user_id), UNIQUE INDEX UNIQ_46238545AE271C0D (individual_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE legal (id INT AUTO_INCREMENT NOT NULL, inn VARCHAR(255) NOT NULL, company_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE legal_users (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, legal_id INT NOT NULL, UNIQUE INDEX UNIQ_41ABF828A76ED395 (user_id), UNIQUE INDEX UNIQ_41ABF82862BB3C59 (legal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE individual_users ADD CONSTRAINT FK_46238545A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE individual_users ADD CONSTRAINT FK_46238545AE271C0D FOREIGN KEY (individual_id) REFERENCES individual (id)');
        $this->addSql('ALTER TABLE legal_users ADD CONSTRAINT FK_41ABF828A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE legal_users ADD CONSTRAINT FK_41ABF82862BB3C59 FOREIGN KEY (legal_id) REFERENCES legal (id)');
        $this->addSql('ALTER TABLE user ADD is_agreed TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE individual_users DROP FOREIGN KEY FK_46238545A76ED395');
        $this->addSql('ALTER TABLE individual_users DROP FOREIGN KEY FK_46238545AE271C0D');
        $this->addSql('ALTER TABLE legal_users DROP FOREIGN KEY FK_41ABF828A76ED395');
        $this->addSql('ALTER TABLE legal_users DROP FOREIGN KEY FK_41ABF82862BB3C59');
        $this->addSql('DROP TABLE individual');
        $this->addSql('DROP TABLE individual_users');
        $this->addSql('DROP TABLE legal');
        $this->addSql('DROP TABLE legal_users');
        $this->addSql('ALTER TABLE `user` DROP is_agreed');
    }
}
