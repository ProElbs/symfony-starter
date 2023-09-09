<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230709091100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            INSERT INTO article (title, status, created_at, updated_at) VALUES ('Les Wouapitis font du ski', 'published', now(), now());
            INSERT INTO article (title, status, created_at, updated_at) VALUES ('Lorem ipsum', 'draft', now(), now());
            INSERT INTO article (title, status, created_at, updated_at) VALUES ('Martine apprend les mathématiques', 'published', now(), now());
            INSERT INTO article (title, status, created_at, updated_at) VALUES ('L''histoire d''Hugo', 'published', now(), now());
            ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE article');
    }
}
