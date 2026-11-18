<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use RuntimeException;

final class Version20261117112359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename categorie to Categorie';
    }

    public function up(Schema $schema): void
    {
        $schemaManager = $this->connection->createSchemaManager();
        $tableNames = $schemaManager->listTableNames();
        $hasLegacyTable = in_array('categorie', $tableNames, true);
        $hasTargetTable = in_array('Categorie', $tableNames, true);

        if ($hasLegacyTable && $hasTargetTable) {
            throw new RuntimeException('Both categorie and Categorie tables exist.');
        }

        if ($hasLegacyTable) {
            $this->addSql('RENAME TABLE categorie TO Categorie');
        }
    }

    public function down(Schema $schema): void
    {
        $schemaManager = $this->connection->createSchemaManager();
        $tableNames = $schemaManager->listTableNames();
        $hasLegacyTable = in_array('categorie', $tableNames, true);
        $hasTargetTable = in_array('Categorie', $tableNames, true);

        if ($hasLegacyTable && $hasTargetTable) {
            throw new RuntimeException('Both categorie and Categorie tables exist.');
        }

        if ($hasTargetTable) {
            $this->addSql('RENAME TABLE Categorie TO categorie');
        }
    }
}
