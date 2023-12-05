<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205073418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE individual_kpi ADD january_target DOUBLE PRECISION DEFAULT NULL, 
    ADD february_target DOUBLE PRECISION DEFAULT NULL, ADD march_target DOUBLE PRECISION DEFAULT NULL, 
    ADD april_target DOUBLE PRECISION DEFAULT NULL, ADD may_target DOUBLE PRECISION DEFAULT NULL, 
    ADD june_target DOUBLE PRECISION DEFAULT NULL, ADD july_target DOUBLE PRECISION DEFAULT NULL, 
    ADD august_target DOUBLE PRECISION DEFAULT NULL, ADD september_target DOUBLE PRECISION DEFAULT NULL, 
    ADD october_target DOUBLE PRECISION DEFAULT NULL, ADD november_target DOUBLE PRECISION DEFAULT NULL, 
    ADD december_target DOUBLE PRECISION DEFAULT NULL, ADD january_result DOUBLE PRECISION DEFAULT NULL, 
    ADD february_result DOUBLE PRECISION DEFAULT NULL, ADD march_result DOUBLE PRECISION DEFAULT NULL, 
    ADD april_result DOUBLE PRECISION DEFAULT NULL, ADD may_result DOUBLE PRECISION DEFAULT NULL, 
    ADD june_result DOUBLE PRECISION DEFAULT NULL, ADD july_resutl DOUBLE PRECISION DEFAULT NULL, 
    ADD august_result DOUBLE PRECISION DEFAULT NULL, ADD september_result DOUBLE PRECISION DEFAULT NULL, 
    ADD october_result DOUBLE PRECISION DEFAULT NULL, ADD november_result DOUBLE PRECISION DEFAULT NULL, 
    ADD december_result DOUBLE PRECISION DEFAULT NULL, ADD january_status INT DEFAULT NULL, 
    ADD february_status INT DEFAULT NULL, ADD march_status INT DEFAULT NULL, ADD april_status INT DEFAULT NULL, 
    ADD may_status INT DEFAULT NULL, ADD june_status INT DEFAULT NULL, ADD july_status INT DEFAULT NULL, 
    ADD august_status INT DEFAULT NULL, ADD september_status INT DEFAULT NULL, ADD october_status INT DEFAULT NULL, 
    ADD november_status INT DEFAULT NULL, ADD december_status INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE individual_kpi DROP january_target, 
        DROP february_target, DROP march_target, DROP april_target, DROP may_target, 
        DROP june_target, DROP july_target, DROP august_target, 
        DROP september_target, DROP october_target, DROP november_target, 
        DROP december_target, DROP january_result, DROP february_result, 
        DROP march_result, DROP april_result, DROP may_result, DROP june_result, 
        DROP july_resutl, DROP august_result, DROP september_result, DROP october_result, 
        DROP november_result, DROP december_result, DROP january_status, DROP february_status, 
        DROP march_status, DROP april_status, DROP may_status, DROP june_status, DROP july_status, 
        DROP august_status, DROP september_status, DROP october_status, DROP november_status, 
        DROP december_status');
    }
}
