<?php

namespace App\Repository\XGSB;

use App\Entity\XGSB\TypePage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypePage>
 *
 * @method TypePage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypePage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypePage[]    findAll()
 * @method TypePage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypePageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypePage::class);
    }

    //    /**
    //     * @return TypePage[] Returns an array of TypePage objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TypePage
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
