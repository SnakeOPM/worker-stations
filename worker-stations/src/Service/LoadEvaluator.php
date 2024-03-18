<?php

namespace App\Service;

use App\Entity\WorkStation;

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

    public function getCurrentLoadInPercent(WorkStation $workStation)
    {
        $rowLoad = $this->getAbsoluteCurrentLoad($workStation); //todo: сделать нагрузку в процентах, и назначать процесс на минимально нагруженную в них, а ребалансировку делать за счет поиска масимально нагрженной машины и противположной и их переброска
    }
}
