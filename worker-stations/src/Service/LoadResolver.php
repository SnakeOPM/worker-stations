<?php

namespace App\Service;
use App\Entity\Process;
use App\Repository\ProcessRepository;
use App\Repository\WorkStationRepository;

class LoadResolver
{
    private $workStationRepository;
    private $processRepository;
    private $loadEvaluator;
    public function __construct(WorkStationRepository $workStationRepository, ProcessRepository $processRepository, LoadEvaluator $loadEvaluator)
    {
        $this->workStationRepository = $workStationRepository;
        $this->processRepository = $processRepository;
        $this->loadEvaluator = $loadEvaluator;
    }
    
    public function resolveOptimalWStation(Process $process): Process
    {
        $cpureq = $process->getCPUReq();
        $memreq = $process->getMemoryReq();
        $stations = $this->workStationRepository->getStationsInASCorder();
        $stations = $this->filterSuitableStations($cpureq, $memreq, $stations);
        foreach($stations as $station)
        {
                $currentLoad = $this->loadEvaluator->getAbsoluteCurrentLoad($station);
                $freeCPU = $station->getTotalCPU() - $currentLoad['currentCPUload'];
                $freeMem = $station->getTotalMemory() - $currentLoad['currentMemLoad'];
                if ($freeCPU >= $cpureq && $freeMem >= $memreq){
                    $process->setWorkstationId($station);
                    break;
                }
             
        }
        if(!$process->getWorkstationId())
        {
            throw new \Exception('No suitable workstation for this process');
        }
        return $process;
    }

    private function filterSuitableStations($cpureq, $memreq, $stations)
    {
        foreach($stations as $id => $station){
            $stationCPU = $station->getTotalCPU();
            $stationMem = $station->getTotalMemory();
            if ($stationCPU >= $cpureq && $stationMem >= $memreq){
                continue;
            }
            unset($stations[$id]);
        }
        return $stations;
        
    }
}
