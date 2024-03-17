<?php

namespace App\Service;
use App\Entity\WorkStation;
use App\Repository\ProcessRepository;
use App\Repository\WorkStationRepository;

//pick optiomal station
class LoadResolver
{
    private $workStationRepository;
    private $processRepository;
    public function __construct(WorkStationRepository $workStationRepository, ProcessRepository $processRepository)
    {
        $this->workStationRepository = $workStationRepository;
        $this->processRepository = $processRepository;
    }
    
    public function pickOptimalWStation(): int
    {
        $stations = $this->workStationRepository->findSmallestStations();
    }
}
