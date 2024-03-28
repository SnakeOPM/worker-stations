<?php

namespace App\Controller;

use App\Entity\Process;
use App\Repository\ProcessRepository;
use App\Service\LoadRebalancer;
use App\Service\LoadResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class DeleteProcessController extends AbstractController
{
    #[Route('/delete/process/q', name: 'app_create_process')]
    public function __invoke(Process $process, LoadRebalancer $balancer, ProcessRepository $repository): JsonResponse
    {
        $repository->remove($process);
        $balancer->rebalance();
        return new JsonResponse([['status' => 'ok',
        'content' => [ 'id' => $process->getId(), 
        'TotalCpu' => $process->getCPUReq(),
        'TotalMem' => $process->getMemoryReq(),
        'workstation' => $process->getWorkstationId()]]]);
    }
}
