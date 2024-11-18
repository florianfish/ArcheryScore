<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241118142122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE archer (id SERIAL NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, numero_licence VARCHAR(255) NOT NULL, club VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE categorie (id SERIAL NOT NULL, code VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE competition (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, date_debut TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_fin TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, lieu VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN competition.date_debut IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN competition.date_fin IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE depart (id SERIAL NOT NULL, competition_id INT NOT NULL, date_depart TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, numero INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1B3EBB087B39D312 ON depart (competition_id)');
        $this->addSql('COMMENT ON COLUMN depart.date_depart IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE depart_archer (depart_id INT NOT NULL, archer_id INT NOT NULL, PRIMARY KEY(depart_id, archer_id))');
        $this->addSql('CREATE INDEX IDX_1B761F5FAE02FE4B ON depart_archer (depart_id)');
        $this->addSql('CREATE INDEX IDX_1B761F5F147940E3 ON depart_archer (archer_id)');
        $this->addSql('CREATE TABLE volee (id SERIAL NOT NULL, depart_id INT NOT NULL, archer_id INT NOT NULL, cible VARCHAR(255) NOT NULL, numero INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B76A3D56AE02FE4B ON volee (depart_id)');
        $this->addSql('CREATE INDEX IDX_B76A3D56147940E3 ON volee (archer_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE depart ADD CONSTRAINT FK_1B3EBB087B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE depart_archer ADD CONSTRAINT FK_1B761F5FAE02FE4B FOREIGN KEY (depart_id) REFERENCES depart (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE depart_archer ADD CONSTRAINT FK_1B761F5F147940E3 FOREIGN KEY (archer_id) REFERENCES archer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE volee ADD CONSTRAINT FK_B76A3D56AE02FE4B FOREIGN KEY (depart_id) REFERENCES depart (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE volee ADD CONSTRAINT FK_B76A3D56147940E3 FOREIGN KEY (archer_id) REFERENCES archer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE depart DROP CONSTRAINT FK_1B3EBB087B39D312');
        $this->addSql('ALTER TABLE depart_archer DROP CONSTRAINT FK_1B761F5FAE02FE4B');
        $this->addSql('ALTER TABLE depart_archer DROP CONSTRAINT FK_1B761F5F147940E3');
        $this->addSql('ALTER TABLE volee DROP CONSTRAINT FK_B76A3D56AE02FE4B');
        $this->addSql('ALTER TABLE volee DROP CONSTRAINT FK_B76A3D56147940E3');
        $this->addSql('DROP TABLE archer');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE competition');
        $this->addSql('DROP TABLE depart');
        $this->addSql('DROP TABLE depart_archer');
        $this->addSql('DROP TABLE volee');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
