<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250815113859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE db_candidates (id INT AUTO_INCREMENT NOT NULL, residence_id INT NOT NULL, marital_status_id INT DEFAULT NULL, fist_choice_id INT DEFAULT NULL, second_choice_id INT DEFAULT NULL, sexe_id INT DEFAULT NULL, fac_one_id INT DEFAULT NULL, fact_two_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, place_birth VARCHAR(255) NOT NULL, date_birth DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', urg_name VARCHAR(255) NOT NULL, urg_relation VARCHAR(255) NOT NULL, urg_mail VARCHAR(255) DEFAULT NULL, urg_phone VARCHAR(255) NOT NULL, sc_name VARCHAR(255) NOT NULL, sc_section VARCHAR(255) NOT NULL, sc_country VARCHAR(255) NOT NULL, sc_percentage VARCHAR(255) NOT NULL, father_name VARCHAR(255) DEFAULT NULL, father_mail VARCHAR(255) DEFAULT NULL, father_phone VARCHAR(255) DEFAULT NULL, father_occupation VARCHAR(255) DEFAULT NULL, mother_name VARCHAR(255) DEFAULT NULL, mother_mail VARCHAR(255) DEFAULT NULL, mother_phone VARCHAR(255) DEFAULT NULL, mother_occupation VARCHAR(255) DEFAULT NULL, code INT DEFAULT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', sc_year INT NOT NULL, fist_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, nationality VARCHAR(255) NOT NULL, add_number INT DEFAULT NULL, add_avenue VARCHAR(255) DEFAULT NULL, add_quarter VARCHAR(255) DEFAULT NULL, add_municipality VARCHAR(255) DEFAULT NULL, add_city VARCHAR(255) DEFAULT NULL, slip_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', slip_ref VARCHAR(255) DEFAULT NULL, province_origin VARCHAR(255) DEFAULT NULL, territory_origin VARCHAR(255) DEFAULT NULL, sc_diploma_type VARCHAR(255) NOT NULL, sc_diploma_number VARCHAR(255) DEFAULT NULL, sc_option VARCHAR(255) DEFAULT NULL, sc_diploma_place VARCHAR(255) DEFAULT NULL, sc_diploma_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', sc_code VARCHAR(255) DEFAULT NULL, sc_province VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_67ECBD4577153098 (code), INDEX IDX_67ECBD458B225FBD (residence_id), INDEX IDX_67ECBD45E559F9BF (marital_status_id), INDEX IDX_67ECBD4567DB021 (fist_choice_id), INDEX IDX_67ECBD45A46DE759 (second_choice_id), INDEX IDX_67ECBD45448F3B3C (sexe_id), INDEX IDX_67ECBD45B5CAD810 (fac_one_id), INDEX IDX_67ECBD4554AEB1F3 (fact_two_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE db_conditions (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, img VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F9FD4CE0F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE db_faculties (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE db_marital_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE db_residences (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE db_sectors (id INT AUTO_INCREMENT NOT NULL, faculty_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_EDED5DD2680CAB68 (faculty_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE db_sexes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE db_users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_logs (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, ip VARCHAR(255) NOT NULL, msg VARCHAR(255) NOT NULL, level VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8A0E8A95A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE db_candidates ADD CONSTRAINT FK_67ECBD458B225FBD FOREIGN KEY (residence_id) REFERENCES db_residences (id)');
        $this->addSql('ALTER TABLE db_candidates ADD CONSTRAINT FK_67ECBD45E559F9BF FOREIGN KEY (marital_status_id) REFERENCES db_marital_status (id)');
        $this->addSql('ALTER TABLE db_candidates ADD CONSTRAINT FK_67ECBD4567DB021 FOREIGN KEY (fist_choice_id) REFERENCES db_sectors (id)');
        $this->addSql('ALTER TABLE db_candidates ADD CONSTRAINT FK_67ECBD45A46DE759 FOREIGN KEY (second_choice_id) REFERENCES db_sectors (id)');
        $this->addSql('ALTER TABLE db_candidates ADD CONSTRAINT FK_67ECBD45448F3B3C FOREIGN KEY (sexe_id) REFERENCES db_sexes (id)');
        $this->addSql('ALTER TABLE db_candidates ADD CONSTRAINT FK_67ECBD45B5CAD810 FOREIGN KEY (fac_one_id) REFERENCES db_faculties (id)');
        $this->addSql('ALTER TABLE db_candidates ADD CONSTRAINT FK_67ECBD4554AEB1F3 FOREIGN KEY (fact_two_id) REFERENCES db_faculties (id)');
        $this->addSql('ALTER TABLE db_conditions ADD CONSTRAINT FK_F9FD4CE0F675F31B FOREIGN KEY (author_id) REFERENCES db_users (id)');
        $this->addSql('ALTER TABLE db_sectors ADD CONSTRAINT FK_EDED5DD2680CAB68 FOREIGN KEY (faculty_id) REFERENCES db_faculties (id)');
        $this->addSql('ALTER TABLE user_logs ADD CONSTRAINT FK_8A0E8A95A76ED395 FOREIGN KEY (user_id) REFERENCES db_users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE db_candidates DROP FOREIGN KEY FK_67ECBD458B225FBD');
        $this->addSql('ALTER TABLE db_candidates DROP FOREIGN KEY FK_67ECBD45E559F9BF');
        $this->addSql('ALTER TABLE db_candidates DROP FOREIGN KEY FK_67ECBD4567DB021');
        $this->addSql('ALTER TABLE db_candidates DROP FOREIGN KEY FK_67ECBD45A46DE759');
        $this->addSql('ALTER TABLE db_candidates DROP FOREIGN KEY FK_67ECBD45448F3B3C');
        $this->addSql('ALTER TABLE db_candidates DROP FOREIGN KEY FK_67ECBD45B5CAD810');
        $this->addSql('ALTER TABLE db_candidates DROP FOREIGN KEY FK_67ECBD4554AEB1F3');
        $this->addSql('ALTER TABLE db_conditions DROP FOREIGN KEY FK_F9FD4CE0F675F31B');
        $this->addSql('ALTER TABLE db_sectors DROP FOREIGN KEY FK_EDED5DD2680CAB68');
        $this->addSql('ALTER TABLE user_logs DROP FOREIGN KEY FK_8A0E8A95A76ED395');
        $this->addSql('DROP TABLE db_candidates');
        $this->addSql('DROP TABLE db_conditions');
        $this->addSql('DROP TABLE db_faculties');
        $this->addSql('DROP TABLE db_marital_status');
        $this->addSql('DROP TABLE db_residences');
        $this->addSql('DROP TABLE db_sectors');
        $this->addSql('DROP TABLE db_sexes');
        $this->addSql('DROP TABLE db_users');
        $this->addSql('DROP TABLE user_logs');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
