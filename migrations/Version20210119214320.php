<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210119214320 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, sport_id INT NOT NULL, name VARCHAR(255) NOT NULL, nickname VARCHAR(255) DEFAULT NULL, INDEX IDX_B8EE3872AC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE encounter (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, date DATETIME NOT NULL, score_club1 INT NOT NULL, score_club2 INT NOT NULL, has_finished TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE encounter_inter_ecole (id INT AUTO_INCREMENT NOT NULL, encounter_id INT NOT NULL, sport_id INT NOT NULL, tournament_id INT NOT NULL, INDEX IDX_41DAAC53D6E2FADC (encounter_id), INDEX IDX_41DAAC53AC78BCF8 (sport_id), INDEX IDX_41DAAC5333D1A3E7 (tournament_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE goal (id INT AUTO_INCREMENT NOT NULL, encounter_id INT NOT NULL, points INT NOT NULL, scored_at DATETIME NOT NULL, INDEX IDX_FCDCEB2ED6E2FADC (encounter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_flash (id INT AUTO_INCREMENT NOT NULL, published_at DATETIME DEFAULT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inter_ecole (id INT AUTO_INCREMENT NOT NULL, year INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, position_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, height DOUBLE PRECISION NOT NULL, number INT NOT NULL, begin_playing_at DATE NOT NULL, description LONGTEXT DEFAULT NULL, end_playing_at DATE DEFAULT NULL, is_still_playing TINYINT(1) NOT NULL, INDEX IDX_98197A65DD842E46 (position_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position (id INT AUTO_INCREMENT NOT NULL, sport_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_462CE4F5AC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, individual TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE club ADD CONSTRAINT FK_B8EE3872AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE encounter_inter_ecole ADD CONSTRAINT FK_41DAAC53D6E2FADC FOREIGN KEY (encounter_id) REFERENCES encounter (id)');
        $this->addSql('ALTER TABLE encounter_inter_ecole ADD CONSTRAINT FK_41DAAC53AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE encounter_inter_ecole ADD CONSTRAINT FK_41DAAC5333D1A3E7 FOREIGN KEY (tournament_id) REFERENCES inter_ecole (id)');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2ED6E2FADC FOREIGN KEY (encounter_id) REFERENCES encounter (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65DD842E46 FOREIGN KEY (position_id) REFERENCES position (id)');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F5AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE encounter_inter_ecole DROP FOREIGN KEY FK_41DAAC53D6E2FADC');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2ED6E2FADC');
        $this->addSql('ALTER TABLE encounter_inter_ecole DROP FOREIGN KEY FK_41DAAC5333D1A3E7');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65DD842E46');
        $this->addSql('ALTER TABLE club DROP FOREIGN KEY FK_B8EE3872AC78BCF8');
        $this->addSql('ALTER TABLE encounter_inter_ecole DROP FOREIGN KEY FK_41DAAC53AC78BCF8');
        $this->addSql('ALTER TABLE position DROP FOREIGN KEY FK_462CE4F5AC78BCF8');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE encounter');
        $this->addSql('DROP TABLE encounter_inter_ecole');
        $this->addSql('DROP TABLE goal');
        $this->addSql('DROP TABLE info_flash');
        $this->addSql('DROP TABLE inter_ecole');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE position');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE `user`');
    }
}
