<?php

declare(strict_types=1);

namespace Api\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190312185329 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE oauth_access_tokens (identifier VARCHAR(80) NOT NULL, expiryDateTime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, userIdentifier UUID NOT NULL, client VARCHAR(255) NOT NULL, scopes JSON NOT NULL, PRIMARY KEY(identifier))');
        $this->addSql('CREATE TABLE oauth_auth_codes (identifier VARCHAR(80) NOT NULL, expiryDateTime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, userIdentifier UUID NOT NULL, client VARCHAR(255) NOT NULL, scopes JSON NOT NULL, redirectUri VARCHAR(255) NOT NULL, PRIMARY KEY(identifier, redirectUri))');
        $this->addSql('CREATE TABLE oauth_refresh_tokens (identifier VARCHAR(80) NOT NULL, access_token_identifier VARCHAR(80) NOT NULL, expiryDateTime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(identifier))');
        $this->addSql('CREATE INDEX IDX_5AB6878E5675DC ON oauth_refresh_tokens (access_token_identifier)');
        $this->addSql('CREATE TABLE users (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, email VARCHAR(255) NOT NULL, password_hash VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('COMMENT ON COLUMN users.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE oauth_refresh_tokens ADD CONSTRAINT FK_5AB6878E5675DC FOREIGN KEY (access_token_identifier) REFERENCES oauth_access_tokens (identifier) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE oauth_refresh_tokens DROP CONSTRAINT FK_5AB6878E5675DC');
        $this->addSql('DROP TABLE oauth_access_tokens');
        $this->addSql('DROP TABLE oauth_auth_codes');
        $this->addSql('DROP TABLE oauth_refresh_tokens');
        $this->addSql('DROP TABLE users');
    }
}
