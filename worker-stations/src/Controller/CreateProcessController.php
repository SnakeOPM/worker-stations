<?php

namespace App\Controller;

use App\Entity\Process;
use App\Entity\WorkStation;
use App\Repository\ProcessRepository;
use App\Service\LoadResolver;
use App\Service\LoadRebalancer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CreateProcessController extends AbstractController
{
    #[Route('/create/process', name: 'app_create_process')]
    public function __invoke(Process $process, ProcessRepository $repository, LoadResolver $loadResolver): JsonResponse
    {
        $process = $loadResolver->resolveOptimalWStation($process);
        $repository->add($process);
        return new JsonResponse([['status' => 'ok',
        'content' => [ 'id' => $process->getId(), 
        'TotalCpu' => $process->getCPUReq(),
        'TotalMem' => $process->getMemoryReq(),
        'workstation' => $process->getWorkstationId()]]]);
    }
}
