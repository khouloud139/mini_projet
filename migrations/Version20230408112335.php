<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230408112335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande CHANGE lieu_départ lieudépart VARCHAR(255) NOT NULL, CHANGE date_sortie datesortie DATE NOT NULL, CHANGE heure_depart heuredepart TIME NOT NULL, CHANGE nombre_places nombreplaces INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande CHANGE lieudépart lieu_départ VARCHAR(255) NOT NULL, CHANGE datesortie date_sortie DATE NOT NULL, CHANGE heuredepart heure_depart TIME NOT NULL, CHANGE nombreplaces nombre_places INT NOT NULL');
    }
}
