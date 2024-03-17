<?php

namespace App\Controller;

use App\Entity\WorkStation;
use App\Repository\WorkStationRepository;
use App\Service\RebalanceLoad;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreateWorkStationController extends AbstractController
{
    #[Route(name: 'app_create_work_station', methods:['POST'])]
    public function __invoke(WorkStation $workStation, WorkStationRepository $repository, RebalanceLoad $balancer): JsonResponse
    {
       // $balancer->rebalance();
        $repository->add($workStation);
        return new JsonResponse([['status' => 'ok',
        'content' => [ 'id' => $workStation->getId(), 
        'TotalCpu' => $workStation->getTotalCPU(),
        'TotalMem' => $workStation->getTotalMemory()]]]);
    }
}
