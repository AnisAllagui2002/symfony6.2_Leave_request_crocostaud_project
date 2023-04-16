<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201200328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE leave_resquest ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE leave_resquest ADD CONSTRAINT FK_64727200C54C8C93 FOREIGN KEY (type_id) REFERENCES types_conges (id)');
        $this->addSql('CREATE INDEX IDX_64727200C54C8C93 ON leave_resquest (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE leave_resquest DROP FOREIGN KEY FK_64727200C54C8C93');
        $this->addSql('DROP INDEX IDX_64727200C54C8C93 ON leave_resquest');
        $this->addSql('ALTER TABLE leave_resquest DROP type_id');
    }
}
