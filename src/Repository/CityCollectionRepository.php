<?php

namespace App\Repository;

use App\Entity\CityCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CityCollection|null find($id, $lockMode = null, $lockVersion = null)
 * @method CityCollection|null findOneBy(array $criteria, array $orderBy = null)
 * @method CityCollection[]    findAll()
 * @method CityCollection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityCollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CityCollection::class);
    }

    public function findMatchingCity($cityName, $limit, $country=null)
    {
        if($country) {
            return $this->createQueryBuilder('c')
            ->andWhere('c.name like :val')
            ->andWhere('c.country = :country')
            ->setParameter('val', $cityName.'%')
            ->setParameter('country', $country)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        } else {
            return $this->createQueryBuilder('c')
            ->andWhere('c.name like :val')
            ->setParameter('val', $cityName.'%')
            ->getQuery()
            ->getResult();
        }
   
    }
}
