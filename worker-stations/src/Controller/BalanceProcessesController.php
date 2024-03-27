<?php

namespace App\Controller;

use App\Entity\Process;
use App\Service\LoadRebalancer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BalanceProcessesController extends AbstractController
{
    #[Route(
        path: '/processes/rebalance',
        name: 'app_balance_processes',
        methods:['PATCH'],)]
    public function __invoke(LoadRebalancer $balancer): Response
    {
        $balancer->rebalance();

        return new JsonResponse(["сомнительно, но" => "ok"]);
    }
}
