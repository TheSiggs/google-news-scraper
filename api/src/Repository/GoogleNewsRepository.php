<?php

namespace App\Repository;

use App\Entity\GoogleNews;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GoogleNews>
 *
 * @method GoogleNews|null find($id, $lockMode = null, $lockVersion = null)
 * @method GoogleNews|null findOneBy(array $criteria, array $orderBy = null)
 * @method GoogleNews[]    findAll()
 * @method GoogleNews[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoogleNewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GoogleNews::class);
    }

//    /**
//     * @return GoogleNews[] Returns an array of GoogleNews objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GoogleNews
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
