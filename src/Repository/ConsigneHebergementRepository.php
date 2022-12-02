<?php

namespace App\Repository;

use App\Entity\ConsigneHebergement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConsigneHebergement>
 *
 * @method ConsigneHebergement|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConsigneHebergement|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConsigneHebergement[]    findAll()
 * @method ConsigneHebergement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsigneHebergementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConsigneHebergement::class);
    }

    public function add(ConsigneHebergement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConsigneHebergement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConsigneHebergement[] Returns an array of ConsigneHebergement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ConsigneHebergement
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
