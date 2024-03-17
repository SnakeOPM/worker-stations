<?php

namespace App\Repository;

use App\Entity\WorkStation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkStation>
 *
 * @method WorkStation|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkStation|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkStation[]    findAll()
 * @method WorkStation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkStationRepository extends ServiceEntityRepository
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $registry)
    {
        $this->entityManager = $entityManager;
        parent::__construct($registry, WorkStation::class);
    }

    public function add(WorkStation $workStation)
    {
        $this->entityManager->persist($workStation);
        $this->entityManager->flush();
    }

    public function findSmallestStations()
    {
        return $this->createQueryBuilder('e')
        ->select('e')
        ->orderBy('e.TotalMemory', 'ASC')
        ->orderBy('e.TotalCPU', 'ASC')
        ->getQuery()
        ->getResult();
    }
}
