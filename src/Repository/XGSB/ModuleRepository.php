<?php

namespace App\Repository\XGSB;

use App\Entity\XGSB\Module;
use App\Entity\XGSB\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Module>
 *
 * @method Module|null find($id, $lockMode = null, $lockVersion = null)
 * @method Module|null findOneBy(array $criteria, array $orderBy = null)
 * @method Module[]    findAll()
 * @method Module[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Module::class);
    }

    /**
     * @param Page $page
     * @return Module|null
     */
    public function findLastOrder(Page $page){
        $qb = $this->createQueryBuilder('m')
            ->orderBy('m.Ordre', "DESC")
            ->setMaxResults(1)
            ->where('m.Page = :page')
            ->setParameter('page', $page->getId())
        ;
        return $qb->getQuery()->getResult();
    }

    /**
     * @param Page $page
     * @param int  $ordre
     * @return Module|null
     */
    public function findModuleByOrdrePage(Page $page, int $ordre){
        $qb = $this->createQueryBuilder('m');
        $qb->where('m.Page = :page')
            ->setParameter('page', $page->getId())
            ->andWhere("m.Ordre = :ordre")
            ->setParameter('ordre', $ordre);
        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param Page $page
     * @param int  $ordre
     * @return Module[]|null
     */
    public function findModuleWithOrdre(Page $page, int $ordre){
        $qb = $this->createQueryBuilder('m');
        $qb->where('m.Page = :page')
            ->andWhere("m.Ordre > :ordre")
            ->setParameter('page', $page->getId())
            ->setParameter('ordre', $ordre)
            ->orderBy("m.Ordre", "ASC")
        ;
        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Module[] Returns an array of Module objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Module
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
