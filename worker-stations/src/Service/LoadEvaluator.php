<?php

namespace App\Service;

use App\Entity\WorkStation;

/**
 * сервис для подсчета нагрузки процессов
 */
class LoadEvaluator
{
    public function getAbsoluteCurrentLoad(WorkStation $workStation): array
    {
        $cpuload = 0;
        $memload = 0;
        $processes = $workStation->getProcesses();
        foreach($processes as $process)
        {
            $cpuload += $process->getCPUReq();
            $memload += $process->getMemoryReq();
        }
        return ['currentCPUload' => $cpuload, 'currentMemLoad' => $memload];
    }
    public function getCurrentLoadInPercent(WorkStation $workStation): array
    {
        $maxCPU = $workStation->getTotalCPU();
        $maxMem = $workStation->getTotalMemory();
        $rowLoad = $this->getAbsoluteCurrentLoad($workStation);
        return ['station' => $workStation,
         'currentCPUload' => $rowLoad['currentCPUload'] / $maxCPU * 100,
        'currentMemLoad' => $rowLoad['currentMemLoad'] / $maxMem * 100];  
    }

    public function getWorkstationsloadInPercentArray(array $workStations)
    {
        $result = [];
        foreach($workStations as $workStation)
        {
            $result[] = $this->getCurrentLoadInPercent($workStation);
        }
        return $result; 
    }
}
