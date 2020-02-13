<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @return mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countNbArticles()
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function findLatest($limit)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.post_created_at','DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function articleByNbComments($limit)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.nbcomments', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @method Article[]
     * @throws \Exception
     */
    public function findAllRecent()
    {

        return $this->createQueryBuilder('p')
            ->where('p.post_created_at <= :date')
            ->setParameter('date', new \DateTime(date('Y-m-d H:i:s')))
            ->orderBy('p.post_created_at','DESC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @param $value
//     * @return mixed
//     */
//    public function findByCategory($value)
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.tags = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getResult();
//    }

    /**
     * @param $value
     * @return mixed
     */
    public function findOneByName($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.title = :val')
            ->setParameter('val', $value)
            ->getQuery()
            //->getOneOrNullResult()
            ->getResult()
            ;
    }

    /**
     * @param $value
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function findOneBySlug($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.slug = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
//            ->getResult()
            ;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function findOneByID($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            //->getOneOrNullResult()
            ->getResult()
            ;
    }

    /**
     * @param string $query
     * @param int $limit
     * @return mixed
     */
    public function findAllMatching(string $query, int $limit = 100)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.title LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function findNbArticleByCategory(int $limit = 3)
    {
        return $this->createQueryBuilder('p')
            ->select('count(p.category)')
            ->groupBy('p.category')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
