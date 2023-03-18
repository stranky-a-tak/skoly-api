<?php

namespace App\Repository;

use App\Entity\Collage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Collage>
 *
 * @method Collage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collage[]    findAll()
 * @method Collage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Collage::class);
    }

    public function save(Collage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Collage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getSearchResult(string $query): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.name LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->setMaxResults(8)
            ->getQuery()
            ->getArrayResult();
    }
}
