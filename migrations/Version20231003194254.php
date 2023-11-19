<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use NumberFormatter;

final class Version20231003194254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return "Insert examples into satellites table";
    }

    public function up(Schema $schema): void
    {
        if ($schema->hasTable('satellites')) {
            $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
            for ($i = 1; $i < 10; $i++) {
                $number = $formatter->format($i);
                $this->addSql("INSERT INTO satellites (`domain`, recovery_link, flight_date_label_translation_key)
                            VALUES('domain-$number.com', 'https://{{domain}}/form-recovery?hash={{hash}}', 'flight date');"
                );
            }
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('satellites')) {
            $this->addSql('DELETE FROM satellites');
        }
    }
}
