<?php

namespace App\Repository;

use App\Entity\Process;
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

    public function add(WorkStation $workStation): void
    {
        $this->entityManager->persist($workStation);
        $this->entityManager->flush();
    }

    public function remove(WorkStation $workStation): void
    {
        $processes = $workStation->getProcesses();
        foreach($processes as $process){
            $workStation->removeProcess($process);
        }
        $this->entityManager->remove($workStation);
        $this->entityManager->flush();
    }

    public function getStationsInASCorder()
    {
        return $this->createQueryBuilder('e')
        ->select('e')
        ->orderBy('e.TotalMemory', 'ASC')
        ->orderBy('e.TotalCPU', 'ASC')
        ->getQuery()
        ->getResult();
    }

    public function isPossibleToDelete(WorkStation $workStation)
    {
        $stations = $this->findAll();
        $processes = $this->entityManager->getRepository(Process::class)->findAll();
        $stationsCPUs = 0;
        $stationsMem = 0;
        $processesCPUs = 0;
        $processesMem = 0;
        foreach ($stations as $station)
        {
            $stationsCPUs += $station->getTotalCPU();
            $stationsMem += $station->getTotalMemory();
        }
        foreach ($processes as $process)
        {
            $processesCPUs += $process->getCPUReq();
            $processesMem += $process->getMemoryReq();
        }
        $checkCPUs = $stationsCPUs - $workStation->getTotalCPU() >= $processesCPUs;
        $checkMem = $stationsMem - $workStation->getTotalMemory() >= $processesMem;
        return ($checkCPUs && $checkMem)? true : false;

    }
}
