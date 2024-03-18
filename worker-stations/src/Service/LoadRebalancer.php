<?php

namespace App\Service;
use App\Repository\ProcessRepository;
use App\Repository\WorkStationRepository;

class LoadRebalancer
{
    private $workStationRepository;
    private $processRepository;
    public function __construct(WorkStationRepository $workStationRepository, ProcessRepository $processRepository)
    {
        $this->workStationRepository = $workStationRepository;
        $this->processRepository = $processRepository;
    }
    
    public function rebalance()
    {
        dd($this->workStationRepository->getStationsInASCorder());
    }
}
