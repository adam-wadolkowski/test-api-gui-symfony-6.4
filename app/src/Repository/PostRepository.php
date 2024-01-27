<?php

declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

final class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

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
