<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261118104440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt CHANGE date_retour_reelle date_retour_reelle DATETIME DEFAULT NULL, CHANGE exemplaire_id exemplaire_id INT NOT NULL, CHANGE utilisateur_id utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE exemplaire CHANGE oeuvre_id oeuvre_id INT NOT NULL');
        $this->addSql('ALTER TABLE oeuvre CHANGE type_oeuvre_id type_oeuvre_id INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt CHANGE date_retour_reelle date_retour_reelle DATETIME NOT NULL, CHANGE exemplaire_id exemplaire_id INT DEFAULT NULL, CHANGE utilisateur_id utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exemplaire CHANGE oeuvre_id oeuvre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre CHANGE type_oeuvre_id type_oeuvre_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur');
    }
}
