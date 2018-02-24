<?php

namespace App\Repository;

use App\Entity\CurrencyConversion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CurrencyConversion|null find($id, $lockMode = null, $lockVersion = null)
 * @method CurrencyConversion|null findOneBy(array $criteria, array $orderBy = null)
 * @method CurrencyConversion[]    findAll()
 * @method CurrencyConversion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyConversionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CurrencyConversion::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('c')
            ->where('c.something = :value')->setParameter('value', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
