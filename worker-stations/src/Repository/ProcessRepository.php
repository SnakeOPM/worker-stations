<?php

namespace App\Repository;

use App\Entity\Process;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Process>
 *
 * @method Process|null find($id, $lockMode = null, $lockVersion = null)
 * @method Process|null findOneBy(array $criteria, array $orderBy = null)
 * @method Process[]    findAll()
 * @method Process[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcessRepository extends ServiceEntityRepository
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $registry)
    {
        $this->entityManager = $entityManager;
        parent::__construct($registry, Process::class);
    }

    public function add(Process $process): void
    {
        $this->entityManager->persist($process);
        $this->entityManager->flush();
    }

    public function remove(Process $process): void
    {
        $this->entityManager->remove($process);
        $this->entityManager->flush();
    }

    public function unlinkAllWorkstations(): void
    {
        $processes = $this->findAll();
        foreach($processes as $process)
        {
            $process->setWorkstationId(null);
            $this->entityManager->persist($process);
        }
        $this->entityManager->flush();
    }
    public function findSmallestProcesses()
    {
        return $this->createQueryBuilder('e')
        ->select('e')
        ->orderBy('e.MemoryReq', 'ASC')
        ->orderBy('e.CPUReq', 'ASC')
        ->getQuery()
        ->getResult();
    }

}
