<?php

namespace App\Repository\XGSB;

use App\Entity\XGSB\SectionPage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SectionPage>
 *
 * @method SectionPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method SectionPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method SectionPage[]    findAll()
 * @method SectionPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionPageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SectionPage::class);
    }

    //    /**
    //     * @return SectionPage[] Returns an array of SectionPage objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SectionPage
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
