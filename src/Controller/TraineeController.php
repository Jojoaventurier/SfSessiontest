<?php

namespace App\Controller;

use App\Repository\TraineeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TraineeController extends AbstractController
{
    #[Route('/trainee', name: 'app_trainee')]
    public function index(TraineeRepository $traineeRepository): Response
    {
        $trainees = $traineeRepository->findAll();
        return $this->render('trainee/index.html.twig', [
            'trainees' => $trainees,
        ]);
    }
}
