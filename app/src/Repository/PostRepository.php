<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

final class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

//    public function getPaginatedPosts(int $page = 1, int $postsPerPage = 9)
//    {
//        $query = $this->createQueryBuilder('a')
//            //->orderBy('a.publishedAt', 'DESC')
//            ->getQuery();
//        $paginator = new Paginator($query);
//        $paginator->getQuery()
//            ->setFirstResult($postsPerPage * ($page - 1))
//            ->setMaxResults($postsPerPage);
//        return $paginator->getIterator();
//    }

    /** @throws Exception */
    public function getAll(): array
    {
        return $this->findAll();
//        return $this->getEntityManager()
//            ->createQuery(
//                'SELECT p FROM AppBundle:Blog'
//            )
//            ->getResult();

//        $sql = 'select * from AppBundle:Blog';
//        dd($this->conn->executeStatement($sql));

//        return $this->getEntityManager()
//            ->createQuery(
//                'SELECT p FROM AppBundle:Product p ORDER BY p.name ASC'
//            )
//            ->getResult();
    }
}
