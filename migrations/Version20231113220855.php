<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231113220855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add updated_at column in Todo entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE todos ADD updated_at DATETIME NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE todos DROP updated_at');
    }
}
