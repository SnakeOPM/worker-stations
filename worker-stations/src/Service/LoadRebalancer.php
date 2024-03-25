<?php

namespace App\Service;
use App\Repository\ProcessRepository;
use App\Repository\WorkStationRepository;
/**
 * сервис для пересчета нагрузки на машины
 */
class LoadRebalancer
{
    private $workStationRepository;
    private $processRepository;
    private $loadResolver;
    public function __construct(WorkStationRepository $workStationRepository, ProcessRepository $processRepository, LoadResolver $loadResolver)
    {
        $this->workStationRepository = $workStationRepository;
        $this->processRepository = $processRepository;
        $this->loadResolver = $loadResolver;

    }
    
    public function rebalance()
    {
        $this->processRepository->unlinkAllWorkstations();
        $processes = $this->processRepository->findAll();

        foreach($processes as $process)
        {
            $stations = $this->workStationRepository->getStationsInASCorder();
            $process = $this->loadResolver->resolveOptimalWStation($process, $stations);
            $this->processRepository->add($process);
        }
    }
}
