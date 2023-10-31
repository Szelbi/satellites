<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231031221321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create todos table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE todos (id INT AUTO_INCREMENT NOT NULL, 
                    label VARCHAR(255) NOT NULL, 
                    is_done TINYINT(1) DEFAULT 0 NOT NULL, 
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
                    PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE todos');
    }
}
