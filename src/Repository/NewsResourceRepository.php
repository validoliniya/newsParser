<?php

namespace App\Repository;

use App\Entity\NewsResource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewsResource|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsResource|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsResource[]    findAll()
 * @method NewsResource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsResourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsResource::class);
    }

    public function findOneByName(string $name): ? NewsResource
    {
        return $this->findOneBy(['name'=>$name]);
    }
}
