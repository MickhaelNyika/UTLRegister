<?php

namespace App\Controller;

use App\Repository\DbConditionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConditionController extends AbstractController
{
    #[Route('/admission', name: 'app_admission')]
    public function index(DbConditionsRepository $repo): Response
    {
        return $this->render('admission/index.html.twig', [
            'data' => $repo->find(1),
        ]);
    }
}
