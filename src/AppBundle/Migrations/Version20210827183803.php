<?php

declare(strict_types = 1);

namespace AppBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210827183803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add user property in Task entity, tasks property in User entity, create an anonymous user and associated all existant tasks to him';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE task ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_527EDB25A76ED395 ON task (user_id)');
        $this->addSql('INSERT INTO user (username, password, email) VALUES ("Anonyme", "$2y$13$fxY0qaXj9krd0Xt4cV3fq.nEWEYd6r1doIfd/Xr4p8NQieNRhHOWy", "anonyme@anonyme.com")');
        $this->addSql('UPDATE task SET user_id = (SELECT id FROM user WHERE username="Anonyme")');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25A76ED395');
        $this->addSql('DROP INDEX IDX_527EDB25A76ED395 ON task');
        $this->addSql('ALTER TABLE task DROP user_id');
    }
}
