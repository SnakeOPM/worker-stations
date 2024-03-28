<?php

namespace App\Controller;

use App\Entity\WorkStation;
use App\Repository\WorkStationRepository;
use App\Service\LoadRebalancer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CreateWorkStationController extends AbstractController
{
    #[Route(name: 'app_create_work_station', methods:['POST'])]
    public function __invoke(WorkStation $workStation, WorkStationRepository $repository, LoadRebalancer $balancer): JsonResponse
    {
        $repository->add($workStation);
        $balancer->rebalance();
        return new JsonResponse([['status' => 'ok',
        'content' => [ 'id' => $workStation->getId(), 
        'TotalCpu' => $workStation->getTotalCPU(),
        'TotalMem' => $workStation->getTotalMemory()]]]);
    }
}
