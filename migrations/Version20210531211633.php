<?php

declare(strict_types=1);
namespace DoctrineMigrations;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\HttpKernel\KernelInterface;
header('charset=utf8');
ini_set('memory_limit', '1024M');
/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210531211633 extends AbstractMigration
{
    public $appKernel;
    public function __constructor(KernelInterface $appKernel)
    {
        $this->appKernel= $appKernel;
    }

    public function up(Schema $schema): void
    {
        $cityList = file_get_contents('./data/city.list.min.json');
        $cities = json_decode($cityList, true);
        $dateObj = new \DateTime('now');
        $datetime = $dateObj->format('Y-m-d H:i:s');
        foreach ($cities as $city ) {
            $quotedString = addslashes($city['name']);
            $this->addSql('INSERT INTO city_collection (name, state, country, reference_id, status, created_at) VALUES("'.$quotedString.'","'. $city['state'] .'","' . $city['country'] . '","' . $city['id'] . '",'.true.',"'.$datetime.'")');
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE FROM city_collection');
    }
}

