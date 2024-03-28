<?php

namespace App\Controller;

use App\Entity\WorkStation;
use App\Service\LoadEvaluator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GetPercentLoadsController extends AbstractController
{
    #[Route('/get/percent/loads', name: 'app_get_percent_loads', methods:['GET'])]
    public function __invoke(EntityManagerInterface $em, LoadEvaluator $eval): JsonResponse
    {
        $response = [];
        $stations = $em->getRepository(WorkStation::class)->findAll();
        foreach($stations as $station)
        {
            $response[] = $eval->getCurrentLoadInPercent($station);
        }

        return new JsonResponse(['status' => 'ok',
    'body' => $response]);
    }
}
