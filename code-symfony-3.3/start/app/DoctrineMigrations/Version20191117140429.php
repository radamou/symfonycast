<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191117140429 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE sub_family_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE genus_note_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE genus_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_tab_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE genus_scientist_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE sub_family (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE genus_note (id INT NOT NULL, genus_id INT NOT NULL, username VARCHAR(255) NOT NULL, user_avatar_filename VARCHAR(255) NOT NULL, note TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6478FCEC85C4074C ON genus_note (genus_id)');
        $this->addSql('CREATE TABLE genus (id INT NOT NULL, sub_family_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, species_count INT NOT NULL, fun_fact VARCHAR(255) DEFAULT NULL, is_published BOOLEAN NOT NULL, first_discovered_at DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_38C5106E989D9B62 ON genus (slug)');
        $this->addSql('CREATE INDEX IDX_38C5106ED15310D4 ON genus (sub_family_id)');
        $this->addSql('CREATE TABLE user_tab (id INT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles TEXT NOT NULL, is_scientist BOOLEAN NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, avatar_uri VARCHAR(255) DEFAULT NULL, university_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98F52287E7927C74 ON user_tab (email)');
        $this->addSql('COMMENT ON COLUMN user_tab.roles IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE genus_scientist (id INT NOT NULL, genus_id INT NOT NULL, user_id INT NOT NULL, years_studied INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_66CF3FA885C4074C ON genus_scientist (genus_id)');
        $this->addSql('CREATE INDEX IDX_66CF3FA8A76ED395 ON genus_scientist (user_id)');
        $this->addSql('ALTER TABLE genus_note ADD CONSTRAINT FK_6478FCEC85C4074C FOREIGN KEY (genus_id) REFERENCES genus (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE genus ADD CONSTRAINT FK_38C5106ED15310D4 FOREIGN KEY (sub_family_id) REFERENCES sub_family (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE genus_scientist ADD CONSTRAINT FK_66CF3FA885C4074C FOREIGN KEY (genus_id) REFERENCES genus (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE genus_scientist ADD CONSTRAINT FK_66CF3FA8A76ED395 FOREIGN KEY (user_id) REFERENCES user_tab (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE genus DROP CONSTRAINT FK_38C5106ED15310D4');
        $this->addSql('ALTER TABLE genus_note DROP CONSTRAINT FK_6478FCEC85C4074C');
        $this->addSql('ALTER TABLE genus_scientist DROP CONSTRAINT FK_66CF3FA885C4074C');
        $this->addSql('ALTER TABLE genus_scientist DROP CONSTRAINT FK_66CF3FA8A76ED395');
        $this->addSql('DROP SEQUENCE sub_family_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE genus_note_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE genus_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_tab_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE genus_scientist_id_seq CASCADE');
        $this->addSql('DROP TABLE sub_family');
        $this->addSql('DROP TABLE genus_note');
        $this->addSql('DROP TABLE genus');
        $this->addSql('DROP TABLE user_tab');
        $this->addSql('DROP TABLE genus_scientist');
    }
}
