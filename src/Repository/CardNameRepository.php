<?php

namespace App\Repository;

use App\Entity\CardName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CardName>
 *
 * @method CardName|null find($id, $lockMode = null, $lockVersion = null)
 * @method CardName|null findOneBy(array $criteria, array $orderBy = null)
 * @method CardName[]    findAll()
 * @method CardName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardNameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CardName::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CardName $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(CardName $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function filterCard(?string $order): array{ 
         $query = $this->createQueryBuilder('p');
            if($order){
               $query = $query->orderBy('p.card_value_euros', $order);
                     }
                     $finalQuery = $query->getQuery()
                     ->getResult();
                     
                     return $finalQuery;     }

    // /**
    //  * @return CardName[] Returns an array of CardName objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CardName
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
