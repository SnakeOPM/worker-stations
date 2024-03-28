<?php

namespace App\Controller;

use App\Entity\WorkStation;
use App\Repository\WorkStationRepository;
use App\Service\LoadRebalancer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class DeleteWorkStationController extends AbstractController
{
    #[Route('/workstation/delete',name: 'app_delete_work_station', methods:['DELETE'])]
    public function __invoke(WorkStation $workStation, WorkStationRepository $repository, LoadRebalancer $balancer): JsonResponse
    {
        $isPossible = $repository->isPossibleToDelete($workStation);
        if(!$isPossible){
            return new JsonResponse(['status' => 'error',
        'message' => "can't delete workstation because it would be not enough space for processes"]);
        }
        $repository->remove($workStation);
        $balancer->rebalance();
        return new JsonResponse([['status' => 'ok',
        'content' => [ 'id' => $workStation->getId(), 
        'TotalCpu' => $workStation->getTotalCPU(),
        'TotalMem' => $workStation->getTotalMemory()]]]);
    }
}
