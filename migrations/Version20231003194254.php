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
        return 'Create satellites table';
    }

    public function up(Schema $schema): void
    {
        if (!$schema->hasTable('satellites')) {
            $this->addSql('CREATE TABLE satellites (
                id INT AUTO_INCREMENT NOT NULL, domain VARCHAR(255) NOT NULL, recovery_link TEXT NOT NULL, 
                flight_date_label_translation_key VARCHAR(255) NOT NULL, visa_type_key_name VARCHAR(255) DEFAULT NULL, 
                PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
            );

            $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
            for ($i = 1; $i < 10; $i++) {
                $number = $formatter->format($i);
                $this->addSql("INSERT INTO evisa_express.satellites
                            (`domain`, recovery_link, flight_date_label_translation_key, visa_type_key_name)
                            VALUES('domain-$number.com', 'https://{{domain}}/form-recovery?hash={{hash}}', 'flight date', NULL);"
                );
            }
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('satellites')) {
            $this->addSql('DROP TABLE satellites');
        }
    }
}
