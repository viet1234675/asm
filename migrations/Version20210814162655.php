<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210814162655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classroom (id INT AUTO_INCREMENT NOT NULL, class_name VARCHAR(50) NOT NULL, name_teacher VARCHAR(100) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, name_student VARCHAR(100) NOT NULL, address VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, birthday DATE NOT NULL, phone_number DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_classroom (student_id INT NOT NULL, classroom_id INT NOT NULL, INDEX IDX_2E13F11DCB944F1A (student_id), INDEX IDX_2E13F11D6278D5A8 (classroom_id), PRIMARY KEY(student_id, classroom_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student_classroom ADD CONSTRAINT FK_2E13F11DCB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_classroom ADD CONSTRAINT FK_2E13F11D6278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student_classroom DROP FOREIGN KEY FK_2E13F11D6278D5A8');
        $this->addSql('ALTER TABLE student_classroom DROP FOREIGN KEY FK_2E13F11DCB944F1A');
        $this->addSql('DROP TABLE classroom');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE student_classroom');
    }
}
