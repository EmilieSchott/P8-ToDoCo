<?php

declare(strict_types = 1);

namespace AppBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210828124134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add roles property un the user table and add the admin role to an user with id 1.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL');
        $this->addSql('UPDATE user SET roles = JSON_ARRAY("ROLE_ADMIN") WHERE id=1');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP roles');
    }
}
