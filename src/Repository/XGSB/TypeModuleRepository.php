<?php

namespace App\Repository\XGSB;

use App\Entity\XGSB\TypeModule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeModule>
 *
 * @method TypeModule|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeModule|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeModule[]    findAll()
 * @method TypeModule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeModuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeModule::class);
    }

    //    /**
    //     * @return TypeModule[] Returns an array of TypeModule objects
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

    //    public function findOneBySomeField($value): ?TypeModule
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
