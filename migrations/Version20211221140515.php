<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211221140515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles_tags (articles_id INTEGER NOT NULL, tags_id INTEGER NOT NULL, PRIMARY KEY(articles_id, tags_id))');
        $this->addSql('CREATE INDEX IDX_354053611EBAF6CC ON articles_tags (articles_id)');
        $this->addSql('CREATE INDEX IDX_354053618D7B4FB4 ON articles_tags (tags_id)');
        $this->addSql('CREATE TABLE tags (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE articles_tags');
        $this->addSql('DROP TABLE tags');
    }
}
